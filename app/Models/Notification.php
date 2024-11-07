<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';

    protected $fillable = [
        'scheme_id',
        'property_id',
        'action_by',
        'msg_to',
        'action',
        'msg',
        'past_data',
        'new_data'
    ];


    public function getCreatedAtAttribute($value)
    {
        $df = date('Y-m-d H:i:s', strtotime($value));
        return $df;
        // return Carbon::parse($value)->format('Y-m-d H:i:s');
        // return Carbon::createFromFormat('Y-m-d H:i:s', $value);
    }
}
