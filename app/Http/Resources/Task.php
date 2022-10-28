<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Models\Task as TaskModel;
use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Models\UserContract;
use Henrotaym\LaravelTrustupMessagingIo\Http\Resources\MessagingIoModel;
use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Transformers\Models\UserTransformerContract;
use stdClass;

class Task extends MessagingIoModel
{
    /** @var TaskModel */
    public $resource;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    protected function getAttributes(Request $request): array
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
            'professional_authorization_key' => $this->resource->getProfessionalAuthorizationKey(),
            'account_uuid' => $this->resource->getAccountUuid(),
            'options' => count($this->resource->getOptions()) ?
                $this->resource->getOptions()
                : new stdClass
        ];
    }
}
