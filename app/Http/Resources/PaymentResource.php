<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'id' => $this->id,
            'drive' => $this->drive->value,
            'statuses' => [
                'created' => $this->status('created'),
                'successful' => $this->status('successful'),
                'error' => $this->status('error')
            ],
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'description' => $this->description,
            'amount' => $this->amount,
            'amountUnit' => 'Toman',
            'callback' => $this->callback,
            'extra_callback' => $this->extra_callback,
            'information' => $this->information,
            'created_at' => $this->created_at,
            'logs' => PaymentLogResource::collection($this->logs)
        ];
    }
}
