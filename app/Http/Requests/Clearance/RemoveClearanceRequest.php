<?php

namespace App\Http\Requests\Clearance;

use App\Http\Requests\Request;

class RemoveClearanceRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->route('clearance')->removable;
    }

    public function rules()
    {
        return [];
    }
}
