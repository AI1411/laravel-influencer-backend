<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => '名前は必ず指定してください',
            'last_name.required' => '苗字は必ず指定してください',
            'email.required' => 'メールアドレスは必ず指定してください',
        ];
    }
}
