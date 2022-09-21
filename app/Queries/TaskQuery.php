<?php
namespace App\Queries;

use App\Contracts\Queries\TaskQueryContract;
use App\Models\Task;
use Henrotaym\LaravelModelQueries\Queries\Abstracts\AbstractQuery;
use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Requests\Task\IndexTaskRequestContract;
use Henrotaym\LaravelTrustupTaskIoCommon\Enum\Requests\Task\TaskStatus;

class TaskQuery extends AbstractQuery implements TaskQueryContract
{
    public function getModel(): string
    {
        return Task::class;
    }

    /** @return static */
    public function matchingIndexRequest(IndexTaskRequestContract $request): TaskQueryContract
    {
        $query =  $this->whereAppKey($request->getAppKey())
            ->whereModelId($request->getModelId())
            ->whereModelType($request->getModelType())
            ->whereStatus($request->getStatus());

        return $query;
    }

    /** @return static */
    public function whereModelId(string $modelId): TaskQueryContract
    {
        $this->getQuery()->where('model_id', $modelId);

        return $this;
    }

    /** @return static */
    public function whereModelType(string $modelType): TaskQueryContract
    {
        $this->getQuery()->where('model_type', $modelType);

        return $this;
    }

    /** @return static */
    public function whereAppKey(?string $appKey): TaskQueryContract
    {
        $this->getQuery()->where('app_key', $appKey);

        return $this;
    }

    /** @return static */
    public function whereUuid(string $uuid): TaskQueryContract
    {
        $this->getQuery()->where('uuid', $uuid);

        return $this;
    }

    /** @return static */
    public function whereStatus(TaskStatus $status): TaskQueryContract
    {
        match($status) {
            TaskStatus::DONE => $this->getQuery()->whereNotNull('done_at'),
            TaskStatus::NOT_DONE => $this->getQuery()->whereNull('done_at'),
            TaskStatus::ALL => $this->getQuery()->where(fn ($query) =>
                $query->whereNotNull('done_at')
                    ->orWhereNull('done_at')
            )
        };

        return $this;
    }
}