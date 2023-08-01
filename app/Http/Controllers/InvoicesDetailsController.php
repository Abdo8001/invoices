<?php

namespace App\Http\Controllers;

use App\Models\InvoicesDetails;
use App\Models\invoices;
use App\Models\invoice_attachments;
use Storage;
use League\Flysystem\Local\LocalFilesystemAdapter;
// use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use League\Flysystem\Dropbox\DropboxAdapter;
use File;
use Illuminate\Http\Request;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoicesDetails $invoicesDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

public function edit($id)

{

    $invoices = invoices::where('id',$id)->first();
    $details  = InvoicesDetails::where('id_Invoice',$id)->get();
    $attachments  = invoice_attachments::where('invoice_id',$id)->get();

    return view('invoices.invoicedetail',compact('invoices','details','attachments'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoicesDetails $invoicesDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        $invoices = invoice_attachments::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    public function openfile($id,$file_name){


     $files = Storage::disk('public_uploads')->path($id.'/'.$file_name);

        return response()->file($files);


       }

    public function download($invoice_number,$file_name)
    {
        $st="Attachments";
        $pathToFile = public_path($st.'/'.$invoice_number.'/'.$file_name);
        return response()->download($pathToFile);
    }
    }
