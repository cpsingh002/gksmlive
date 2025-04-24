<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionModel extends Model
{   
    protected $table = 'tbl_production';
    use HasFactory;
    public $fillable = ['public_id', 'production_id', 'production_name', 'production_img', 'production_description', 'status'];

    public function opertors()
    {
        return $this->hasMany(User::class,'parent_id','production_id')->where(['status'=>1,'user_type'=>3]);
    }

    public function schemecount()
    {
        return $this->hasMany(SchemeModel::class,'production_id','public_id')->where(['status'=>1]);
    }

    public function freegaj()
    {
        
        return $this->hasMany(PropertyModel::class,'production_id','public_id')->whereIn('booking_status',[1,0,4])->where('status','!=',3)->select('tbl_property.id','tbl_property.gaj');
    }

    // $productiondata= ProductionModel::withCount(['opertors'])->where('status',1)->get();
}
