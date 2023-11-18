<?php

namespace App\Http\Requests\Admin\Teest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateTeest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.teest.edit', $this->teest);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'uuid' => ['sometimes', Rule::unique('teest', 'uuid')->ignore($this->teest->getKey(), $this->teest->getKeyName()), 'string'],
            'connection' => ['sometimes', 'string'],
            'queue' => ['sometimes', 'string'],
            'payload' => ['sometimes', 'string'],
            'exception' => ['sometimes', 'string'],
            'failed_at' => ['sometimes', 'date'],
            
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
