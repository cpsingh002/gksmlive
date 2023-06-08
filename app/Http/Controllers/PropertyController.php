<?php

namespace App\Http\Controllers;

use App\Models\PropertyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    public function index()
    {
        // $records = DB::table('tbl_production')
        //     ->join('tbl_scheme', 'tbl_production.public_id', '=', 'tbl_scheme.production_id')
        //     ->join('tbl_property', 'tbl_scheme.public_id', '=', 'tbl_property.scheme_id')
        //     ->get();

        $properties = DB::table('tbl_property')->get();
        return view('property.properties', ['properties' => $properties]);
    }

    public function addProperty()
    {
        $productions = DB::table('tbl_production')->get();
        $schemes = DB::table('tbl_scheme')->get();

        return view('property/add-property', ['productions' => $productions, 'schemes' => $schemes]);
    }


    // Store Contact Form data
    public function storeProperty(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'property_name' => 'required'
        ]);

        $save = new PropertyModel;

        $save->property_name = $request->property_name;
        $save->production_id = $request->production_id;
        $save->scheme_id = $request->scheme_id;
        $save->public_id = Str::random(6);

        // dd($save);
        $save->save();

        return redirect('/properties')->with('status', 'Ajax Form Data Has Been validated and store into database');
    }

    public function destroyProperty($id)
    {

        $update = DB::table('tbl_property')->where('public_id', $id)->limit(1)->update(['status' => 3]);
        if ($update) {
            return redirect('/properties')->with('status', 'Ajax Form Data Has Been validated and store into database');
        }
    }
}
