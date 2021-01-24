<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parent' => $this->when(!is_null($this->parent), $this->parent),
            'name' => $this->name,
            'children' => $this->when($this->children()->count() > 0, new TagCollection($this->children)),
            'dirve' => $this->when($this->drive()->exists(), new DriveResource($this->drive()->first()))
        ];
    }
}
