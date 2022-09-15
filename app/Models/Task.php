<?php
namespace App\Models;

use App\Models\Abstracts\Model as AbstractModel;
use Carbon\Carbon;
use Henrotaym\LaravelTrustupTaskIoCommon\Models\Traits\HasOptions;
use Illuminate\Support\Collection;

class Task extends AbstractModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'model_id',
        'model_type',
        'app_key',
        'title',
        'done_at',
        'due_date',
        'having_due_date_time',
        'user_ids'
    ];

    protected $dates = [
        'done_at',
        'due_date'
    ];

    protected $casts = [
        'having_due_date_time' => 'boolean',
        'user_ids' => 'array'
    ];

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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function isDone(): bool
    {
        return !!$this->done_at;
    }

    /** @return static */
    public function getDoneAt(): ?Carbon
    {
        return $this->done_at;
    }

    public function getDueDate(): ?Carbon
    {
        return $this->due_date;
    }

    public function isHavingDueDateTime(): bool
    {
        return $this->having_due_date_time;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getUsers(): Collection
    {
        /** @TODO Send request to auth.trustup.io to get users details */
        return collect($this->user_ids);
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('uuid', $value)->firstOrFail();
    }
}