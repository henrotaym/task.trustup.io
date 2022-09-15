<?php

namespace App\Http\Resources;

use App\Models\Task as TaskModel;
use Illuminate\Http\Resources\Json\JsonResource;
use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Models\UserContract;
use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Transformers\Models\UserTransformerContract;

class Task extends JsonResource
{
    /** @var TaskModel */
    public $resource;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var UserTransformerContract */
        $transformer = app()->make(UserTransformerContract::class);
        
        return [
            'id' => $this->resource->getId(),
            'uuid' => $this->resource->getUuid(),
            'title' => $this->resource->getTitle(),
            'is_done' => $this->resource->isDone(),
            'done_at' => $this->resource->getDoneAt(),
            'due_date' => $this->resource->getDueDate(),
            'is_having_due_date_time' => $this->resource->isHavingDueDateTime(),
            'users' => $this->resource->getUsers()->map(fn (UserContract $user) =>
                $transformer->toArray($user)
            ),
            'app_key' => $this->resource->getAppKey(),
            'model_id' => $this->resource->getModelId(),
            'model_type' => $this->resource->getModelType(),
            'options' => $this->resource->getOptions()
        ];
    }
}
