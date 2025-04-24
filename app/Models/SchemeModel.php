<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchemeModel extends Model
{
    protected $table = 'tbl_scheme';
    use HasFactory;
    public $fillable = ['public_id', 'production_id', 'scheme_name', 'scheme_img', 'brochure', 'location', 'no_of_plot', 'ppt', 'video', 'jda_map', 'pra', 'other_docs', 'scheme_images', 'scheme_description', 'bank_name', 'account_number', 'ifsc_code', 'branch_name', 'status'];

    public function bookunits()
    {
        return $this->hasMany(PropertyModel::class,'scheme_id')->where(['booking_status'=>2,'status'=>1]);
    }

    public function holdunits()
    {
        return $this->hasMany(PropertyModel::class,'scheme_id')->where(['booking_status'=>3,'status'=>1]);
    }

    public function Completeunits()
    {
        return $this->hasMany(PropertyModel::class,'scheme_id')->where(['booking_status'=>5,'status'=>1]);
    }

    public function freeunits()
    {
        return $this->hasMany(PropertyModel::class,'scheme_id')->whereIn('booking_status',[1,0,4])->where('status',1);
    }

    public function freegaj()
    {
        return $this->hasMany(PropertyModel::class,'scheme_id')->select('tbl_property.id','tbl_property.plot_type','tbl_property.scheme_id','tbl_property.gaj')->whereIn('booking_status',[1,0,4])->where('status',1);
    }
}
