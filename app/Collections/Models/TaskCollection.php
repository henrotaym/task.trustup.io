<?php
namespace App\Collections\Models;

use App\Contracts\Api\Auth\Endpoints\UserEndpointContract;
use App\Models\Task;
use App\Enum\Models\Task\TaskExternalRelationship;
use Illuminate\Database\Eloquent\Collection;
use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Models\UserContract;
use Illuminate\Support\Collection as BaseCollection;

class TaskCollection extends Collection
{
    /**
     * User ids related to this collection as a map.
     * 
     * Key is user id and value is boolean.
     * 
     * @var BaseCollection<int, bool>
     */
    protected BaseCollection $userIdsMap;

    /**
     * Users related to this collection as a map.
     * 
     * Key is user id and value is user.
     * 
     * @var BaseCollection<int, UserContract>
     */
    protected BaseCollection $usersMap;

    /**
     * Loading given external relationship.
     * 
     * @param TaskExternalRelationship $relation
     * @return static
     */
    public function loadExternal(TaskExternalRelationship $relation): self
    {
        if ($relation === TaskExternalRelationship::USERS) return $this->loadUsers();

        return $this;
    }

    /**
     * Loading users from auth.
     * 
     * @return static
     */
    protected function loadUsers(): self
    {
        $this->each(fn (Task $task) =>
            $task->setAuthUsers(
                collect($task->getUserIds())->reduce(fn (BaseCollection $users, int $userId) =>
                    ($user = $this->getUsersMap()[$userId] ?? null) ?
                        $users->push($user)
                        : $users,
                    collect()
                )
            )
        );

        return $this;
    }

    /**
     * Getting users id map.
     * 
     * Key is user id and value is boolean.
     * 
     * @return BaseCollection<int, bool>
     */
    protected function getUserIdsMap(): BaseCollection
    {
        if (isset($this->userIdsMap)) return $this->userIdsMap;

        return $this->userIdsMap = $this->reduce(fn (BaseCollection $map, Task $task) =>
            tap($map, fn () =>
                collect($task->getUserIds())->each(fn (int $userId) =>
                    $map[$userId] = true
                )
            ),
            collect()
        );
    }

    protected function getUsersMap(): BaseCollection
    {
        if (isset($this->usersMap)) return $this->usersMap;

        $ids = $this->getUserIdsMap()->keys();

        /** @var UserEndpointContract */
        $endpoint = app()->make(UserEndpointContract::class);
        $users = $endpoint->getUserByIds($ids->all());

        return $this->usersMap = $users->reduce(fn (BaseCollection $map, UserContract $user) =>
            tap($map, fn () =>
                $map[$user->getId()] = $user
            ),
            collect()
        );
    }
}