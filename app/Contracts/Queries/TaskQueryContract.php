<?php
namespace App\Contracts\Queries;

use Illuminate\Support\Collection;
use Henrotaym\LaravelModelQueries\Queries\Contracts\QueryContract;
use Henrotaym\LaravelTrustupTaskIoCommon\Enum\Requests\Task\TaskStatus;
use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Requests\Task\IndexTaskRequestContract;

interface TaskQueryContract extends QueryContract
{
    /** @return static */
    public function matchingIndexRequest(IndexTaskRequestContract $request): TaskQueryContract;

    /** @return static */
    public function whereModelId(string $modelId): TaskQueryContract;

    /** @return static */
    public function whereModelType(string $modelType): TaskQueryContract;

    /** @return static */
    public function whereProfessionalAuthorizationKey(string $professionalAuthorizationKey): TaskQueryContract;

    /** @return static */
    public function whereAccountUuid(string $accountUuid): TaskQueryContract;

    /** @return static */
    public function whereAppKey(?string $appKey): TaskQueryContract;

    /** @return static */
    public function whereUuid(string $uuid): TaskQueryContract;

    public function whereStatus(TaskStatus $status): TaskQueryContract;

    /**
     * @param Collection<int, int> $userIds
     * @return static
     */
    public function whereUserIds(Collection $userIds): TaskQueryContract;

    /** @return static */
    public function orderByLatestDueDate(): TaskQueryContract;

    /** @return static */
    public function orderByOldestDueDate(): TaskQueryContract;
}