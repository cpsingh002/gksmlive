<?php

namespace App\Http\Controllers;

use App\Models\AttributeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CsvController extends Controller
{
    public function index()
    {

        return view('csv.import-csv');
    }

    public function storeCsv(Request $request)
    {
        $attribute_name = [];
        $attributes = DB::table('tbl_attributes')->where('status',1)
            ->get();

        foreach ($attributes as $attribute) {
            $attribute_name['attribute_name'][] = $attribute->attribute_name;

        }

        $position=[];
        $i=1;
        foreach ($attributes as $attribute) 
       {
        // $position[$i]['lat']= $list->parkinglat;
        // $position[$i]['lng']= $list->parkinglng;
        $booking_data = $attribute->description;
        
            $position[$attribute->attribute_name]=$booking_data;
            $i++;
             $ghi=$i;   
       }
       $dfh_att=json_encode($position);
       
//echo"<pre>";
        //dd(json_encode($position));
        // Allowed mime types
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
            // Parse data from CSV file line by line
            while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE) {
                // dd($getData);
                // Get row data
                $positioned=[];
                        $i=4;
                        $scheme_id = $getData[0];
                         $plot_no= $getData[2];
                        $gaj= $getData[3];
                       
                        foreach ($attributes as $attribute) 
                    {
                        // $position[$i]['lat']= $list->parkinglat;
                        // $position[$i]['lng']= $list->parkinglng;
                        //$booking_data = $attribute->description;
                        $attribute= $getData[$i];
                            $positioned[]=$attribute;
                            $i++;
                    
                    }
                //dd($positioned);

                // $attribute_arr =
                //     array(
                //         "plot_no" => "Plot No",
                //         "slable_size" => "Slable Size (Sq. Yrds)",
                //         "facing" => "Facing",
                //         "road_size" => "Road size",
                //         "plot_type" => "Plot Type",
                //     );

                //dd($attribute_arr);
                // $attribute_array =  json_encode($attribute_arr);

               // dd($attribute_array);

                // $attribute_meta_arr =
                //     array(
                //         "Plot No" => $plot_no,
                //         "Slable Size" => $slable_size,
                //         "Facing" => $facing,
                //         "Road Size" => $road_size,
                //         "Plot Type" => $plot_type,
                //     );

                    $positionedd=[];
                        $i=0;
                        //$scheme_id = $getData[0];
                        foreach ($attributes as $attribute) 
                    {
                        // $position[$i]['lat']= $list->parkinglat;
                        // $position[$i]['lng']= $list->parkinglng;
                        //$booking_data = $attribute->description;
                        $rfh= array($attribute->attribute_name => $positioned[$i] );
                        
                            $positionedd=array_merge($positionedd,$rfh);
                            $i++;
                    
                    }

                    
                        //$dcxcf= [($positionedd[0]),json_encode($positionedd[1]),json_encode($positionedd[2]),json_encode($positionedd[3])];
                   
                    //dd($positionedd);
                    // $ghi
                    $dfdsgfd=json_encode($positionedd);

                   // dd($dfdsgfd);
                    
                // Function to convert array into JSON
               // $attribute_meta_array =  json_encode($attribute_meta_arr);

                if($getData[1] == 'Y'){
                $update = DB::table('tbl_property')->where('plot_no', $plot_no)->where('scheme_id', $scheme_id)->update(['attributes_names' => $dfh_att, "attributes_data" => $dfdsgfd,'gaj'=>$gaj]);
                
                }else{
                    $update = DB::table('tbl_property')->where('plot_no', $plot_no)->where('scheme_id', $scheme_id)->update(['attributes_names' => $dfh_att, "attributes_data" => $dfdsgfd,'status'=>3,'gaj'=>$gaj]);
                   
                }
                // if ($update) {
                //     return redirect('/attributes')->with('status', 'Attribute Deleted Successfully!!');
                // }

                // If user already exists in the database with the same email
                // $query = "SELECT id FROM users WHERE email = '" . $getData[1] . "'";

                // $check = mysqli_query($conn, $query);

                // if ($check->num_rows > 0) {
                //     mysqli_query($conn, "UPDATE users SET name = '" . $name . "', phone = '" . $phone . "', status = '" . $status . "', created_at = NOW() WHERE email = '" . $email . "'");
                // } else {
                //     mysqli_query($conn, "INSERT INTO users (name, email, phone, created_at, updated_at, status) VALUES ('" . $name . "', '" . $email . "', '" . $phone . "', NOW(), NOW(), '" . $status . "')");
                // }
            }






            // while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE) {
            //     // dd($getData);
            //     // Get row data
                
            //     $scheme_id = $getData[0];
            //     $plot_no = $getData[1];
            //     $slable_size = $getData[2];
            //     $facing =  $getData[3];
            //     $road_size = $getData[4];
            //     $plot_type = $getData[5];

            //     $attribute_arr =
            //         array(
            //             "plot_no" => "Plot No",
            //             "slable_size" => "Slable Size (Sq. Yrds)",
            //             "facing" => "Facing",
            //             "road_size" => "Road size",
            //             "plot_type" => "Plot Type",
            //         );

            //     dd($attribute_arr);
            //     $attribute_array =  json_encode($attribute_arr);

            //     dd($attribute_array);

            //     $attribute_meta_arr =
            //         array(
            //             "Plot No" => $plot_no,
            //             "Slable Size" => $slable_size,
            //             "Facing" => $facing,
            //             "Road Size" => $road_size,
            //             "Plot Type" => $plot_type,
            //         );

            //     // Function to convert array into JSON
            //     $attribute_meta_array =  json_encode($attribute_meta_arr);

            //     $update = DB::table('tbl_property')->where('plot_no', $plot_no)->where('scheme_id', $scheme_id)->update(['attributes_names' => $attribute_array, "attributes_data" => $attribute_meta_array]);
            //     // if ($update) {
            //     //     return redirect('/attributes')->with('status', 'Attribute Deleted Successfully!!');
            //     // }

            //     // If user already exists in the database with the same email
            //     // $query = "SELECT id FROM users WHERE email = '" . $getData[1] . "'";

            //     // $check = mysqli_query($conn, $query);

            //     // if ($check->num_rows > 0) {
            //     //     mysqli_query($conn, "UPDATE users SET name = '" . $name . "', phone = '" . $phone . "', status = '" . $status . "', created_at = NOW() WHERE email = '" . $email . "'");
            //     // } else {
            //     //     mysqli_query($conn, "INSERT INTO users (name, email, phone, created_at, updated_at, status) VALUES ('" . $name . "', '" . $email . "', '" . $phone . "', NOW(), NOW(), '" . $status . "')");
            //     // }
            // }

            // Close opened CSV file
            fclose($csvFile);

            // header("Location: index.php");
            return redirect('/import-csv')->with('status', 'Csv Attribute imported Successfully!!');
        }
    }
}
