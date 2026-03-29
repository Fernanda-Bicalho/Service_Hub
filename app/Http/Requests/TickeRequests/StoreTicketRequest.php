<?php

namespace App\Http\Requests\TickeRequests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'project_id' => ['required', 'exists:projects,id'],
        'ticket_title' => ['required', 'string'],
        'ticket_description' => ['required', 'string'],
        'ticket_status' => ['sometimes', 'in:pending,processing,done,error'],
        'ticket_attachment' => ['nullable']
        ];
    }
}
