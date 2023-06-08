<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //protected $table = 'tbl_customer';
    use HasFactory;
    public $fillable = ['public_id', 'plot_public_id', 'payment_mode', 'adhar_card','cheque_photo','pan_card','pan_card_image','attachment', 'owner_name', 'contact_no', 'booking_status', 'address', 'description',];
}
