<?php

namespace App\Http\Controllers;
use App\Models\sections;
use App\Models\invoices;

use Illuminate\Http\Request;

class Customer_Report_Controller extends Controller
{
    public function index(){
        $sections=sections::all();
        return view('reports.customers_report',compact('sections'));

    }
    public function get_Customers(Request $request){
    // at not spacific date only section and product name
    if($request->Section&&$request->product&&$request->start_at==''&&$request->end_at==''){

        $invoices=invoices::select('*')->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
        $sections=sections::all();

        return view('reports.customers_report',compact('sections'))->withDetails($invoices);

    }else{
          // في حالة البحث بتاريخ
         $star_At=date($request->start_at);
         $end_At=date($request->end_at);
         $invoices=invoices::select('*')->whereBetween('invoice_Date',[$star_At,$end_At])->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
         $sections=sections::all();
         return view('reports.customers_report',compact('sections'))->withDetails($invoices);


        }

    }
}
