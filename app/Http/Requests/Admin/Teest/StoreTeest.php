<?php

namespace App\Http\Requests\Admin\Teest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreTeest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.teest.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'uuid' => ['required', Rule::unique('teest', 'uuid'), 'string'],
            'connection' => ['required', 'string'],
            'queue' => ['required', 'string'],
            'payload' => ['required', 'string'],
            'exception' => ['required', 'string'],
            'failed_at' => ['required', 'date'],
            
        ];
    }

    /**
    * Modify input data
    *
    * @return array
    */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
