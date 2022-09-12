<?php
namespace App\Repository\Abstracts;

use App\Models\Abstracts\Model;

/**
 * Abstract repository to extends from.
 * 
 * @template TModel of \App\Models\Abstracts\Model
 */
abstract class Repository
{
    /**
     * Related model.
     * 
     * @var TModel|null
     */
    protected $model;

    /**
     * Setting related model.
     * 
     * @param TModel $model
     * @return static
     */
    public function setModel(Model $model): Repository
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Getting related model.
     * 
     * @return TModel
     */
    public function getModel(): ?Model
    {
        return $this->model;
    }

    /**
     * Persisting model.
     * 
     * @return static
     */
    public function persist(): Repository
    {
        $this->getModel()?->save();

        return $this;
    }
}
