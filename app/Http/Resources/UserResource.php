<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    protected $showSensitiveFields = false;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (! $this->showSensitiveFields) {
            $this->resource->makeHidden(['email', 'phone']);
        }

        $data = parent::toArray($request);

        // 用户注册时可选绑定数据
        $data['bound_phone'] = $this->resource->phone ? true : false;
        $data['bound_wechat'] = ($this->resource->wechat_unionid) && ($this->resource->wecaht_openid) ? true : false;

        return $data;
    }

    // 在资源类中添加一个 showSensitiveFields 方法，用于控制是否显示敏感字段
    public function showSensitiveFields()
    {
        $this->showSensitiveFields = true;

        return $this;
    }
}
