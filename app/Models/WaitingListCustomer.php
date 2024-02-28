<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaitingListCustomer extends Model
{
    use HasFactory;
    
    public function category()
    {
        $this->belongsTo(WaitingListMember::class);
    }
}
