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
        $nameRule = ['required', 'string', 'max:255'];

        if ($this->input('name') == auth()->user()->name) {
            $nameRule = array_diff($nameRule, ['unique:' . User::class]);
        }

        return [
            'name' => $nameRule,
            'about' => ['max:300'],
            'avatar' => ['image', 'max:2048', 'mimes:jpg,png,webp'], // Updated validation rules for 'avatar'
            'website' => ['url'],
        ];
    }
}
