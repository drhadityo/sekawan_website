<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;

// use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkerRequest extends UpdateSatelliteWorkerRequest
{
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
        $this->merge(
            ["name"  => str(str(Str::title($this->name))->whenContains('.', fn ($name)
            => (str($name)->explode('.')->map(fn ($name) => ucfirst($name)))->implode('.')))->value()]
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'      => "required|string|unique:workers|max:64",
        ];
    }
}
