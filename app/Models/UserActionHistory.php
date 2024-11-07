<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActionHistory extends Model
{
    use HasFactory;
    protected $table ="user_action_histories";

    protected $fillable = [
        'user_id',
        'action',
        'past_data',
        'new_data',
        'user_to'
    ];

    public function userby()
    {
        return  $this->belongsTo(User::class,'user_id');
    }
    public function userto()
    {
        return  $this->belongsTo(User::class,'user_to');
    }
}
