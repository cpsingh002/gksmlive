<?php
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Team;
use App\Models\SchemeModel;
use App\Models\PropertyModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

function username ($user_id)
{
    $user = User::where('public_id',$user_id)->first();
    return $user->name;
}


function StatusChangeforAllseen()
{
    Artisan::call('statusAllseen:days');
    return;
}

function userdatasd($user_id)
{
    $userdata = User::Leftjoin('teams','teams.public_id','=','users.team')->where('public_id',$user_id)->select('users.applier_name','users.applier_rera_number','teams.team_name')->first();
    return $userdata;
}