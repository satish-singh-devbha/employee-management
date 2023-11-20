<?php

namespace App\Http\Requests\Admin\Employee;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;

class EditStorePostRequest extends FormRequest
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
            "name" => "required|min:5|max:50",
            "buildingNo" => "required|min:3|max:10",
            "streetName" => "required|min:5|max:40",
            "city" => "required|exists:cities,id|max:25",
            "state" => "required|exists:states,id|max:25",
            "country" => "required|exists:countries,id|max:25",
            "pincode" => "required|min:5|max:10",
        ];
    }
}
