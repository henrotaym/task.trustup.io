<?php
namespace App\Contracts\Api\Auth\Endpoints;

use Henrotaym\LaravelContainerAutoRegister\Services\AutoRegister\Contracts\AutoRegistrableContract;
use Illuminate\Support\Collection;
use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Models\UserContract;

interface UserEndpointContract extends AutoRegistrableContract
{
    /**
     * @param array<int> îds
     * @return Collection<int, UserContract>
     */
    public function getUserByIds(array $ids): Collection;
}