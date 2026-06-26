<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Exports\SuccessOrderExport;
use App\Http\Requests\AccountLedgerRequest;
use App\Http\Requests\ProductAnalyticsRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        $deliveryPartners = Order::select('awb_partner')
            ->whereNotNull('awb_partner')
            ->groupBy('awb_partner')
            ->pluck('awb_partner');

        return view('report.index', compact('deliveryPartners'));
    }

    public function accountLedger(AccountLedgerRequest $request)
    {
        abort_unless(auth()->user()?->can('isAdmin') || auth()->user()?->can('isSubadmin'), 403);

        $filters = $request->validated();

        $ledgerQuery = Order::query()->financialLedger();
        $this->applyLedgerDateFilters(
            query: $ledgerQuery,
            fromDate: $filters['from_date'] ?? null,
            toDate: $filters['to_date'] ?? null,
        );

        $summary = $this->buildLedgerSummary(clone $ledgerQuery);
        $ledgerEntries = (clone $ledgerQuery)
            ->with(['user:id,name,email'])
            ->select([
                'id',
                'user_id',
                'order_number',
                'billing_name',
                'billing_email',
                'order_date',
                'total',
                'refunded_amount',
                'payment_status',
                'order_status',
                'payment_method',
            ])
            ->orderByDesc('order_date')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('report.account_ledger', [
            'ledgerEntries' => $ledgerEntries,
            'summary' => $summary,
            'periodLabel' => $this->ledgerPeriodLabel(
                fromDate: $filters['from_date'] ?? null,
                toDate: $filters['to_date'] ?? null,
            ),
        ]);
    }

    public function productAnalytics(ProductAnalyticsRequest $request)
    {
        abort_unless(auth()->user()?->can('isAdmin') || auth()->user()?->can('isSubadmin'), 403);

        $filters = $request->validated();
        $fromDate = $filters['from_date'] ?? null;
        $toDate = $filters['to_date'] ?? null;
        $baseQuery = $this->productAnalyticsBaseQuery($fromDate, $toDate);

        $productReports = (clone $baseQuery)
            ->selectRaw('order_items.product_id')
            ->selectRaw('order_items.price_attribute_id')
            ->selectRaw("COALESCE(products.name, NULLIF(order_items.product_name, ''), 'Deleted product') as product_name")
            ->selectRaw('product_price_attributes.name as attribute_name')
            ->selectRaw("SUM(CASE WHEN orders.payment_status = 'success' AND orders.order_status != 'cancelled' THEN COALESCE(order_items.quantity, 0) ELSE 0 END) as quantity_sold")
            ->selectRaw("SUM(CASE WHEN orders.payment_status = 'success' AND orders.order_status != 'cancelled' THEN COALESCE(order_items.total, 0) ELSE 0 END) as total_sales")
            ->selectRaw("COUNT(DISTINCT CASE WHEN orders.payment_status = 'success' AND orders.order_status != 'cancelled' THEN orders.id END) as orders_count")
            ->selectRaw("SUM(CASE WHEN orders.payment_status = 'refunded' THEN COALESCE(order_items.quantity, 0) ELSE 0 END) as refunded_quantity")
            ->groupBy('order_items.product_id', 'order_items.price_attribute_id', 'order_items.product_name', 'products.name', 'product_price_attributes.name')
            ->havingRaw("SUM(CASE WHEN orders.payment_status = 'success' AND orders.order_status != 'cancelled' THEN COALESCE(order_items.quantity, 0) ELSE 0 END) > 0 OR SUM(CASE WHEN orders.payment_status = 'refunded' THEN COALESCE(order_items.quantity, 0) ELSE 0 END) > 0")
            ->orderByDesc('quantity_sold')
            ->orderByDesc('total_sales')
            ->get();

        $dailyReports = (clone $baseQuery)
            ->selectRaw('DATE(orders.order_date) as sold_on')
            ->selectRaw("SUM(CASE WHEN orders.payment_status = 'success' AND orders.order_status != 'cancelled' THEN COALESCE(order_items.quantity, 0) ELSE 0 END) as quantity_sold")
            ->selectRaw("SUM(CASE WHEN orders.payment_status = 'success' AND orders.order_status != 'cancelled' THEN COALESCE(order_items.total, 0) ELSE 0 END) as total_sales")
            ->selectRaw("COUNT(DISTINCT CASE WHEN orders.payment_status = 'success' AND orders.order_status != 'cancelled' THEN orders.id END) as orders_count")
            ->selectRaw("SUM(CASE WHEN orders.payment_status = 'refunded' THEN COALESCE(order_items.quantity, 0) ELSE 0 END) as refunded_quantity")
            ->groupByRaw('DATE(orders.order_date)')
            ->orderByDesc('sold_on')
            ->get();

        $topProductsByDate = (clone $baseQuery)
            ->where('orders.payment_status', 'success')
            ->where('orders.order_status', '!=', 'cancelled')
            ->selectRaw('DATE(orders.order_date) as sold_on')
            ->selectRaw('order_items.price_attribute_id')
            ->selectRaw("COALESCE(products.name, NULLIF(order_items.product_name, ''), 'Deleted product') as product_name")
            ->selectRaw('product_price_attributes.name as attribute_name')
            ->selectRaw('SUM(COALESCE(order_items.quantity, 0)) as quantity_sold')
            ->groupByRaw('DATE(orders.order_date)')
            ->groupBy('order_items.product_id', 'order_items.price_attribute_id', 'order_items.product_name', 'products.name', 'product_price_attributes.name')
            ->get()
            ->groupBy('sold_on')
            ->map(fn ($rows) => $rows->sortByDesc('quantity_sold')->first());

        $totalQuantitySold = (int) $productReports->sum(fn ($report) => (int) $report->quantity_sold);
        $totalProductSales = (float) $productReports->sum(fn ($report) => (float) $report->total_sales);
        $refundedQuantity = (int) $productReports->sum(fn ($report) => (int) $report->refunded_quantity);
        $topProduct = $productReports->first(fn ($report) => (int) $report->quantity_sold > 0);

        return view('report.product_analytics', [
            'productReports' => $productReports,
            'dailyReports' => $dailyReports,
            'topProductsByDate' => $topProductsByDate,
            'summary' => [
                'active_products' => $productReports->filter(fn ($report) => (int) $report->quantity_sold > 0)->count(),
                'quantity_sold' => $totalQuantitySold,
                'refunded_quantity' => $refundedQuantity,
                'total_sales' => $totalProductSales,
                'average_unit_price' => $totalQuantitySold > 0 ? $totalProductSales / $totalQuantitySold : 0,
                'top_product_name' => $this->productAnalyticsDisplayName($topProduct),
                'top_product_quantity' => $topProduct ? (int) $topProduct->quantity_sold : 0,
            ],
            'periodLabel' => $this->ledgerPeriodLabel($fromDate, $toDate),
            'maxProductQuantity' => max(1, (int) $productReports->max('quantity_sold')),
            'maxDailyQuantity' => max(1, (int) $dailyReports->max('quantity_sold')),
        ]);
    }

    public function export(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'partner' => 'required|string',
        ]);

        $fileName = $request->partner.'-'.date('Y-m-d').time().'-report.xlsx';

        return Excel::download(
            new ReportExport(
                $request->from_date,
                $request->to_date,
                $request->partner
            ),
            $fileName
        );
    }

    public function success_order()
    {
        return view('report.success_order');
    }

    public function success_order_export(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);

        $fileName = 'success-order-'.date('Y-m-d').time().'-report.xlsx';

        return Excel::download(
            new SuccessOrderExport(
                $request->from_date,
                $request->to_date,
            ),
            $fileName
        );
    }

    private function applyLedgerDateFilters(Builder $query, ?string $fromDate, ?string $toDate): void
    {
        if ($fromDate) {
            $query->where('order_date', '>=', Carbon::parse($fromDate)->startOfDay());
        }

        if ($toDate) {
            $query->where('order_date', '<=', Carbon::parse($toDate)->endOfDay());
        }
    }

    private function productAnalyticsBaseQuery(?string $fromDate, ?string $toDate): Builder
    {
        $query = OrderItem::query()
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('product_price_attributes', 'order_items.price_attribute_id', '=', 'product_price_attributes.id')
            ->where(function (Builder $query): void {
                $query->where(function (Builder $query): void {
                    $query->where('orders.payment_status', 'success')
                        ->where('orders.order_status', '!=', 'cancelled');
                })->orWhere('orders.payment_status', 'refunded');
            });

        $this->applyProductAnalyticsDateFilters($query, $fromDate, $toDate);

        return $query;
    }

    private function productAnalyticsDisplayName(?object $report): ?string
    {
        if (! $report) {
            return null;
        }

        if (blank($report->attribute_name)) {
            return $report->product_name;
        }

        return $report->product_name.' - '.$report->attribute_name;
    }

    private function applyProductAnalyticsDateFilters(Builder $query, ?string $fromDate, ?string $toDate): void
    {
        if ($fromDate) {
            $query->where('orders.order_date', '>=', Carbon::parse($fromDate)->startOfDay());
        }

        if ($toDate) {
            $query->where('orders.order_date', '<=', Carbon::parse($toDate)->endOfDay());
        }
    }

    /**
     * @return array{
     *     entries_count: int,
     *     successful_orders: int,
     *     refunded_orders: int,
     *     gross_sales: float,
     *     refund_amount: float,
     *     net_collection: float
     * }
     */
    private function buildLedgerSummary(Builder $query): array
    {
        $entriesCount = (clone $query)->count();
        $successfulOrders = (clone $query)->where('payment_status', 'success')->count();
        $refundedOrders = (clone $query)->where('payment_status', 'refunded')->count();
        $grossSales = (float) (clone $query)->sum('total');
        $refundAmount = (float) (clone $query)->where('payment_status', 'refunded')->sum('refunded_amount');
        $netCollection = max(0, $grossSales - $refundAmount);

        return [
            'entries_count' => $entriesCount,
            'successful_orders' => $successfulOrders,
            'refunded_orders' => $refundedOrders,
            'gross_sales' => $grossSales,
            'refund_amount' => $refundAmount,
            'net_collection' => $netCollection,
        ];
    }

    private function ledgerPeriodLabel(?string $fromDate, ?string $toDate): string
    {
        if ($fromDate && $toDate) {
            return Carbon::parse($fromDate)->format('d M Y').' to '.Carbon::parse($toDate)->format('d M Y');
        }

        if ($fromDate) {
            return 'From '.Carbon::parse($fromDate)->format('d M Y');
        }

        if ($toDate) {
            return 'Up to '.Carbon::parse($toDate)->format('d M Y');
        }

        return 'All time';
    }
}
