<?php

namespace App\Http\Requests\Result;

use App\Http\Requests\Request;

class RemoveResultRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->route('result')->removable;
    }

    public function rules()
    {
        return [];
    }
}
