<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\sections;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections=sections::all();
        return view('sections.section',['sections'=>$sections]);
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
            'section_name'=>'required|unique:sections|max:255',
        ],[
           'section_name.required'=>'يرجي ادخال اسم القسم',
           'section_name.unique'=>'القسم مسجل مسبقا',
        ]);
        $input=$request->all();
        $b_exist=sections::where('section_name','=',$input['section_name'])->exists();
    //    if($b_exist){
    //     session()->flash('add','القسم مسجل مسبقا');
    //     return  redirect('/section');

    //    }else{
        sections::create([
            'section_name'=>$request->section_name,
            'descreption'=>$request->description,
            'created_by'=>Auth::user()->name,
        ]);
        session()->flash('add','تم اضاقه المنتج بنجاح');
        return  redirect('/section');
     //  }

    }

    /**
     * Display the specified resource.
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $id=$request->id;

        $validator=$request->validate([
            'section_name'=>'required|unique:sections|max:255',
        ],[
           'section_name.required'=>'يرجي ادخال اسم القسم',
           'section_name.unique'=>'القسم مسجل مسبقا',
        ]);
        $section=sections::find($id);
        $section->update([
            'section_name'=>$request->section_name,
            'descreption'=>$request->descreption,
            'created_by'=>Auth::user()->name,
        ]);
        session()->flash('edit','تم تعديل القسم بنجاج');
        return redirect('/section');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id=$request->id;
        $section=sections::find($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect(route('section.index'));

    }
}
