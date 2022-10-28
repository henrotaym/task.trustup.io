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
        $hasAccountUuid = !!$this->input('account_uuid');
        $hasProfessionalAuthorizationKey = !!$this->input('professional_authorization_key');

        $isStandardRequest = !$hasProfessionalAuthorizationKey && !$hasAccountUuid;

        return [
            'model_id' => [
                Rule::requiredIf(fn () => $isStandardRequest),
                'string'
            ],
            'model_type' => [
                Rule::requiredIf(fn () => $isStandardRequest),
                'string'
            ],
            'professional_authorization_key' => [
                Rule::requiredIf(fn () => !$isStandardRequest && !$hasAccountUuid),
                'string'
            ],
            'account_uuid' => [
                Rule::requiredIf(fn () => !$isStandardRequest && !$hasProfessionalAuthorizationKey),
                'string'
            ],
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
