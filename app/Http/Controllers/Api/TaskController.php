<?php
namespace App\Http\Controllers\Api;

use App\Models\Task as TaskModel;
use App\Http\Controllers\Controller;
use App\Actions\Models\Task\DeleteTask;
use App\Collections\Models\TaskCollection;
use App\Contracts\Queries\TaskQueryContract;
use App\Http\Resources\Task as TaskResource;
use App\Actions\Models\Task\StoreFromRequest;
use App\Actions\Models\Task\UpdateFromRequest;
use App\Enum\Models\Task\TaskExternalRelationship;
use App\Http\Requests\Models\Task\IndexTaskRequest;
use App\Http\Requests\Models\Task\StoreTaskRequest;
use App\Http\Requests\Models\Task\UpdateTaskRequest;

class TaskController extends Controller
{
    public function store(
        StoreTaskRequest $request,
        StoreFromRequest $action
    ) {
        $action->setRequest($request->getParsed())
            ->handle();

        return new TaskResource($action->getTask());
    }

    public function update(
        TaskModel $task,
        UpdateTaskRequest $request,
        UpdateFromRequest $action
    ) {
        $action->setRequest($request->getParsed())
            ->setModel($task)
            ->handle();

        return new TaskResource($action->getTask());
    }

    public function index(
        IndexTaskRequest $request,
        TaskQueryContract $query
    ) {
        /** @var TaskCollection */
        $tasks = $query->matchingIndexRequest($request->getParsed())->get();
        $tasks->loadExternal(TaskExternalRelationship::USERS);

        return TaskResource::collection($tasks);
    }

    public function destroy( 
        TaskModel $task,
        DeleteTask $action
    ) {
        $action->setModel($task)
            ->handle();

        return new TaskResource($action->getTask());
    }

    public function show(
        TaskModel $task
    ) {
        return new TaskResource($task);
    }
}