<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PropertyModel extends Model
{
    protected $table = 'tbl_property';
    use HasFactory;
    public $fillable = ['public_id', 'production_id', 'booking_time', 'scheme_id', 'plot_no', 'plot_desc', 'user_id', 'associate_name','associate_number', 'payment_mode', 'adhar_card','cheque_photo','attachment', 'owner_name', 'contact_no', 'booking_status', 'address', 'description', 'status'];
     
    
}
