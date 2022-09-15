<?php
namespace App\Contracts\Queries;

use Henrotaym\LaravelModelQueries\Queries\Contracts\QueryContract;
use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Requests\Task\IndexTaskRequestContract;
use Henrotaym\LaravelTrustupTaskIoCommon\Enum\Requests\Task\TaskStatus;

interface TaskQueryContract extends QueryContract
{
    /** @return static */
    public function matchingIndexRequest(IndexTaskRequestContract $request): TaskQueryContract;

    /** @return static */
    public function whereModelId(int $modelId): TaskQueryContract;

    /** @return static */
    public function whereModelType(string $modelType): TaskQueryContract;

    /** @return static */
    public function whereAppKey(?string $appKey): TaskQueryContract;

    /** @return static */
    public function whereUuid(string $uuid): TaskQueryContract;

    public function whereStatus(TaskStatus $status): TaskQueryContract;
}