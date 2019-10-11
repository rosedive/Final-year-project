<?php

namespace App\Http\Requests\Finance;

use App\Http\Requests\Request;

class RemoveFinanceRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->route('finance')->removable;
    }

    public function rules()
    {
        return [];
    }
}
