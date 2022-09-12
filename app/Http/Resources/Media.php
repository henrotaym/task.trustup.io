<?php

namespace App\Http\Resources;

use App\Models\MediaModel;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;

class Media extends JsonResource
{
    /** @var SpatieMedia */
    public $resource;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var MediaModel */
        $model = $this->resource->model;

        return [
            'app_key' => $model->getAppKey(),
            'collection' => $this->resource->collection_name,
            'conversions' => $this->getFormatedConversions(),
            'custom_properties' => $this->resource->custom_properties,
            'id' => $this->resource->id,
            'model_id' => $model->getModelId(),
            'model_type' => $model->getModelType(),
            'uuid' => $this->resource->uuid,
            'url' => $this->resource->getFullUrl(),
        ];
    }

    protected function getFormatedConversions(): Collection
    {
        return $this->resource->getGeneratedConversions()
            ->reduce(
                fn (
                    Collection $conversions,
                    bool $isGenerated,
                    string $conversionName
                ) => $isGenerated ?
                    $conversions->push([
                        'name' => $conversionName,
                        'url' => $this->resource->getFullUrl($conversionName)
                    ])
                    : $conversions
                ,
                collect()
        );
    }
}
