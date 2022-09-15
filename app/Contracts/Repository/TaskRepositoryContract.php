<?php
namespace App\Contracts\Queries;

use Carbon\Carbon;
use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Models\TaskContract;
use Illuminate\Support\Collection;

/**
 * Handling email attachment model changes.
 * 
 * @extends \App\Repository\Abstracts\Repository<\App\Models\Task>
 */
interface TaskRepositoryContract extends RepositoryContract
{
        /**
     * Setting model type attribute.
     * 
     * @param string $modelType
     * @return static
     */
    public function setModelType(string $modelType): self;
    /**
     * Setting model id attribute.
     * 
     * @param string $modelId
     * @return static
     */
    public function setModelId(string $modelId): self;

    /**
     * Setting model id attribute.
     * 
     * @param string|null $appKey
     * @return static
     */
    public function setAppKey(?string $appKey): self;

    /** @return static */
    public function setTitle(string $title): self;

    /** @return static */
    public function setDoneAt(?Carbon $doneAt): self;

    /** @return static */
    public function setIsDone(bool $isDone): self;

    /** @return static */
    public function setDueDate(Carbon $dueDate): self;

    /** @return static */
    public function setIsHavingDueDateTime(bool $isHavingDueDateTime): self;

    public function setUsers(Collection $users): self;
    
    public function fromCommonTask(TaskContract $task): self;
}