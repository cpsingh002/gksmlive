<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProteryHistory extends Model
{
    use HasFactory;
    protected $table = 'protery_histories';

    protected $fillable = [
        'scheme_id',
        'property_id',
        'action_by',
        'done_by',
        'action',
        'past_data',
        'new_data',
        'name',
        'addhar_card'
    ];

    public function plotdata()
    {
        return  $this->belongsTo(PropertyModel::class,'property_id');
    }
    public function userdata()
    {
        return  $this->belongsTo(User::class,'action_by');
    }

}
