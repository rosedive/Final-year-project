<?php

namespace App\Http\Requests\Library;

use App\Http\Requests\Request;

class UpdateLibraryRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $hostel = $this->route('hostel');

        return [
            'regno' => 'required|exists:users,username',
            'book_title' => 'required',
            'book_sbbn' => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'regno.exists' => 'Registration number does not match any student',
        ];
    }
}
