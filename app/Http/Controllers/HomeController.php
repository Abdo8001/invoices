<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       $totalInvoices=invoices::sum('Total');
       $invoiceCount=invoices::count();
       $invoice_paid_Count=invoices::where('Value_Status','1')->count();
       $invoice_part_paid_Count=invoices::where('Value_Status','3')->count();
       $invoice_unpaid_Count=invoices::where('Value_Status','2')->count();
       $paidInvoices=invoices::where('Value_Status','1')->sum('Total');
       $part_PaidInvoices=invoices::where('Value_Status','3')->sum('Total');
       $unpaidInvoices=invoices::where('Value_Status','2')->sum('Total');
       $paid_percentage=($invoice_paid_Count/$invoiceCount)*100;
       $unpaid_percentage=($invoice_unpaid_Count/$invoiceCount)*100;
       $paid_part_percentage=($invoice_part_paid_Count/$invoiceCount)*100;
       //=================احصائية نسبة تنفيذ الحالات=====================


        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$unpaid_percentage]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#81b214'],
                    'data' => [$paid_percentage]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$paid_part_percentage]
                ],


            ])
            ->options([]);


        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                    'data' => [$unpaid_percentage, $paid_percentage,$paid_part_percentage]
                ]
            ])
            ->options([]);

        return view('home',['totalInvoices'=>$totalInvoices,'invoiceCount'=>$invoiceCount,'invoice_paid_Count'=>$invoice_paid_Count,'invoice_unpaid_Count'=>$invoice_unpaid_Count,'paidInvoices'=>$paidInvoices,'unpaidInvoices'=>$unpaidInvoices,'paid_percentage'=>$paid_percentage,'unpaid_percentage'=>$unpaid_percentage,'invoice_part_paid_Count'=>$invoice_part_paid_Count,'part_PaidInvoices'=>$part_PaidInvoices,'paid_part_percentage'=>$paid_part_percentage,'chartjs'=>$chartjs,'chartjs_2'=>$chartjs_2]);
    }
}
