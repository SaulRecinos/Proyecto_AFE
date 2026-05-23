<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Concerns\ErpControllerHelpers;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\InventoryMovement;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\PaymentMethods;
use App\Models\PaymentStatuses;
use App\Models\Product;
use App\Services\AuditService;
use App\Services\InventoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use InvalidArgumentException;

class InvoicesController extends Controller
{
    use ErpControllerHelpers;

    public function index(): View
    {
        $invoices = Invoice::query()
            ->with(['customer', 'paymentStatus', 'paymentMethod', 'seller'])
            ->orderByDesc('issueDate')
            ->get();

        return view('billing.invoices.index', compact('invoices'));
    }

    public function create(): View
    {
        $customers = Customer::query()->where('isActive', true)->orderBy('fullName')->get();
        $paymentStatuses = PaymentStatuses::query()->where('isActive', true)->orderBy('name')->get();
        $paymentMethods = PaymentMethods::query()->where('isActive', true)->orderBy('name')->get();
        $products = Product::query()->where('isActive', true)->orderBy('name')->get();

        return view('billing.invoices.create', compact('customers', 'paymentStatuses', 'paymentMethods', 'products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customerId' => ['required', 'integer', 'exists:customers,id'],
            'paymentStatusId' => ['required', 'integer', 'exists:paymentStatuses,id'],
            'paymentMethodId' => ['required', 'integer', 'exists:paymentMethods,id'],
            'issueDate' => ['required', 'date'],
            'lines' => ['required', 'array', 'min:1'],
            'lines.*.productId' => ['required', 'integer', 'exists:products,id'],
            'lines.*.quantity' => ['required', 'integer', 'min:1'],
            'lines.*.unitPrice' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            $invoice = DB::transaction(function () use ($validated) {
                $actor = $this->actorId();
                $total = 0;
                $linesData = [];

                foreach ($validated['lines'] as $line) {
                    $product = Product::query()->lockForUpdate()->findOrFail($line['productId']);
                    if ($product->currentStock < (int) $line['quantity']) {
                        throw new InvalidArgumentException("Stock insuficiente para «{$product->name}».");
                    }
                    $lineTotal = round((float) $line['unitPrice'] * (int) $line['quantity'], 2);
                    $total += $lineTotal;
                    $linesData[] = [
                        'product' => $product,
                        'productId' => $product->id,
                        'quantity' => (int) $line['quantity'],
                        'unitPrice' => $line['unitPrice'],
                        'lineTotal' => $lineTotal,
                    ];
                }

                $invoice = Invoice::create([
                    'customerId' => $validated['customerId'],
                    'sellerId' => $actor,
                    'paymentStatusId' => $validated['paymentStatusId'],
                    'paymentMethodId' => $validated['paymentMethodId'],
                    'invoiceNumber' => $this->nextInvoiceNumber(),
                    'issueDate' => $validated['issueDate'],
                    'totalAmount' => round($total, 2),
                    'isActive' => true,
                    'createdBy' => $actor,
                    'updatedBy' => $actor,
                ]);

                $outTypeId = InventoryService::outTypeId();

                foreach ($linesData as $line) {
                    InvoiceDetail::create([
                        'invoiceId' => $invoice->id,
                        'productId' => $line['productId'],
                        'quantity' => $line['quantity'],
                        'unitPrice' => $line['unitPrice'],
                        'lineTotal' => $line['lineTotal'],
                    ]);

                    $movement = InventoryMovement::create([
                        'productId' => $line['productId'],
                        'movementTypeId' => $outTypeId,
                        'quantity' => $line['quantity'],
                        'reason' => 'Factura '.$invoice->invoiceNumber,
                        'isActive' => true,
                        'createdBy' => $actor,
                        'updatedBy' => $actor,
                    ]);

                    InventoryService::applyMovement($movement);
                }

                return $invoice->load('details.product');
            });

            AuditService::logInsert($invoice, 'invoices');
        } catch (InvalidArgumentException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('billing.invoices.show', $invoice)->with('success', 'Factura creada correctamente.');
    }

    public function show(Invoice $invoice): View
    {
        $invoice->load(['customer', 'seller', 'paymentStatus', 'paymentMethod', 'details.product']);

        return view('billing.invoices.show', compact('invoice'));
    }

    public function destroy(Invoice $invoice): RedirectResponse
    {
        return redirect()->route('billing.invoices.index')
            ->with('error', 'Las facturas emitidas no se eliminan desde el sistema. Anule el documento cambiando su estado.');
    }

    private function nextInvoiceNumber(): string
    {
        $prefix = 'FAC-'.now()->format('Ymd');
        $last = Invoice::query()
            ->where('invoiceNumber', 'like', $prefix.'-%')
            ->orderByDesc('id')
            ->value('invoiceNumber');

        $seq = 1;
        if ($last && preg_match('/-(\d+)$/', $last, $m)) {
            $seq = (int) $m[1] + 1;
        }

        return sprintf('%s-%04d', $prefix, $seq);
    }
}
