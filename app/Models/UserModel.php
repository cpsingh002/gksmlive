<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class UserModel extends Model
{
    protected $table = 'users';
    use HasFactory;
    public $fillable = ['public_id', 'email', 'password', 'name', 'parent_id', 'parent_user_type', 'mobile_number', 'user_type', 'associate_rera_number', 'applier_name', 'status'];
}
