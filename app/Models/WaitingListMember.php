<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaitingListMember extends Model
{
    use HasFactory;
    
    // public function productVariant()
    // {
    //     return $this->hasMany(ProductVariant::class);
    // }
    // public function waitinglist()
    // {
    //     return $this->hasMany(WaitingListMember::class,'scheme_id','plot_no');
    // }
        public function subCategories()
    {
        return $this->hasMany(WaitingListCustomer::class,'waiting_member_id');
    }
    
}
