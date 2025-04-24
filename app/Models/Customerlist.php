<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customerlist extends Model
{
    use HasFactory;

    public function scheme()
    {
        return  $this->belongsTo(SchemeModel::class,'scheme_id');
    }
}
