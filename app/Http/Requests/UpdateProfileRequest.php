<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [

            'name' => ['required', 'string', 'max:255', 'unique:' . User::class],

            'bio' => ['max:300'],

            //'avatar' => ['image', 'max:2048', 'mimes:jpeg,png,webp'],

            'website' => ['url'],
        ];
    }

}
