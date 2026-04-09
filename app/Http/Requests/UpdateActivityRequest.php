<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ApiResponse;

class UpdateActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'         => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'description'   => 'nullable|string',
            'cover_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'pdf_file'      => 'nullable|mimes:pdf|max:20480',
            'activity_date' => 'nullable|date',
            'location'      => 'nullable|string|max:500',
            'status'        => 'nullable|boolean',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ApiResponse::error('Validation failed', $validator->errors(), 422)
        );
    }
}
