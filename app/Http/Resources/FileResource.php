<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'          =>      $this->id,
            'name'        =>      $this->name,
            'path'        =>      $this->path,
            'reserve'     =>      $this->is_reserve == false ? "No" : "Yes",
            'group'       =>      is_null($this->group) ? null : $this->group->name,

        ];
    }
}