<?php
namespace App\Models\Traits;

use Illuminate\Support\Str;

/**
 * @property string $uuid
 * @property array[] $fillable
 * @method bool save(array $options = [])
 */

/**
 * Handling automatically uuid attribute value.
 */
trait HasUuid
{
    /**
     * Initializing trait.
     * 
     * @return void
     */
    public function initializeHasUuid()
    {
        $this->addUuidToFillable();
        $this->ensureUuidAttribute();
    }

    /**
     * Adding uuid attribute to fillable.
     * 
     * @return void
     */
    protected function addUuidToFillable(): void
    {
        $this->fillable[] = 'uuid';
    }

    /**
     * Ensure model has uuid attribute.
     * 
     * @return void
     */
    protected function ensureUuidAttribute(): void
    {
        if ($this->uuid):
            return;
        endif;

        $this->uuid = Str::uuid();
    }

    /**
     * Getting related uuid.
     * 
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }
}