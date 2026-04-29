<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(){
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
            'to_date'   => 'required|date',
            'partner'   => 'required|string'
        ]);

        $fileName = $request->partner.'-'.date("Y-m-d").time().'-report.xlsx';

        return Excel::download(
            new ReportExport(
                $request->from_date,
                $request->to_date,
                $request->partner
            ),
            $fileName
        );
    }
}
