<?php
namespace App\Contracts\Queries;

use Henrotaym\LaravelModelQueries\Queries\Contracts\QueryContract;
use Henrotaym\LaravelTrustupMediaIoCommon\Contracts\Requests\Media\_Private\MediaRequestContract;

interface MediaModelQueryContract extends QueryContract
{
    /** @return static */
    public function matchingRequest(MediaRequestContract $request): MediaModelQueryContract;

    /** @return static */
    public function whereModelId(int $modelId): MediaModelQueryContract;

    /** @return static */
    public function whereModelType(string $modelType): MediaModelQueryContract;

    /** @return static */
    public function whereAppKey(?string $appKey): MediaModelQueryContract;
}