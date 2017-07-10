<?php

namespace Escape\Argon\Media\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class FolderStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    {
        return [
            'parent_id' => 'required',
            'name' => 'unique:media_folders,name,NULL,id,parent,'.$request->get('parent_id'),
        ];
    }
}
