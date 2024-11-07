<?php

namespace App\Http\Controllers;

use App\Models\AttributeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\UserActionHistory;
use App\Models\ProteryHistory;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = DB::table('tbl_attributes')->where('user_id',Auth::user()->id)->Orwhere('id',22)->get();
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
            'attribute_name' => 'required',
            'attribute_description' => 'required'
        ]);

        $save = new AttributeModel;
        $save->attribute_name = $request->attribute_name;
        $save->description = $request->attribute_description;
        $save->public_id = Str::random(6);
        $save->user_id = Auth::user()->id;
        $save->save();

        UserActionHistory::create([
            'user_id' => Auth::user()->id,
            'action' => 'Attribute added '. $request->attribute_name .' by user '. Auth::user()->name .'.',
            'past_data' =>null,
            'new_data' => json_encode($save),
            'user_to' => null
        ]);
        return redirect()->back()->with('status', 'Attribute added successfully !!');
    }

    public function destroyAttribute($id)
    {
        $data = DB::table('tbl_attributes')->where('public_id', $id)->first();
        $deleted = DB::table('tbl_attributes')->where('public_id', $id)->delete();
        if ($deleted) {
            UserActionHistory::create([
                'user_id' => Auth::user()->id,
                'action' => 'Attribute deleted updated by user  attribute id'. $id.'.',
                'past_data' =>json_encode($data),
                'new_data' => null,
                'user_to' => null
            ]);
            return redirect()->back()->with('status', 'Attribute Deleted Successfully!!');
        }
    }

    public function getAttribute($id)
    {
        $attribute = DB::table('tbl_attributes')->where('public_id', $id)->first();
        return view('attribute.update-attribute', ['attribute' => $attribute]);
    }

    public function updateAttribute(Request $request)
    {

        // dd($request);
        $data = DB::table('tbl_attributes')->where('public_id', $request->attribute_id)->first();
        $status = DB::table('tbl_attributes')
            ->where('public_id', $request->attribute_id)
            ->update(['attribute_name' => $request->attribute_name, 'description' => $request->attribute_description]);

        UserActionHistory::create([
            'user_id' => Auth::user()->id,
            'action' => 'Attribute updated '. $request->attribute_name .' by user '. Auth::user()->name .'.',
            'past_data' =>json_encode($data),
            'new_data' => json_encode(AttributeModel::find($data->id)),
            'user_to' => null
        ]);
        return redirect()->back()->with('status', 'Attribute Updated Successfully!!');
    }

    public function changestatus(Request $request,$status,$id){
        
        $data = DB::table('tbl_attributes')->where('public_id', $id)->first();
        $status = DB::table('tbl_attributes')->where('public_id', $id)->update(['status' => $status]);
        UserActionHistory::create([
            'user_id' => Auth::user()->id,
            'action' => 'Attribute status updated by user '. Auth::user()->name .'.',
            'past_data' =>json_encode($data),
            'new_data' => json_encode(AttributeModel::find($data->id)),
            'user_to' => null
        ]);
        return redirect()->back()->with('status', 'Attribute status updated!!');
    }
}
