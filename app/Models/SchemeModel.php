<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchemeModel extends Model
{
    protected $table = 'tbl_scheme';
    use HasFactory;
    public $fillable = ['public_id', 'production_id', 'scheme_name', 'scheme_img', 'brochure', 'location', 'no_of_plot', 'ppt', 'video', 'jda_map', 'pra', 'other_docs', 'scheme_images', 'scheme_description', 'bank_name', 'account_number', 'ifsc_code', 'branch_name', 'status'];
}
