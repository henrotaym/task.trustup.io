<?php
namespace App\Api\Auth\Endpoints;

use Illuminate\Support\Collection;
use App\Api\Auth\Credentials\AuthCredential;
use Henrotaym\LaravelApiClient\Contracts\ClientContract;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use App\Contracts\Api\Auth\Endpoints\UserEndpointContract;
use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Models\UserContract;
use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Transformers\Models\UserTransformerContract;

class UserEndpoint implements UserEndpointContract
{
    protected ClientContract $client;
    protected UserTransformerContract $userTransformer;

    public function __construct(
        ClientContract $client,
        UserTransformerContract $userTransformer
    ) {
        $this->client = $client->setCredential(new AuthCredential);
        $this->userTransformer = $userTransformer;
    }

    /**
     * @param array<int> îds
     * @return Collection<int, UserContract>
     */
    public function getUserByIds(array $ids): Collection
    {
        /** @var RequestContract */
        $request = app()->make(RequestContract::class);
        $request->setVerb('POST')
            ->setUrl('users/by-ids')
            ->addData(['ids' => $ids]);

        $response = $this->client->try($request, "Could not retrieve users using given ids.");

        if ($response->failed()):
            report($response->error());
            return collect();
        endif;

        return collect($response->response()->get(true)['users'])
            ->map(fn (array $rawUser) => 
                $this->userTransformer->fromArray($rawUser)
            );
    }
}