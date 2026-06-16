<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Exports\SuccessOrderExport;
use App\Http\Requests\AccountLedgerRequest;
use App\Models\Order;
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
