<?php

namespace App\Http\Requests\Finance;

use App\Http\Requests\Request;

class UpdateFinanceRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $finance = $this->route('finance');

        return [
            'regno' => 'required|exists:users,username',
            'level' => 'required',
            'bankslip_no' => 'required',
            'expected_amount' => 'required|numeric',
            'amount_paid' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'regno.exists' => 'Registration number does not match any student',
        ];
    }
}
