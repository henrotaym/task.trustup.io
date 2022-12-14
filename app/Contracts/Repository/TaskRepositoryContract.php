<?php
namespace App\Contracts\Repository;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Contracts\Repository\Private\RepositoryContract;
use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Models\TaskContract;
use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Models\Traits\HasOptionContract;

/**
 * Handling email attachment model changes.
 * 
 * @extends \App\Repository\Abstracts\Repository<\App\Models\Task>
 */
interface TaskRepositoryContract extends RepositoryContract, HasOptionContract
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
     * Setting model professional authorization key.
     * 
     * @param ?string $professionalAuthorizationKey
     * @return static
     */
    public function setProfessionalAuthorizationKey(?string $professionalAuthorizationKey): self;

    /**
     * Setting model account uuid.
     * 
     * @param ?string $accountUuid
     * @return static
     */
    public function setAccountUuid(?string $accountUuid): self;

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
    public function setDueDate(?Carbon $dueDate): self;

    /** @return static */
    public function setIsHavingDueDateTime(bool $isHavingDueDateTime): self;

    public function setUsers(Collection $users): self;
    
    public function fromCommonTask(TaskContract $task): self;
}