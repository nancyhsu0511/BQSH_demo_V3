<?php

namespace App\Http\Requests;
use Session;

use App\Http\Requests\Request;

class CourseFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		Session::flash('tab', 'form');
        return [
            'course_name'	=> 'required|min:2',
            // 'description'	=> 'required',
            // 'attached_doc'	=> 'mimes:doc,docx',
            // 'attached_pdf'	=> 'mimes:pdf'
        ];
    }
}
