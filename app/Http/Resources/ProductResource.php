<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =  [
            'id' => $this->id,
            'name' => $this->name,
            'detail' => $this->detail,
            'price' => $this->price,
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y H:i:s'),
            'updated_at' => $this->updated_at != null ? Carbon::parse($this->updated_at)->format('d/m/Y H:i:s') : null,
            'deleted_at' => $this->deleted_at != null ? Carbon::parse($this->deleted_at)->format('d/m/Y H:i:s') : null,
            'action' => null
            //'deleted_at' => $this->updated_at->format('d/m/Y H:i:s')
        ];
        return $data;
        //return parent::toArray($request);
    }
}
