<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionModel extends Model
{   
    protected $table = 'tbl_production';
    use HasFactory;
    public $fillable = ['public_id', 'production_id', 'production_name', 'production_img', 'production_description', 'status'];
}
