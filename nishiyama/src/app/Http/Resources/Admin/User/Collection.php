<?php

namespace App\Http\Resources\Admin\User;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Request;

class Collection extends ResourceCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->resource = $this->collectResource($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            // $this->collectionに付加情報を設定する。
            'data' => $this->collection->transform(function ($user) use ($request) {
                return [
                    'id'                => $user->id,
                    'user_type_code'    => $user->type ?? '',
                    'user_type_name'    => config('user.type')[$user->type] ?? '' ,
                    'image'             => $user->image ?? '',
                    'name'              => $user->name ?? '',
                    'email'             => $user->email,
                    'status_code'       => $user->status,
                    'status_name'       => config('user.status')[$user->status] ?? '',
                ];
            })
        ];
    }

    /**
     * Getリソース配列とともに返す必要のある追加データ
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [];
    }

}
