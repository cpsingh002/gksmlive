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
                if($getData[1] == 'Y'){
                $update = DB::table('tbl_property')->where('plot_no', $plot_no)->where('scheme_id', $scheme_id)->update(['attributes_names' => $dfh_att, "attributes_data" => $dfdsgfd,'status'=>1,'gaj'=>$gaj,'plot_type'=>$plot_type,'plot_name'=>$plot_name]);
                
                }else{
                    $update = DB::table('tbl_property')->where('plot_no', $plot_no)->where('scheme_id', $scheme_id)->update(['attributes_names' => $dfh_att, "attributes_data" => $dfdsgfd,'status'=>3,'gaj'=>$gaj,'plot_type'=>$plot_type,'plot_name'=>$plot_name]);
                   
                }

                ProteryHistory ::create([
                    'scheme_id' => $scheme_id,
                    'property_id'=>$proerty->id,
                    'action_by'=>Auth::user()->id,
                    'action' => 'Scheme - '.$scheme->scheme_name.', plot no-'.$plot_name.' inventory  uploaded.',
                ]);
               
            }

            // Close opened CSV file
            fclose($csvFile);
            // header("Location: index.php");
            UserActionHistory::create([
                'user_id' => Auth::user()->id,
                'action' => 'CSv Attribute imported by user '. Auth::user()->name .'for scheme'.$scheme_id .'.',
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
}
