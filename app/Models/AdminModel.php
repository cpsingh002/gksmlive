<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{   
    protected $table = 'admins';
    use HasFactory;
    public $fillable = ['public_id', 'email', 'password', 'name'];
}
