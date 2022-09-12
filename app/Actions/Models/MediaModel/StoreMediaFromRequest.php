<?php
namespace App\Actions\Models\MediaModel;

use App\Models\MediaModel;
use App\Repository\MediaModelRepository;
use App\Contracts\Queries\MediaModelQueryContract;
use App\Jobs\Models\MediaModel\StoreMedia;
use Henrotaym\LaravelTrustupMediaIoCommon\Contracts\Models\StorableMediaContract;
use Henrotaym\LaravelTrustupMediaIoCommon\Contracts\Requests\Media\StoreMediaRequestContract;

class StoreMediaFromRequest
{
    protected MediaModelRepository $repository;
    protected MediaModelQueryContract $query;
    protected StoreMediaRequestContract $request;
    protected MediaModel $mediaModel;

    public function __construct(
        MediaModelRepository $repository,
        MediaModelQueryContract $query
    ) {
        $this->repository = $repository;
        $this->query = $query;
    }
    
    public function handle(StoreMediaRequestContract $request)
    {
        if ($request->getMedia()->isEmpty()):
            return;
        endif;

        $this->setRequest($request)
            ->setMediaModel()
            ->repository
                ->setModel($this->getMediaModel())
                ->setAppKey($this->request->getAppKey())
                ->setModelType($this->request->getModelType())
                ->setModelId($this->request->getModelId())
                ->persist();
        
        // Queueing every media storage in its own job.
        if ($request->isUsingQueue()):
            return $this->request->getMedia()->each(
                fn (StorableMediaContract $storableMedia) =>
                    StoreMedia::dispatch($storableMedia, $this->repository->getModel())
            );
        endif;
        
        // Storing media synchronously.
        $this->repository->addMediaCollection($this->request->getMedia());
    }

    protected function setRequest(StoreMediaRequestContract $request): self
    {
        $this->request = $request;

        return $this;
    }

    protected function setMediaModel(): self
    {
        $this->mediaModel =  $this->query->matchingRequest($this->request)
            ->first() ??
                new MediaModel;

        return $this;
    }

    public function getMediaModel(): MediaModel
    {
        return $this->mediaModel;
    }

    public function getRepository(): MediaModelRepository
    {
        return $this->repository;
    }
}