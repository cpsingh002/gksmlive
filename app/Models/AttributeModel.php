<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeModel extends Model
{   
    protected $table = 'tbl_attributes';
    use HasFactory;
    public $fillable = ['public_id', 'attribute_name', 'description', 'status'];
}
