<?php

namespace App\Jobs\Models\MediaModel;

use App\Models\MediaModel;
use App\Repository\MediaModelRepository;
use Henrotaym\LaravelTrustupMediaIoCommon\Contracts\Models\StorableMediaContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Linking and storing given media to given media model.
 */
class StoreMedia implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var StorableMediaContract */
    public $media;

    /** @var MediaModel */
    public $mediaModel;

    /**
     * Create a new job instance.
     *
     * @param StorableMediaContract $media Media to store.
     * @return void
     */
    public function __construct(StorableMediaContract $media, MediaModel $mediaModel)
    {
        $this->serializeStorableMedia($media);
        $this->media = $media;
        $this->mediaModel = $mediaModel;
    }

    /**
     * From laravel documentation :
     * 
     * Binary data, such as raw image contents, should be passed through the base64_encode function before being passed to a queued job. Otherwise, the job may not properly serialize to JSON when being placed on the queue.
     * 
     * @see https://laravel.com/docs/9.x/queues#handle-method-dependency-injection
     */
    protected function serializeStorableMedia(StorableMediaContract &$media)
    {
        if ($media->isFile()):
            $media->setAsString()
                ->setName($media->getResource()->getClientOriginalName())
                ->setResource($media->getResource()->get());
                
            return $this->serializeStorableMedia($media);
        endif;

        if (!$media->isString()):
            return;
        endif;

        $media->setResource(base64_encode($media->getResource()));
    }

    /**
     * From laravel documentation :
     * 
     * Binary data, such as raw image contents, should be passed through the base64_encode function before being passed to a queued job. Otherwise, the job may not properly serialize to JSON when being placed on the queue.
     * 
     * @see https://laravel.com/docs/9.x/queues#handle-method-dependency-injection
     */
    protected function deserializeStorableMedia(StorableMediaContract &$media)
    {
        if (!$media->isString()):
            return;
        endif;

        $media->setResource(base64_decode($media->getResource()));
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(MediaModelRepository $repository)
    {
        $this->deserializeStorableMedia($this->media);
        
        $repository->setModel($this->mediaModel)
            ->addMedia($this->media);
    }
}
