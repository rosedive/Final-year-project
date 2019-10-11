<?php

namespace App\Http\Requests\Library;

use App\Http\Requests\Request;
use App\User;

class CreateLibraryRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'regno' => 'required|exists:users,username',
            'book_title' => 'required',
            'book_sbbn' => 'numeric',
            'type' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'regno.exists' => 'Registration number does not match any student',
        ];
    }
}
