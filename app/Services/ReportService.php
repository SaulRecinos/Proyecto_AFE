<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\InventoryMovement;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\PaymentStatuses;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public const LOW_STOCK_THRESHOLD = 10;

    /**
     * @return array<string, int|float>
     */
    public function kpis(): array
    {
        $pendingStatusId = PaymentStatuses::query()->where('code', 'PEND')->value('id');

        return [
            'totalSales' => (float) Invoice::query()->where('isActive', true)->sum('totalAmount'),
            'invoiceCount' => Invoice::query()->where('isActive', true)->count(),
            'pendingInvoices' => $pendingStatusId
                ? Invoice::query()->where('isActive', true)->where('paymentStatusId', $pendingStatusId)->count()
                : 0,
            'lowStockCount' => Product::query()
                ->where('isActive', true)
                ->where('currentStock', '<=', self::LOW_STOCK_THRESHOLD)
                ->count(),
            'customerCount' => Customer::query()->where('isActive', true)->count(),
            'productCount' => Product::query()->where('isActive', true)->count(),
        ];
    }

    public function salesByPeriod(int $months = 12): Collection
    {
        $periodExpr = $this->monthExpression('issueDate');

        return Invoice::query()
            ->select(
                DB::raw("{$periodExpr} as period"),
                DB::raw('COUNT(*) as invoiceCount'),
                DB::raw('SUM(totalAmount) as totalSales')
            )
            ->where('isActive', true)
            ->groupBy('period')
            ->orderBy('period')
            ->limit($months)
            ->get();
    }

    public function invoicesByPaymentStatus(): Collection
    {
        return Invoice::query()
            ->join('paymentStatuses', 'invoices.paymentStatusId', '=', 'paymentStatuses.id')
            ->where('invoices.isActive', true)
            ->select(
                'paymentStatuses.name as label',
                'paymentStatuses.code as code',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('paymentStatuses.id', 'paymentStatuses.name', 'paymentStatuses.code')
            ->orderByDesc('total')
            ->get();
    }

    public function stockByCategory(): Collection
    {
        return Product::query()
            ->join('categories', 'products.categoryId', '=', 'categories.id')
            ->where('products.isActive', true)
            ->select(
                'categories.name as label',
                DB::raw('SUM(products.currentStock) as totalStock'),
                DB::raw('COUNT(products.id) as productCount')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('totalStock')
            ->get();
    }

    public function lowStockProducts(int $threshold = self::LOW_STOCK_THRESHOLD, int $limit = 20): Collection
    {
        return Product::query()
            ->with('category')
            ->where('isActive', true)
            ->where('currentStock', '<=', $threshold)
            ->orderBy('currentStock')
            ->limit($limit)
            ->get();
    }

    public function topSellingProducts(int $limit = 10): Collection
    {
        return InvoiceDetail::query()
            ->join('products', 'invoiceDetails.productId', '=', 'products.id')
            ->join('invoices', 'invoiceDetails.invoiceId', '=', 'invoices.id')
            ->where('invoices.isActive', true)
            ->select(
                'products.name as label',
                'products.sku',
                DB::raw('SUM(invoiceDetails.quantity) as unitsSold'),
                DB::raw('SUM(invoiceDetails.lineTotal) as revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->orderByDesc('unitsSold')
            ->limit($limit)
            ->get();
    }

    public function movementsByType(int $days = 30): Collection
    {
        $since = now()->subDays($days);

        return InventoryMovement::query()
            ->join('movementTypes', 'inventoryMovements.movementTypeId', '=', 'movementTypes.id')
            ->where('inventoryMovements.isActive', true)
            ->where('inventoryMovements.createdAt', '>=', $since)
            ->select(
                'movementTypes.name as label',
                'movementTypes.code as code',
                DB::raw('COUNT(*) as movementCount'),
                DB::raw('SUM(inventoryMovements.quantity) as totalQuantity')
            )
            ->groupBy('movementTypes.id', 'movementTypes.name', 'movementTypes.code')
            ->orderByDesc('movementCount')
            ->get();
    }

    public function pendingInvoices(): Collection
    {
        $pendingStatusId = PaymentStatuses::query()->where('code', 'PEND')->value('id');

        return Invoice::query()
            ->with(['customer', 'paymentStatus'])
            ->where('isActive', true)
            ->when($pendingStatusId, fn ($q) => $q->where('paymentStatusId', $pendingStatusId))
            ->orderByDesc('issueDate')
            ->get();
    }

    private function monthExpression(string $column): string
    {
        return match (DB::connection()->getDriverName()) {
            'sqlite' => "strftime('%Y-%m', {$column})",
            default => "DATE_FORMAT({$column}, '%Y-%m')",
        };
    }
}
