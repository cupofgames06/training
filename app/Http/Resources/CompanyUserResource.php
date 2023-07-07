<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $name = empty($this->password)?'<span class="text-muted">'.$this->profile->full_name.'</span>':$this->profile->full_name;
        $email = empty($this->password)?'<span class="text-muted">'.$this->email.'</span>':$this->email;

        return [
            $name,
            $email,
            view('components.datatable.action._body', ['route' => route('company.users.edit', ['user'=>$this->id])])->render()
        ];
    }
}
