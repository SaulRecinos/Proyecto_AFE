<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportsController extends Controller
{
    public function __construct(
        private readonly ReportService $reports
    ) {}

    public function index(): View
    {
        return view('reports.index', [
            'kpis' => $this->reports->kpis(),
            'salesByPeriod' => $this->reports->salesByPeriod(),
            'invoicesByStatus' => $this->reports->invoicesByPaymentStatus(),
            'stockByCategory' => $this->reports->stockByCategory(),
            'topProducts' => $this->reports->topSellingProducts(),
            'movementsByType' => $this->reports->movementsByType(),
        ]);
    }

    public function lowStock(Request $request): View
    {
        $threshold = max(1, (int) $request->query('threshold', ReportService::LOW_STOCK_THRESHOLD));

        return view('reports.low-stock', [
            'threshold' => $threshold,
            'products' => $this->reports->lowStockProducts($threshold),
            'stockByCategory' => $this->reports->stockByCategory(),
        ]);
    }

    public function sales(): View
    {
        $sales = $this->reports->salesByPeriod(24);

        return view('reports.sales', [
            'sales' => $sales,
            'totalGeneral' => $sales->sum('totalSales'),
        ]);
    }

    public function pending(): View
    {
        $invoices = $this->reports->pendingInvoices();

        return view('reports.pending', [
            'invoices' => $invoices,
            'totalPending' => $invoices->sum('totalAmount'),
        ]);
    }
}
