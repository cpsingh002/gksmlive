<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        
        if (Auth::check()) {
            $usersCount = DB::table('users')->count();
            $productionsCount = DB::table('tbl_production')->where('status', 1)->count();
            $schemesCount = DB::table('tbl_scheme')->where('status', 1)->count();
            $bookPropertyCount = DB::table('tbl_property')->where('booking_status', 2)->count();
            $holdPropertyCount = DB::table('tbl_property')->where('booking_status', 3)->count();
            // dd($schemesCount);
           
            return view('dashboard',['usersCount' => $usersCount, 'bookPropertyCount'=>$bookPropertyCount, 'holdPropertyCount'=> $holdPropertyCount, 'schemesCount' => $schemesCount]);
        }
        return redirect('login')->with('success', 'you are not allowed to access');
        // return view('dashboard');
    }
}
