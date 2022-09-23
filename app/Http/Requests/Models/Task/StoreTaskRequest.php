<?php

namespace App\Http\Requests\Models\Task;

use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Requests\Task\StoreTaskRequestContract;
use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Transformers\Requests\Task\StoreTaskRequestTransformerContract;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'task.model_id' => ['required', 'string'],
            'task.model_type' => ['required', 'string'],
            'task.app_key' => ['sometimes', 'nullable', 'string'],
            'task.title' => ['required', 'string'],
            'task.done_at' => ['nullable', 'date'],
            'task.is_having_due_date_time' => ['required', 'boolean'],
            'task.users.*.id' => ['required', 'integer'],
            'task.users.*.first_name' => ['required', 'string'],
            'task.users.*.last_name' => ['required', 'string'],
            'task.users.*.avatar' => ['nullable', 'string'],
            'task.users.*.email' => ['required', 'string'],
            'task.options' => ['array'],
            'task.due_date' => ['nullable', 'date']
        ];
    }

    /**
     * Getting parsed version of this request.
     * 
     * @return StoreTaskRequestContract
     */
    public function getParsed(): StoreTaskRequestContract
    {
        /** @var StoreTaskRequestTransformerContract */
        $transformer = app()->make(StoreTaskRequestTransformerContract::class);

        return $transformer->fromArray($this->validated());
    }
}
