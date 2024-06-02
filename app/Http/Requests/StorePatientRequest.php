<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\SatelliteHealthFacility;
use App\Models\User;
use Illuminate\Support\Str;

class StorePatientRequest extends FormRequest
{
    // protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'satellite_health_facility_id' => $this->satellite_health_facility_id ? SatelliteHealthFacility::firstOrCreate(
                ["id"    => $this->satellite_health_facility_id],
                ["name"  => Str::upper($this->satellite_health_facility_id)]
            )->id : false,

            'user_id'  => $this->user_id ? User::firstOrCreate(
                ["id"    => $this->user_id],
                ["name"  => $this->nameCase($this->user_id)]
            )->id : false,

            "name"              => $this->nameCase($this->name),
            "mother_name"       => $this->nameCase($this->mother_name),
            "father_name"       => $this->nameCase($this->father_name),
            "emergency"         => [
                'name'      => $this->nameCase($this->emergency['name']),
                'relation'  => $this->emergency['relation'],
                'address'   => $this->emergency['address'],
                'phone'     => $this->emergency['phone'],
                'is_know'   => $this->emergency['is_know'] ?? null,
            ],
        ]);
    }

    private function nameCase($name)
    {
        return str(str(Str::title($name))->whenContains('.', fn ($name) => (str($name)->explode('.')->map(fn ($name) => ucfirst($name)))->implode('.')))->value();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'tb_health_facility'            => 'required|string|max:50',
            'satellite_health_facility_id'  => 'required|integer',
            'start_treatment'               => 'required|date|before_or_equal:today',
            'no_regis'                      => 'required|numeric|max_digits:10',
            // 'worker_id'                     => 'required|integer',
            'user_id'                       => 'required|integer',
            'name'                          => 'required|string|max:50',
            'id_number'                     => 'required|integer|digits:16',
            'sex'                           => 'required|string|in:laki-laki,perempuan',
            'religion_id'                   => 'nullable|integer|between:1,6',
            'id_card_address'               => 'required|string',
            'residence_address'             => 'nullable|string',
            'district_id'                   => 'required|integer|digits:7',
            'age'                           => 'nullable|integer|between:1,100',
            'phone'                         => 'nullable|numeric|digits_between:10,16',
            'education_id'                  => 'nullable|integer|between:1,5',
            'marital_status'                => 'nullable|string|in:menikah,belum menikah,janda/duda',
            'has_job'                       => 'nullable|boolean',
            'workplace'                     => 'required_unless:has_job,0|exclude_unless:has_job,1|string|max:50',
            'work_address'                  => 'required_unless:has_job,0|exclude_unless:has_job,1|string',
            'dependent'                     => 'nullable|integer|between:0,100',
            'height'                        => 'nullable|integer|between:10,250',
            'weight'                        => 'nullable|integer|between:3,100',
            'mother_name'                   => 'nullable|string|max:50',
            'father_name'                   => 'nullable|string|max:50',
            'guardian_address'              => 'nullable|string',
            'guardian_phone'                => 'nullable|numeric|digits_between:10,16',
            'emergency'                     => 'nullable|array|size:5',
            "emergency.name"                => 'nullable|string|max:50',
            "emergency.relation"            => 'nullable|string|max:50',
            "emergency.address"             => 'nullable|string',
            "emergency.phone"               => 'nullable|numeric|digits_between:10,16',
            "emergency.is_know"             => 'nullable|boolean',
            'pertemuan'                     => 'nullable'
        ];
    }
}