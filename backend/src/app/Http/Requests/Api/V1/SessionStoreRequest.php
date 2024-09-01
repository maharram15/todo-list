<?php

namespace App\Http\Requests\Api\V1;

use App\Exceptions\LoginException;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

class SessionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => 'required',
            'password' => 'required',
        ];
    }

    /**
     * @throws LoginException
     */
    protected function failedValidation(Validator $validator): never
    {
        throw new LoginException();
    }
}
