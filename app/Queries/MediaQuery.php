<?php
namespace App\Queries;

use App\Contracts\Queries\MediaQueryContract;
use App\Models\MediaModel;
use Henrotaym\LaravelModelQueries\Queries\Abstracts\AbstractQuery;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaQuery extends AbstractQuery implements MediaQueryContract
{
    public function getModel(): string
    {
        return Media::class;
    }

    /** @return static */
    public function whereMediaModel(MediaModel $model): MediaQueryContract
    {
        $this->setQuery($model->media()->getQuery());

        return $this;
    }

    /** @return static */
    public function whereCollection(?string $collection): MediaQueryContract
    {
        $this->getQuery()->where('collection_name', $collection ?? 'default');

        return $this;
    }
}