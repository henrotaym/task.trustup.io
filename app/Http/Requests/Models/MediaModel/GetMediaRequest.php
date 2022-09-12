<?php

namespace App\Http\Requests\Models\MediaModel;

use Henrotaym\LaravelTrustupMediaIoCommon\Contracts\Requests\Media\GetMediaRequestContract;
use Henrotaym\LaravelTrustupMediaIoCommon\Contracts\Transformers\Requests\Media\GetMediaRequestTransformerContract;
use Illuminate\Foundation\Http\FormRequest;

class GetMediaRequest extends FormRequest
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
            'model_id' => ['required', 'integer'],
            'model_type' => ['required', 'string'],
            'app_key' => ['sometimes', 'nullable', 'string'],
            'collection' => ['sometimes', 'nullable', 'string'],
            'first_only' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * Getting parsed version of this request.
     * 
     * @return GetMediaRequestContract
     */
    public function getParsed(): GetMediaRequestContract
    {
        /** @var GetMediaRequestTransformerContract */
        $transformer = app()->make(GetMediaRequestTransformerContract::class);

        return $transformer->fromArray($this->validated());
    }
}
