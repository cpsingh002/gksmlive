<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductionModel;
use App\Models\SchemeModel;
use App\Models\PropertyModel;
use Carbon\Carbon;

class NotifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('dashboard.header', function ($view) {
            if(Auth::user()->user_type == 4){
                $id = Auth::user()->id;
                $notices = Notification::where(static function ($query) use ($id) {
                    $query->where('msg_to',$id)
                        ->orwhereNull('msg_to');
                })->where( DB::raw('DATE(created_at)'), Carbon::today())->orderby('id','DESC')->get();
            }elseif(in_array(Auth::user()->user_type, [2,5]))
            {
                $schemes= SchemeModel::leftjoin('tbl_production','tbl_production.public_id','tbl_scheme.production_id')->where('tbl_production.production_id',Auth::user()->parent_id)->pluck('tbl_scheme.id')->toArray();
                // dd($schemes);
                $notices = Notification::WhereIn('scheme_id',$schemes)->where(DB::raw('DATE(created_at)'), Carbon::today())->orderby('id','DESC')->get();
            }elseif(in_array(Auth::user()->user_type, [3])){
                $notices = Notification::WhereIn('scheme_id',json_decode(Auth::user()->scheme_opertaor))->where(DB::raw('DATE(created_at)'), Carbon::today())->orderby('id','DESC')->get();
            }elseif(in_array(Auth::user()->user_type, [1,6]))
            {
                $notices = Notification::where(DB::raw('DATE(created_at)'), Carbon::today())->orderby('id','DESC')->get();
            }

                
            // $websetting = WebSetting::find(1);
            // dd($websetting);
            $view->with('notices' , $notices);
        });
    }
}
