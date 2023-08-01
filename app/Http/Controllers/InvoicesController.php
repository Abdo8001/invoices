<?php

namespace App\Http\Controllers;
use App\Models\sections;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Add_new_invoice;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\InvoicesExport;
use App\Models\invoices;
use App\Models\user;
use App\Models\InvoicesDetails;
use App\Models\invoice_attachments;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices=invoices::all();


      return view('invoices.invoices',['invoices'=>$invoices]);
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        $sections=sections::all();

        return view('invoices.ad2invioce',['sections'=>$sections]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);

        $invoice_id = invoices::latest()->first()->id;
        InvoicesDetails::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_id), $imageName);


    }
    $invoices = invoices::latest()->first();

    $user = User::get();
   Notification::send($user,new Add_new_invoice($invoices));



    session()->flash('Add','تمت الاضافه بنجاح');
    return redirect(route('invoices.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)

    {
        $invoices=invoices::where('id',$id)->first();
        return view('invoices.invioce_status',compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {

            $invoices = invoices::where('id', $id)->first();
            $sections = sections::all();
            return view('invoices.testUP', compact('sections','invoices'));
    }

    public function Status_Update($id,Request $request){
         $invoice=invoices::findOrFail($id);
         if($request->Status==='مدفوعة'){
             $invoice->update([
                'Value_Status'=>1,
                'Status'=>$request->Status,
                'Payment_Date'=>$request->Payment_Date,
             ]);
             InvoicesDetails::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
             ]);

         }else{
            $invoice->update([
                'Value_Status'=>3,
                'Status'=>$request->Status,
                'Payment_Date'=>$request->Payment_Date,
             ]);
             InvoicesDetails::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
             ]);

         }
         session()->flash('update_status');
         return  redirect(route('invoices.index'));

    }
    public function editInvioce($id){
        $sections = sections::all();
        $invioce=invoices::findOrFail($id);

      return view('invoices.edit_invoice',compact('invioce','sections'));


    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $invioce=invoices::findOrFail($request->invoice_id);
        $invioce->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);
        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
                      return redirect(route('invoices.index'));

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
       $id=$request->invoice_id;
       $invioce=invoices::where('id',$id)->first();
       $Details = invoice_attachments::where('invoice_id', $id)->first();

       $id_page =$request->id_page;

      if (!$id_page==2) {

      if (!empty($id)) {

          Storage::disk('public_uploads')->deleteDirectory($id);
      }
       $invioce->forceDelete();
       session()->flash('delete_invoice');
        return redirect(route('invoices.index'));
    }else{
        if (!empty($id)) {

            Storage::disk('public_uploads')->deleteDirectory($id);
        }
         $invioce->Delete();
         session()->flash('archive_invoice');
          return redirect(route('invoices.index'));
    }


    }

    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }
    public function paid_invioces(){
        $invoices=invoices::where('Value_Status',1)->get();
        return view('invoices.invioce_paid',compact('invoices'));


    }
    public function unpaid_invioces(){
        $invoices=invoices::where('Value_Status',2)->get();
        return view('invoices.invioce_unpaid',compact('invoices'));


    }
    public function print_invoice($id){
        $invioces=invoices::where('id',$id)->first();
        return view('invoices.print_invoice',compact('invioces'));
    }
    public function export()
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }
    public function MarkAsRead_all (Request $request)
    {

        $userUnreadNotification= auth()->user()->unreadNotifications;

        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return back();
        }


    }
}
