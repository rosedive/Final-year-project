<?php

namespace App\Http\Requests\Registration;

use App\Http\Requests\Request;

class RemoveRegistrationRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->route('registration')->removable;
    }

    public function rules()
    {
        return [];
    }
}
