<?php
namespace App\Actions\Models\Task\Private;

use App\Contracts\Actions\ActionContract;
use App\Contracts\Repository\TaskRepositoryContract;
use App\Models\Task;
use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Requests\Task\_Private\TaskRequestContract;

abstract class FromTaskRequest implements ActionContract
{
    protected TaskRequestContract $request;
    protected TaskRepositoryContract $repository;
    protected Task $model;
    
    public function __construct(TaskRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /** @return static */
    public function setRequest(TaskRequestContract $request): FromTaskRequest
    {
        $this->request = $request;

        return $this;
    }

    /** @return static */
    public function setModel(Task $model): FromTaskRequest
    {
        $this->model = $model;

        return $this;
    }

    public function handle(): void
    {
        $this->repository->setModel($this->model)
            ->fromCommonTask($this->request->getTask())
            ->persist();
    }

    public function getTask(): Task
    {
        return $this->model;
    }
}