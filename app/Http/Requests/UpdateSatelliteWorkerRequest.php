<?php

namespace App\Http\Requests;

use Illuminate\Routing\Redirector;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSatelliteWorkerRequest extends FormRequest
{
    public function convertRequest(string $request_class): UpdateSatelliteWorkerRequest
    {
        $Request = $request_class::createFrom($this);

        $app = app();
        $Request
            ->setContainer($app)
            ->setRedirector($app->make(Redirector::class));

        $Request->prepareForValidation();
        $Request->getValidatorInstance();

        return $Request;
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }
}
