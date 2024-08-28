<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentProof extends Model
{
    use HasFactory;
    protected $table="payment_proofs";

    public function userdata()
    {
        return  $this->belongsTo(User::class,'upload_by');
    }
}
