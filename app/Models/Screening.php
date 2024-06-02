<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screening extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];
    
    // Pake Guarded saja
    // protected $fillable = [
    //     'full_name',
    //     'contact',
    //     'gender',
    //     'age',
    //     'district',
    //     'screening_date',
    //     'contact_with_tb',
    //     'batuk',
    //     'sesak_nafas',
    //     'keringat_malam_hari',
    //     'demam_meriang',
    //     'ibu_hamil',
    //     'lansia',
    //     'diabetes_melitus',
    //     'merokok',
    //     'contact1_name',
    //     'contact1_number',
    //     'contact2_name',
    //     'contact2_number',
    //     'contact3_name',
    //     'contact3_number'
    // ];
}