<?php

namespace App\Http\Requests\Library;

use App\Http\Requests\Request;

class RemoveLibraryRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->route('library')->removable;
    }

    public function rules()
    {
        return [];
    }
}
