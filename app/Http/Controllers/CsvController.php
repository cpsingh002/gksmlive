<?php

namespace App\Http\Controllers;

use App\Models\AttributeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use App\Models\UserActionHistory;
use App\Models\ProteryHistory;
use App\Models\PropertyModel;
use App\Models\SchemeModel;
use Carbon\Carbon;
use App\Models\Notification;


class CsvController extends Controller
{
    public function index()
    {

        return view('csv.import-csv');
    }

    public function storeCsv(Request $request)
    {
        //     $path = $request->file('file')->getRealPath();
        // $data = array_map('str_getcsv', file($path));
        // $csv_data = array_slice($data, 0, 2);
        // dd($csv_data);
        $attribute_name = [];
        $attributes = DB::table('tbl_attributes')->where('status',1)->where('user_id',Auth::user()->id)->Orwhere('id',22)->get();

        foreach ($attributes as $attribute) {
            $attribute_name['attribute_name'][] = $attribute->attribute_name;

        }

        $position=[];
        $i=1;
        foreach ($attributes as $attribute) 
       {
        
        $booking_data = $attribute->description;
        
            $position[$attribute->attribute_name]=$booking_data;
            $i++;
             $ghi=$i;   
       }
       $dfh_att=json_encode($position);
       

        $fileMimes = array(
            'text/x-comma-separated-values',
            'text/comma-separated-values',
            'application/octet-stream',
            'application/vnd.ms-excel',
            'application/x-csv',
            'text/x-csv',
            'text/csv',
            'application/csv',
            'application/excel',
            'application/vnd.msexcel',
            'text/plain'
        );

        // Validate whether selected file is a CSV file
        if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $fileMimes)) {

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

            // Skip the first line
            fgetcsv($csvFile);

            // Parse data from CSV file line by line
            while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE) {
                // dd($getData);
                // Get row data
                if(in_array(Auth::user()->user_type, [2]))
                {
                    $schemeslist= SchemeModel::leftjoin('tbl_production','tbl_production.public_id','tbl_scheme.production_id')->where('tbl_production.production_id',Auth::user()->parent_id)->pluck('tbl_scheme.id')->toArray();
                    // dd($schemes);
                }elseif(in_array(Auth::user()->user_type, [3])){
                    $schemeslist =  json_decode(Auth::user()->scheme_opertaor);
                }elseif(in_array(Auth::user()->user_type, [1]))
                {
                    $schemeslist = SchemeModel::where('status','!=',3)->pluck('tbl_scheme.id')->toArray();
                    
                }
    
                $positioned=[];
                        $i=5;
                        $scheme_id = $getData[0];
                        $plot_no= $getData[2];
                        $gaj= $getData[3];
                        $plot_type= $getData[4];
                        $plot_name = $getData[5];
                       
                        foreach ($attributes as $attribute) 
                    {
                        
                        $attribute= $getData[$i];
                        $positioned[]=$attribute;
                        $i++;
                    
                    }
                

                        $positionedd=[];
                        $i=0;
                        //$scheme_id = $getData[0];
                        foreach ($attributes as $attribute) 
                        {
                        
                            $rfh= array($attribute->attribute_name => $positioned[$i] );
                        
                            $positionedd=array_merge($positionedd,$rfh);
                            $i++;
                    
                        }

                    //dd($positionedd);
                  
                    $dfdsgfd=json_encode($positionedd);

                   // dd($dfdsgfd);
                    
                // Function to convert array into JSON
                $proerty = PropertyModel::where('plot_no', $plot_no)->where('scheme_id', $scheme_id)->first();
                $scheme = SchemeModel::where('id',$scheme_id)->first();

                if(in_array($scheme_id, $schemeslist)){
                    if($getData[1] == 'Y'){
                    $update = DB::table('tbl_property')->where('plot_no', $plot_no)->where('scheme_id', $scheme_id)->update(['attributes_names' => $dfh_att, "attributes_data" => $dfdsgfd,'status'=>1,'gaj'=>$gaj,'plot_type'=>$plot_type,'plot_name'=>$plot_name]);
                    
                    }else{
                        $update = DB::table('tbl_property')->where('plot_no', $plot_no)->where('scheme_id', $scheme_id)->update(['attributes_names' => $dfh_att, "attributes_data" => $dfdsgfd,'status'=>3,'gaj'=>$gaj,'plot_type'=>$plot_type,'plot_name'=>$plot_name]);
                    
                    }
                    $plot_details = PropertyModel::where('plot_no', $plot_no)->where('scheme_id', $scheme_id)->first();
                    ProteryHistory ::create([
                        'scheme_id' => $scheme_id,
                        'property_id'=>$proerty->id,
                        'action_by'=>Auth::user()->id,
                        'action' => 'Scheme - '.$scheme->scheme_name.', unit no-'.$plot_name.' inventory  uploaded.',
                        'past_data' =>json_encode($proerty),
                        'new_data' =>json_encode($plot_details),
                        'name' =>$proerty->owner_name,
                        'addhar_card' =>$proerty->adhar_card_number
                    ]);
                }else{

                    ProteryHistory ::create([
                        'scheme_id' => $scheme_id,
                        'property_id'=>$proerty->id,
                        'action_by'=>Auth::user()->id,
                        'action' => 'Scheme - '.$scheme->scheme_name.', unit no-'.$plot_name.' inventory  uploaded [try to upload other production house scheme data through csv] .',
                        'past_data' =>json_encode($proerty),
                        'new_data' =>json_encode($proerty),
                        'name' =>$proerty->owner_name,
                        'addhar_card' =>$proerty->adhar_card_number
                    ]);

                }
               
            }

            // Close opened CSV file
            fclose($csvFile);
            // header("Location: index.php");
            
             $ppt = $request->file('file');
            $fileName_ppt = time() . rand(1, 99) . '.' . $ppt->extension();
            $ppt->move(public_path('files'), $fileName_ppt);
            UserActionHistory::create([
                'user_id' => Auth::user()->id,
                'action' => 'CSv Attribute imported by user '. Auth::user()->name .' for scheme '.$scheme_id .'.',
                'past_data' =>null,
                'new_data' =>json_encode($fileName_ppt),
                'user_to' => null
            ]);
            
            if (Auth::user()->user_type == 1){
                
                return redirect('/admin/import-csv')->with('status', 'Csv Attribute imported Successfully!!');
            }elseif (Auth::user()->user_type == 2){ 
               
                return redirect('/production/import-csv')->with('status', 'Csv Attribute imported Successfully!!');
            }elseif (Auth::user()->user_type == 3){ 
                
                return redirect('/opertor/import-csv')->with('status', 'Csv Attribute imported Successfully!!');
            }
        }
    }


    public function Relunchdate(Request $request)
    {
        return view('csv.relunch_csv');
    }
    public function RelaunchStore(Request $request)
    {
        $fileMimes = array(
            'text/x-comma-separated-values',
            'text/comma-separated-values',
            'application/octet-stream',
            'application/vnd.ms-excel',
            'application/x-csv',
            'text/x-csv',
            'text/csv',
            'application/csv',
            'application/excel',
            'application/vnd.msexcel',
            'text/plain'
        );

        // Validate whether selected file is a CSV file
        if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $fileMimes)) {

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

            // Skip the first line
            fgetcsv($csvFile);

            // Parse data from CSV file line by line
            while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE) {
                // dd($getData);              
                    $scheme_id = $getData[0];
                    $plot_no= $getData[2];
                    $dt= $getData[3];                          
                // Function to convert array into JSON
                $proerty = PropertyModel::where('plot_no', $plot_no)->where('scheme_id', $scheme_id)->first();

                $scheme = SchemeModel::where('id',$scheme_id)->first();
                if($getData[1] == 'Y'){
                    $update = PropertyModel::where('plot_no', $plot_no)->where('scheme_id', $scheme_id)->update(['status'=>1,'lunch_time'=>Carbon::parse($dt)->format('Y-m-d H:i:s')]);
                
                }else{
                    $update = PropertyModel::where('plot_no', $plot_no)->where('scheme_id', $scheme_id)->update(['status'=>3,'lunch_time'=>Carbon::parse($dt)->format('Y-m-d H:i:s')]);
                   
                }
                $plot_details = PropertyModel::where('plot_no', $plot_no)->where('scheme_id', $scheme_id)->first();
                if(isset($proerty)){
                    ProteryHistory ::create([
                        'scheme_id' => $scheme_id,
                        'property_id'=>$proerty->id,
                        'action_by'=>Auth::user()->id,
                        'action' => 'Scheme - '.$scheme->scheme_name.', unit no-'.$proerty->plot_name.'Relaunch date inventory  uploaded.',
                        'past_data' =>json_encode($proerty),
                        'new_data' =>json_encode($plot_details),
                        'name' =>$proerty->owner_name,
                        'addhar_card' =>$proerty->adhar_card_number
                    ]);
                }
               
            }

            // Close opened CSV file
            fclose($csvFile);
            // header("Location: index.php");
            $ppt = $request->file('file');
            $fileName_ppt = time() . rand(1, 99) . '.' . $ppt->extension();
            // $filename = $ppt->getClientOriginalName();
            $ppt->move(public_path('files'), $fileName_ppt);
            UserActionHistory::create([
                'user_id' => Auth::user()->id,
                'action' => 'CSv Lunch date  change by user '. Auth::user()->name .' for scheme '.$scheme_id .'.',
                'past_data' =>null,
                'new_data' =>json_encode($fileName_ppt),
                'user_to' => null
            ]);
            
            if (Auth::user()->user_type == 1){
                
                return redirect('/admin/import-csv')->with('status', 'Csv Relaunch Date imported Successfully!!');
            }elseif (Auth::user()->user_type == 2){ 
               
                return redirect('/production/import-csv')->with('status', 'Csv Relaunch Date imported Successfully!!');
            }elseif (Auth::user()->user_type == 3){ 
                
                return redirect('/opertor/import-csv')->with('status', 'Csv Relaunch Date imported Successfully!!');
            }
        }

    }
    
    public function CSVHistory(Request $request)
    {
        if (isset($request->scheme_id)) {
            
            if(in_array(Auth::user()->user_type, [2,5]))
            {
                $schemes= SchemeModel::leftjoin('tbl_production','tbl_production.public_id','tbl_scheme.production_id')->where('tbl_production.production_id',Auth::user()->parent_id)->select('tbl_scheme.*')->get();
                
            }elseif(in_array(Auth::user()->user_type, [3])){
                $schemes = SchemeModel::WhereIn('id',json_decode(Auth::user()->scheme_opertaor))->get();
                
            }elseif(in_array(Auth::user()->user_type, [1,6]))
            {
                $schemes = DB::table('tbl_scheme')->where('status', 1)->get();
            }
            $book_properties = DB::table('tbl_property')
                ->select('tbl_property.status','tbl_property.gaj','tbl_property.scheme_id','tbl_property.plot_no','tbl_property.plot_type','tbl_property.plot_name','tbl_property.attributes_data')
                ->where('tbl_property.scheme_id', $request->scheme_id)->orderby('tbl_property.plot_no','ASC')->get();
            // dd($book_properties);
            return view('scheme.csvhsitorys', ['properties' => $book_properties, 'schemes' => $schemes]);
        } else {


            if(in_array(Auth::user()->user_type, [2,5]))
            {
                $schemes= SchemeModel::leftjoin('tbl_production','tbl_production.public_id','tbl_scheme.production_id')->where('tbl_production.production_id',Auth::user()->parent_id)->select('tbl_scheme.*')->get();
                // dd($schemes);
                // $notices = Notification::WhereIn('scheme_id',$schemes)->where('created_at', Carbon::today())->orderby('id','DESC')->get();
            }elseif(in_array(Auth::user()->user_type, [3])){
                $schemes = SchemeModel::WhereIn('id',json_decode(Auth::user()->scheme_opertaor))->get();
                // $notices = Notification::WhereIn('scheme_id',json_decode(Auth::user()->scheme_opertaor))->where('created_at', Carbon::today())->orderby('id','DESC')->get();
            }elseif(in_array(Auth::user()->user_type, [1,6]))
            {
                $schemes = DB::table('tbl_scheme')->where('status', 1)->get();
            }

            
            
           // dd($schemes);
            return view('scheme.csvhsitorys', ['schemes' => $schemes]);
        }
    }
}
