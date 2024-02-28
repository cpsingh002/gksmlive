<?php
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\SchemeModel;
use App\Models\PropertyModel;
use Illuminate\Support\Facades\Auth;

function username ($user_id)
{
    $user = User::where('public_id',$user_id)->first();
    return $user->name;
}