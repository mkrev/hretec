<?php

namespace App\Http\Requests\Contents;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
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
        return [
            'title' => 'required|max:255',
            'movie' => 'nullable|max:1000000|mimes:mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv'
        ];
    }
}
