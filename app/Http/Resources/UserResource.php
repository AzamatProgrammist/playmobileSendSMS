<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => (int) $this->id,
            'uuid' => $this->when($this->uuid, (string) $this->uuid),
            'firstname' => (string) $this->firstname,
            'lastname' => (string) $this->lastname,
            'email' => $this->when($this->email, (string) $this->email),
            'phone' => $this->when($this->phone, (string) $this->phone),
            'birthday' => $this->when($this->birthday, optional($this->birthday)->format('Y-m-d H:i:s')),
            'gender' => $this->when($this->gender, (string) $this->gender),
            'email_verified_at' => $this->when($this->email_verified_at, optional($this->email_verified_at)->format('Y-m-d H:i:s')),
            'phone_verified_at' => $this->when($this->phone_verified_at, optional($this->phone_verified_at)->format('Y-m-d H:i:s')),
            'registered_at' => $this->when($this->created_at, optional($this->created_at)->format('Y-m-d H:i:s')),
            'active' => $this->when(isset($this->active), (bool) $this->active),
            'img' => $this->when($this->img, (string) $this->img),
            'role' => $this->when($this->role, $this->role),
            'orders_sum_price' => $this->when($this->order_details_sum_price, round($this->order_details_sum_price, 2)),

            'addresses' => UserAddressResource::collection($this->whenLoaded('addresses')),
            'invite' => InviteResource::make($this->whenLoaded('invite')),
            'shop' => ShopResource::make($this->whenLoaded('shop')),
            'wallet' => WalletResource::make($this->whenLoaded('wallet')),
            'point' => UserPointResource::make($this->whenLoaded('point')),
        ];
    }
}
