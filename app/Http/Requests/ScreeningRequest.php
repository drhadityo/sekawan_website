<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScreeningRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // Identitas Diri
            'agreement' => 'required|boolean',
            'full_name' => 'required|string',
            'nik' => 'required|string',
            'contact' => 'required|string',
            'gender' => 'required|in:male,female',
            'age' => 'required|numeric',
            'address' => 'required|string',
            'district' => 'required|string',
            'screening_date' => 'required|date',

            // Screening Awal
            'cough' => 'required|boolean',
            'tb_diagnosed' => 'required|in:a,b,c',
            'home_contact' => 'required|boolean',
            'close_contact' => 'required|boolean',

            // Gejala Lain
            'weight_loss' => 'required|boolean',
            'fever' => 'required|boolean',
            'breath' => 'required|boolean',
            'smoking' => 'required|boolean',
            'sluggish' => 'required|boolean',
            'sweat' => 'required|boolean',

            // Faktor Risiko
            'ever_treatment' => 'required|boolean',
            'elderly' => 'required|boolean',
            'pregnant' => 'required|boolean',
            'diabetes' => 'required|boolean',

            // Kontak
            'contact1_name' => 'nullable|string',
            'contact1_number' => 'nullable|string',
            'contact2_name' => 'nullable|string',
            'contact2_number' => 'nullable|string',
            'contact3_name' => 'nullable|string',
            'contact3_number' => 'nullable|string'
        ];
    }
}
