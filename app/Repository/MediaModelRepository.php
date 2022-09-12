<?php
namespace App\Repository;

use App\Models\MediaModel;
use App\Repository\Abstracts\Repository;
use Henrotaym\LaravelTrustupMediaIoCommon\Contracts\Models\StorableMediaContract;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\MediaCollections\FileAdder;
use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;

/**
 * Handling email attachment model changes.
 * 
 * @extends \App\Repository\Abstracts\Repository<\App\Models\MediaModel>
 */
class MediaModelRepository extends Repository
{
    /** @var Collection<int, SpatieMedia> */
    protected Collection $media;

    /**
     * Setting model type attribute.
     * 
     * @param string $modelType
     * @return static
     */
    public function setModelType(string $modelType): self
    {
        $this->getModel()->model_type = $modelType;
        
        return $this;
    }

    /**
     * Setting model id attribute.
     * 
     * @param string $modelId
     * @return static
     */
    public function setModelId(string $modelId): self
    {
        $this->getModel()->model_id = $modelId;
        
        return $this;
    }

    /**
     * Setting model id attribute.
     * 
     * @param string|null $appKey
     * @return static
     */
    public function setAppKey(?string $appKey): self
    {
        $this->getModel()->app_key = $appKey;
        
        return $this;
    }

    /** @param Collection<int, StorableMediaContract> $media */
    public function addMediaCollection(Collection $media): self
    {
        return tap($this, fn () => $media->each([$this, 'addMedia']));
    }

    public function addMedia(StorableMediaContract $media): self
    {
        $adder = $this->addMediaByType($media);

        if ($media->hasCustomProperties()):
            $adder->withCustomProperties($media->getCustomProperties());
        endif;

        if ($media->getName()):
            $adder->usingFileName($media->getName());
        endif;

        $spatieMedia = $media->hasCollection() ?
            $adder->toMediaCollection($media->getCollection())
            : $adder->toMediaCollection();

        $this->getMedia()->push($spatieMedia);
        
        return $this;
    }

    protected function addMediaByType(StorableMediaContract $media): FileAdder
    {
        /** @var MediaModel */
        $model = $this->getModel();

        if ($media->isBase64()):
            return $model->addMediaFromBase64($media->getResource());
        endif;

        if ($media->isStream()):
            return $model->addMediaFromStream($media->getResource());
        endif;

        if ($media->isUrl()):
            return $model->addMediaFromUrl($media->getResource());
        endif;

        if ($media->isString()):
            return $model->addMediaFromString($media->getResource());
        endif;

        return $model->addMedia($media->getResource());
    }

    /** @return Collection<int, SpatieMedia> */
    public function getMedia(): Collection
    {
        return $this->media ??
            $this->media = collect();
    }
}