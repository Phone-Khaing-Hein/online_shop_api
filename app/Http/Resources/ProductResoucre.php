<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResoucre extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function stockStatus($count){
        $status="";

        if($count === 0){
            $status = "Out of Stock!";
        }elseif ($count > 0 && $count <= 20) {
            $status = "A few product left!";
        }else{
            $status = "Available";
        }
        return $status;
    }

    public function toArray($request)
    {
        return [
            "id"=>$this->id,
            "name"=>$this->name,
            "price"=>$this->price,
            "show_price"=>$this->price." mmk",
            "stock"=>$this->stock,
            "stock_status"=>$this->stockStatus($this->stock),
            "date"=>$this->created_at->format("d M Y"),
            "time"=>$this->created_at->format("h:i a"),
            "owner"=> new UserResource($this->user),
            "photots"=> PhotoResource::collection($this->photos)
        ];
    }
}
