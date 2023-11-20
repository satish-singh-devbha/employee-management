<?php

namespace App\Http\Requests\Admin\Employee;

use Illuminate\Foundation\Http\FormRequest;

class AddStorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "employeeId" => "required|unique:users,employee_id|max:15",
            "name" => "required|min:5|max:50",
            "email" => "required|email|unique:users,email|min:5|max:40",
            "password" => "required|confirmed|min:8|max:25",
            "buildingNo" => "required|min:3|max:10",
            "streetName" => "required|min:5|max:40",
            "city" => "required|exists:cities,id|max:25",
            "state" => "required|exists:states,id|max:25",
            "country" => "required|exists:countries,id|max:25",
            "pincode" => "required|min:5|max:10",
        ];
    }
}
