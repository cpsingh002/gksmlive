<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVerify extends Model
{
    use HasFactory;
    public $table = "users_verify";
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $fillable = [
        'user_id',
        'token',
        'mobile_opt',
    ];
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
