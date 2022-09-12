<?php
namespace App\Models;

use App\Models\Abstracts\Model as AbstractModel;
use Henrotaym\LaravelTrustupMediaIoCommon\Enums\Media\MediaCollections;
use Henrotaym\LaravelTrustupMediaIoCommon\Enums\Media\MediaConversions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaModel extends AbstractModel implements HasMedia
{
    use InteractsWithMedia;

    public function getModelId(): int
    {
        return $this->model_id;
    }

    public function getModelType(): string
    {
        return $this->model_type;
    }

    public function getAppKey(): ?string
    {
        return $this->app_key;
    }

    public function registerMediaCollections(): void
    {
        foreach (MediaCollections::cases() as $collection):
            $this->addMediaCollection($collection->getName());
        endforeach;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        foreach (MediaConversions::cases() as $conversion):
            $mediaConversion = $this->addMediaConversion($conversion->getName())
                ->performOnCollections(
                    ...$conversion->getCollections()->map(
                        fn (MediaCollections $collection) => $collection->getName()
                    )
                );

                switch ($conversion):
                    case MediaConversions::HEADER:
                        $mediaConversion->width(1920)
                            ->height(1920)
                            ->sharpen(10);
                        break;
        
                    case MediaConversions::EXTRALARGE:
                        $mediaConversion->width(1280)
                            ->height(1280)
                            ->sharpen(10);
                        break;
        
                    case MediaConversions::LARGE:
                        $mediaConversion->width(1024)
                            ->height(1024)
                            ->sharpen(10);
                        break;
                    
                    case MediaConversions::MEDIUM:
                        $mediaConversion->width(700)
                            ->height(700)
                            ->sharpen(10);
                        break;
        
                    case MediaConversions::SMALL:
                        $mediaConversion->width(450)
                            ->height(450)
                            ->sharpen(10);
                        break;
        
                    case MediaConversions::EXTRASMALL:
                        $mediaConversion->width(300)
                            ->height(300)
                            ->sharpen(10);
                        break;
        
                    case MediaConversions::THUMBNAIL:
                        $mediaConversion->width(150)
                            ->height(150)
                            ->sharpen(10);
                        break;
        
        
                    case MediaConversions::BLUR:
                        $mediaConversion->width(50)
                            ->height(50)
                            ->blur(50);
                        break;
        
                    default: 
                        break;
                endswitch;
        endforeach;
    }
}