<?php
namespace App\Repository;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Abstracts\Model;
use Illuminate\Support\Collection;
use App\Repository\Abstracts\Repository;
use App\Contracts\Repository\TaskRepositoryContract;
use App\Contracts\Repository\Private\RepositoryContract;
use Henrotaym\LaravelTrustupTaskIoCommon\Models\Traits\HasOptions;
use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Models\TaskContract;
use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Models\UserContract;

/**
 * Handling email attachment model changes.
 * 
 * @extends \App\Repository\Abstracts\Repository<\App\Models\Task>
 */
class TaskRepository extends Repository implements TaskRepositoryContract
{
    use HasOptions;

        /**
     * Setting related model.
     * 
     * @param Task $model
     * @return static
     */
    public function setModel(Model $model): RepositoryContract
    {
        parent::setModel($model);
        $this->resetOptions()
            ->setOptions($model->getOptions());

        return $this;
    }

    /**
     * Setting model type attribute.
     * 
     * @param string $modelType
     * @return static
     */
    public function setModelType(string $modelType): self
    {
        $this->getModel()->model_type = $modelType;
        
        return $this;
    }

    /**
     * Setting model id attribute.
     * 
     * @param string $modelId
     * @return static
     */
    public function setModelId(string $modelId): self
    {
        $this->getModel()->model_id = $modelId;
        
        return $this;
    }

    /**
     * Setting model id attribute.
     * 
     * @param string|null $appKey
     * @return static
     */
    public function setAppKey(?string $appKey): self
    {
        $this->getModel()->app_key = $appKey;
        
        return $this;
    }

    /** @return static */
    public function setTitle(string $title): self
    {
        $this->getModel()->title = $title;

        return $this;
    }

    /** @return static */
    public function setDoneAt(?Carbon $doneAt): self
    {
        $this->getModel()->done_at = $doneAt;

        return $this;
    }

    /** @return static */
    public function setIsDone(bool $isDone): self
    {
        return $this->setDoneAt($isDone ? now() : null);
    }

    /** @return static */
    public function setDueDate(?Carbon $dueDate): self
    {
        $this->getModel()->due_date = $dueDate;

        return $this;
    }

    /** @return static */
    public function setIsHavingDueDateTime(bool $isHavingDueDateTime): self
    {
        $this->getModel()->having_due_date_time = $isHavingDueDateTime;

        return $this;
    }

    public function setUsers(Collection $users): self
    {
        $this->getModel()->user_ids = $users->map(fn (UserContract $user) =>
            $user->getId() 
        )->all();

        return $this;
    }

    public function fromCommonTask(TaskContract $task): self
    {
        $this->setDueDate($task->getDueDate())
            ->setTitle($task->getTitle())
            ->setDoneAt($task->getDoneAt())
            ->setIsHavingDueDateTime($task->isHavingDueDateTime())
            ->setOptions($task->getOptions())
            ->setUsers($task->getUsers())
            ->setAppKey($task->getAppKey())
            ->setModelId($task->getModelId())
            ->setModelType($task->getModelType());
        
        $this->getModel()->options = $this->options;

        return $this;
    }
}