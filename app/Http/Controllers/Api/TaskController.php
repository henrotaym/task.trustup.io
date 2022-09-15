<?php
namespace App\Http\Controllers\Api;

use App\Models\Task as TaskModel;
use App\Http\Controllers\Controller;
use App\Contracts\Queries\TaskQueryContract;
use App\Contracts\Queries\TaskRepositoryContract;
use App\Http\Resources\Task as TaskResource;
use App\Http\Requests\Models\Task\IndexTaskRequest;
use App\Http\Requests\Models\Task\StoreTaskRequest;
use App\Http\Requests\Models\Task\UpdateTaskRequest;

class TaskControllerSave extends Controller
{
    public function store(
        StoreTaskRequest $request,
        TaskRepositoryContract $repository
    ) {
        $repository->setModel(new TaskModel)
            ->fromCommonTask($request->getParsed()->getTask())
            ->persist();

        return new TaskResource($repository->getModel());
    }

    public function update(
        TaskModel $task,
        UpdateTaskRequest $request,
        TaskRepositoryContract $repository
    ) {
        $repository->setModel($task)
            ->fromCommonTask($request->getParsed()->getTask())
            ->persist();

        return new TaskResource($repository->getModel());
    }

    public function index(
        IndexTaskRequest $request,
        TaskQueryContract $query
    ) {
        return TaskResource::collection($query->matchingIndexRequest($request->getParsed())->get());
    }

    public function destroy( 
        TaskModel $task,
        TaskRepositoryContract $repository
    ) {
        $repository->setModel($task)
            ->delete();

        return new TaskResource($repository->getModel());
    }

    public function show(
        TaskModel $task
    ) {
        return new TaskResource($task);
    }
}