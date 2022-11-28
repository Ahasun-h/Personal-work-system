<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'              => 'required|string',
            'transaction_type'   => 'required',
            'date'               => 'required|date',
            'account_id'         => 'required_if:transaction_method,==,2|integer',
            'cheque_number'      => 'nullable|string',
            'amount'             => 'required',
            'note'               => 'nullable|string',
        ];
    }
}
