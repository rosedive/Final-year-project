<?php

namespace App\Http\Requests\Hostel;

use App\Http\Requests\Request;

class RemoveHostelRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->route('hostel')->removable;
    }

    public function rules()
    {
        return [];
    }
}
