<?php

namespace App\Http\Requests\Models\Task;

use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Requests\Task\UpdateTaskRequestContract;
use Henrotaym\LaravelTrustupTaskIoCommon\Contracts\Transformers\Requests\Task\UpdateTaskRequestTransformerContract;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            'task.uuid' => ['required', 'string', 'exists:' . Task::class, ',uuid'],
            'task.model_id' => ['required', 'integer'],
            'task.model_type' => ['required', 'string'],
            'task.app_key' => ['sometimes', 'nullable', 'string'],
            'task.title' => ['required', 'string'],
            'task.done_at' => ['nullable', 'datetime'],
            'task.is_having_due_date_time' => ['required', 'boolean'],
            'task.users.*.id' => ['required', 'integer'],
            'task.options' => ['array'],
            'task.due_date' => ['nullable', 'datetime']
        ];
    }

    /**
     * Getting parsed version of this request.
     * 
     * @return UpdateTaskRequestContract
     */
    public function getParsed(): UpdateTaskRequestContract
    {
        /** @var UpdateTaskRequestTransformerContract */
        $transformer = app()->make(UpdateTaskRequestTransformerContract::class);

        return $transformer->fromArray($this->validated());
    }
}
