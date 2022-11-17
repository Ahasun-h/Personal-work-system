<?php

namespace App\Http\Requests\Expense;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'expense_title'    => 'required|string',
            'expense_date'     => 'required|date',
            'account_id'       => 'required_if:transaction_way,==,2|integer',
            'cheque_number'    => 'nullable|string',
            'amount'           => 'required',
            'note'             => 'nullable|string',
        ];
    }
}
