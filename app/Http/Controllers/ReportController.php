<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Exports\SuccessOrderExport;
use App\Models\Order;
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
}
