<?php

namespace Vanguard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->ut_id,
            'name' => $this->ut_name,
            'display_name' => $this->ut_displayname,
            'description' => $this->ut_desc
        ];
    }

}
