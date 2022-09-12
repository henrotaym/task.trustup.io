<?php

namespace App\Http\Requests\Models\MediaModel;

use Henrotaym\LaravelTrustupMediaIoCommon\Contracts\Requests\Media\StoreMediaRequestContract;
use Henrotaym\LaravelTrustupMediaIoCommon\Contracts\Transformers\Requests\Media\StoreMediaRequestTransformerContract;
use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'model_type' => ['required', 'string'],
            'model_id' => ['required', 'integer'],
            'app_key' => ['sometimes', 'nullable', 'string'],
            'collection' => ['sometimes', 'nullable', 'string'],
            'use_queue' => ['sometimes', 'boolean'],
            'files.*.resource' => ['required'],
            'files.*.collection' => ['sometimes', 'nullable', 'string'],
            'files.*.name' => ['sometimes', 'nullable', 'string'],
            'files.*.custom_properties' => ['sometimes', 'array'],
        ];
    }

    /**
     * Getting parsed version of this request.
     * 
     * @return StoreMediaRequestContract
     */
    public function getParsed(): StoreMediaRequestContract
    {
        /** @var StoreMediaRequestTransformerContract */
        $transformer = app()->make(StoreMediaRequestTransformerContract::class);

        return $transformer->fromArray($this->validated());
    }
}
