<?php

namespace Vanguard\Http\Requests\UserTypes;

use Vanguard\Http\Requests\Request;
use Vanguard\Type;

class UpdateTypeRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $type = $this->route('type');

        // echo json_encode($type);
        // die();

        return [
            'ut_name' => 'required|regex:/^[a-zA-Z0-9\-_\.]+$/|unique:ref_user_types,ut_name,' . $type->ut_id
        ];
    }
}
