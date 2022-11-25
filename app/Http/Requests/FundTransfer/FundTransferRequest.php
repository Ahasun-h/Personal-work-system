<?php

namespace App\Http\Requests\FundTransfer;

use Illuminate\Foundation\Http\FormRequest;

class FundTransferRequest extends FormRequest
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
        return[
            'title'              => 'required|string',
            'date'               => 'required|date',
            'out_account'        => 'required',
            'in_account'         => 'required|different:out_account',
            'cheque_number'      => 'nullable|string',
            'amount'             => 'required',
            'note'               => 'nullable|string',
        ];
    }
}
