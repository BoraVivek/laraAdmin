<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
     * @param User $user
     * @return array
     */
    public function rules(User &$user)
    {
        $rules =  [
            'name'      =>  'required|string|max:191',
            'role'      =>  'required|integer',
            'active'    => 'boolean',
            'banned'    =>  'boolean'
        ];

        if($this->getMethod() == "POST")
        {
            $rules += [
                'email'     =>  'required|string|email|max:191|unique:users',
                'password'  =>  'required|string|min:6',
            ];
        }else{
            $rules += [
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id),],
                'password'  =>  'sometimes|nullable|string|min:6',
            ];
        }

        return $rules;
    }
}
