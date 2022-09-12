<?php
namespace App\Actions\Models\MediaModel;

use App\Models\MediaModel;
use Illuminate\Support\Collection;
use App\Repository\MediaModelRepository;
use App\Contracts\Queries\MediaQueryContract;
use App\Contracts\Queries\MediaModelQueryContract;
use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;
use Henrotaym\LaravelTrustupMediaIoCommon\Contracts\Requests\Media\GetMediaRequestContract;

class GetMediaFromRequest
{
    protected MediaModelRepository $repository;
    protected MediaModelQueryContract $mediaModelQuery;
    protected MediaQueryContract $mediaQuery;
    protected MediaModel $mediaModel;
    protected GetMediaRequestContract $request;

    /** @var Collection<int, SpatieMedia> */
    protected Collection $media;

    public function __construct(
        MediaModelRepository $repository,
        MediaModelQueryContract $mediaModelQuery,
        MediaQueryContract $mediaQuery
    ) {
        $this->repository = $repository;
        $this->mediaModelQuery = $mediaModelQuery;
        $this->mediaQuery = $mediaQuery;
    }
    
    public function handle(GetMediaRequestContract $request)
    {
        $this->setRequest($request)
            ->setMediaModel();

        if (!$this->mediaModel):
            return;
        endif;

        $this->setMedia();
    }

    protected function setRequest(GetMediaRequestContract $request): self
    {
        $this->request = $request;

        return $this;
    }

    protected function setMediaModel(): self
    {
        $this->mediaModel = $this->mediaModelQuery->matchingRequest($this->request)
            ->first();

        return $this;
    }

    protected function setMedia(): self
    {
        $query = $this->mediaQuery->whereMediaModel($this->mediaModel)
            ->whereCollection($this->request->getCollection());

        if ($this->request->isUsingFirstOnly()):
            $query->limit(1);
        endif;

        $this->media = $query->get();

        return $this;
    }

    public function getMedia(): Collection
    {
        return $this->media ??
            $this->media = collect();
    }

    public function getMediaModel(): ?MediaModel
    {
        return $this->mediaModel;
    }
}