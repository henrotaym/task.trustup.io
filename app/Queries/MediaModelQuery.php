<?php
namespace App\Queries;

use App\Contracts\Queries\MediaModelQueryContract;
use App\Models\MediaModel;
use Henrotaym\LaravelModelQueries\Queries\Abstracts\AbstractQuery;
use Henrotaym\LaravelTrustupMediaIoCommon\Contracts\Requests\Media\_Private\MediaRequestContract;

class MediaModelQuery extends AbstractQuery implements MediaModelQueryContract
{
    public function getModel(): string
    {
        return MediaModel::class;
    }

    /** @return static */
    public function matchingRequest(MediaRequestContract $request): MediaModelQueryContract
    {
        return $this->whereAppKey($request->getAppKey())
            ->whereModelId($request->getModelId())
            ->whereModelType($request->getModelType());
    }

    /** @return static */
    public function whereModelId(int $modelId): MediaModelQueryContract
    {
        $this->getQuery()->where('model_id', $modelId);

        return $this;
    }

    /** @return static */
    public function whereModelType(string $modelType): MediaModelQueryContract
    {
        $this->getQuery()->where('model_type', $modelType);

        return $this;
    }

    /** @return static */
    public function whereAppKey(?string $appKey): MediaModelQueryContract
    {
        $this->getQuery()->where('app_key', $appKey);

        return $this;
    }
}