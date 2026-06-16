<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class AccountLedgerRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'from_date' => ['nullable', 'date'],
            'to_date' => ['nullable', 'date'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($validator->errors()->has('from_date') || $validator->errors()->has('to_date')) {
                    return;
                }

                if (! $this->filled('from_date') || ! $this->filled('to_date')) {
                    return;
                }

                if (
                    Carbon::parse($this->input('from_date'))->greaterThan(
                        Carbon::parse($this->input('to_date'))
                    )
                ) {
                    $validator->errors()->add(
                        'to_date',
                        'The end date must be the same as or later than the start date.'
                    );
                }
            },
        ];
    }
}
