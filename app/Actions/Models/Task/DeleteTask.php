<?php
namespace App\Actions\Models\Task;

use App\Contracts\Actions\ActionContract;
use App\Contracts\Repository\TaskRepositoryContract;
use App\Models\Task;

class DeleteTask implements ActionContract
{
    protected TaskRepositoryContract $repository;
    protected Task $model;
    
    public function __construct(TaskRepositoryContract $repository)
    {
        $this->repository = $repository;
    }
    

    /** @return static */
    public function setModel(Task $model): DeleteTask
    {
        $this->model = $model;

        return $this;
    }

    public function handle(): void
    {
        $this->repository->setModel($this->model)
            ->delete();
    }

    public function getTask(): Task
    {
        return $this->model;
    }
}