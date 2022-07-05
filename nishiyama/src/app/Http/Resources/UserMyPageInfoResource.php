<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserMyPageInfoResource extends JsonResource
{
    protected $user;
    protected $company;
    protected $userInfo;
    protected $address;
    protected $shippings;
    protected $inCharges;

    public function __construct($user, $company, $userInfo, $address, $shippings, $inCharges)
    {
        $this->user = $user;
        $this->company = $company;
        $this->userInfo = $userInfo;
        $this->address = $address;
        $this->shippings = $shippings;
        $this->inCharges = $inCharges;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'in_charge_count' => $this->inCharges->count(),
            'shipping_count' => $this->shippings->count(),
            'user' => [
                "type" => $this->company->type ?? 3,
                "image" => $this->address->image ?? '',
                "company_name" => $this->address->name ?? '',
                "user_name" => $this->address->name ?? '',
                "email" => $this->user->email ?? '',
                "postal_code" => $this->address->postal_code ?? '',
                "prefecture" => $this->address->prefecture ?? '',
                "city" => $this->address->city ?? '',
                "address" => $this->address->address ?? '',
                "building" => $this->address->building ?? '',
                "tel" => $this->address->tel ?? '',
                "fax" => $this->address->fax ?? '',
                "other" => $this->address->other ?? '',
            ],
            'in_charge' => $this->inCharges,
            'shipping' => $this->shippings
        ];
    }
}
