<?php

namespace App\Http\Requests\Option;

use App\Http\Requests\Request;

class RemoveOptionRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->route('option')->removable;
    }

    public function rules()
    {
        return [];
    }
}
