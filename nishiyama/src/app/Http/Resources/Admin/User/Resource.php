<?php

namespace App\Http\Resources\Admin\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class Resource extends JsonResource
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
            // ★Laravelは class名 - Resource名 でモデルを自動判定してResourceクラス自身のプロパティとして保持する。よってい$thisでモデルと同様アクセスできる。はず。
            'id'                => $this->resource->id,
            'image'             => $this->getImage() ?? '',
            'name'              => $this->getName() ?? '',
            'email'             => $this->resource->email,
            'tel'               => $this->getTel(),
            'other'             => $this->getOther()
            // 【TODO：住所情報を追加】
            // 【TODO：コメントを追加】
        ];
    }
}
