<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections=sections::all();
        $products=products::all();
        return view('products.product',['sections'=>$sections,'products'=>$products]);
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
        $validator=$request->validate([
            'Product_name'=>'required|max:255',
            'section_id'=>'required',
                ],[
           'Product_name.required'=>'يرجي ادخال اسم المنتج',
           'section_id.required'=>'يرجي ادخال اسم القسم',
        ]);
       products::create([
        'Product_name'=>$request->Product_name,
        'section_id'=>$request->section_id,
        'description'=>$request->description,
       ]);
       session()->flash('add','تم اضافة المنتج بنجاح ');
       return redirect(route('products.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = sections::where('section_name', $request->section_name)->first()->id;
       // dd($id);


        $validator=$request->validate([
            'Product_name'=>'required|max:255',
                ],[
           'Product_name.required'=>'يرجي ادخال اسم المنتج',
        ]);
        $product=products::findOrFail($request->pro_id);
        $product->update([
            'Product_name'=>$request->Product_name,
            'description'=>$request->description,
            'section_id'=>$id,
        ]);
        session()->flash('edit','تم التعديل بنجاح');
        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Request $request)
    {
      $product=products::findOrFail($request->pro_id);
      $product->delete();
      session()->flash('delete', 'تم حذف المنتج بنجاح');
      return back();
    }
}
