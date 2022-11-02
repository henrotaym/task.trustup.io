<?php
namespace App\Models;

use App\Collections\Models\TaskCollection;
use App\Contracts\Api\Auth\Endpoints\UserEndpointContract;
use App\Models\Abstracts\Model as AbstractModel;
use Carbon\Carbon;
use Deegitalbe\LaravelTrustupModelBroadcast\Contracts\Models\TrustupBroadcastModelContract;
use Deegitalbe\LaravelTrustupModelBroadcast\Traits\Models\IsTrustupBroadcastModel;
use Henrotaym\LaravelTrustupMessagingIo\Contracts\Models\MessagingIoModelContract;
use Henrotaym\LaravelTrustupMessagingIo\Models\Traits\IsMessagingIoModel;
use Illuminate\Support\Collection;

class Task extends AbstractModel implements MessagingIoModelContract, TrustupBroadcastModelContract
{
    use
        IsMessagingIoModel,
        IsTrustupBroadcastModel
    ;

    protected ?Collection $authUsers = null;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'model_id',
        'model_type',
        'app_key',
        'professional_authorization_key',
        'account_uuid',
        'title',
        'done_at',
        'due_date',
        'having_due_date_time',
        'user_ids',
        'options'
    ];

    protected $dates = [
        'done_at',
        'due_date'
    ];

    protected $casts = [
        'having_due_date_time' => 'boolean',
        'user_ids' => 'array',
        'options' => 'array'
    ];

    public function getModelId(): string
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

    public function getProfessionalAuthorizationKey(): ?string
    {
        return $this->professional_authorization_key;
    }

    public function getAccountUuid(): ?string
    {
        return $this->account_uuid;
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
        return $this->options ?? [];
    }

    public function getUserIds(): array
    {
        return $this->user_ids;
    }

    public function getUsers(): Collection
    {
        if ($this->authUsers):
            return $this->authUsers;
        endif;

        /** @var UserEndpointContract */
        $api = app()->make(UserEndpointContract::class);

        return $this->authUsers = $api->getUserByIds($this->getUserIds());
    }

    public function setAuthUsers(Collection $authUsers): self
    {
        $this->authUsers = $authUsers;

        return $this;
    }

    /**
     * Getting attributes sent along when broadcasing events.
     
     * @param string $eventName Laravel model event that should be broadcasted (created, updated, deleted, ...)
     * @return array<string, mixed>
     */
    public function getTrustupModelBroadcastEventAttributes(string $eventName): array
    {
        return [
            'uuid' => $this->getUuid(),
            'title' => $this->getTitle()
        ];
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

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new TaskCollection($models);
    }
}