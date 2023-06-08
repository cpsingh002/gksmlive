<?php

namespace App\Http\Controllers;

use App\Models\AttributeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AttributeController extends Controller
{
    public function index()
    {

        $attributes = DB::table('tbl_attributes')->get();
        return view('attribute.attributes', ['attributes' => $attributes]);
    }

    public function addAttribute()
    {
        return view('attribute/add-attribute');
    }

    public function storeAttribute(Request $request)
    {

        // dd($request);
        $validatedData = $request->validate([
            'attribute_name' => 'required|unique:tbl_attributes',
            'attribute_description' => 'required'
        ]);

        $save = new AttributeModel;
        $save->attribute_name = $request->attribute_name;
        $save->description = $request->attribute_description;

        $save->public_id = Str::random(6);


        $save->save();

        return redirect('/attributes')->with('status', 'Attribute added successfully !!');
    }

    public function destroyAttribute($id)
    {
        $deleted = DB::table('tbl_attributes')->where('public_id', $id)->delete();
        // $update = DB::table('tbl_attributes')->where('public_id', $id)->limit(1)->update(['status' => 2]);
        if ($deleted) {
            return redirect('/attributes')->with('status', 'Attribute Deleted Successfully!!');
        }
    }

    public function getAttribute($id)
    {
        $attribute = DB::table('tbl_attributes')->where('public_id', $id)->first();
        // dd($production->production_name);
        return view('attribute.update-attribute', ['attribute' => $attribute]);
    }

    public function updateAttribute(Request $request)
    {

        // dd($request);
        $status = DB::table('tbl_attributes')
            ->where('public_id', $request->attribute_id)
            ->update(['attribute_name' => $request->attribute_name, 'description' => $request->attribute_description]);
        return redirect('/attributes');
    }

    public function changestatus(Request $request,$status,$id){
        $status = DB::table('tbl_attributes')
            ->where('public_id', $id)
            ->update(['status' => $status]);
       // $request->session()->flash('message','Attribute status updated');
        return redirect('/attributes')->with('status', 'Attribute status updated!!');
    }
}
