<?php

namespace App\Http\Requests\Models\Task;

use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Requests\Task\IndexTaskRequestContract;
use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Transformers\Requests\Task\IndexTaskRequestTransformerContract;
use Henrotaym\LaravelTrustupTaskIoCommon\Enum\Requests\Task\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexTaskRequest extends FormRequest
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
            'model_id' => ['required', 'string'],
            'model_type' => ['required', 'string'],
            'app_key' => ['sometimes', 'nullable', 'string'],
            'status' => [
                'sometimes',
                Rule::in(TaskStatus::values())
            ],
        ];
    }

    /**
     * Getting parsed version of this request.
     * 
     * @return IndexTaskRequestContract
     */
    public function getParsed(): IndexTaskRequestContract
    {
        /** @var IndexTaskRequestTransformerContract */
        $transformer = app()->make(IndexTaskRequestTransformerContract::class);

        return $transformer->fromArray($this->validated());
    }
}
