<?php
namespace App\Repository\Abstracts;

use App\Contracts\Repository\Private\RepositoryContract;
use App\Models\Abstracts\Model;

/**
 * Abstract repository to extends from.
 * 
 * @template TModel of \App\Models\Abstracts\Model
 */
abstract class Repository implements RepositoryContract
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
    public function setModel(Model $model): RepositoryContract
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
    public function persist(): RepositoryContract
    {
        $this->getModel()?->save();

        return $this;
    }

    /**
     * Deleting model.
     * 
     * @return static
     */
    public function delete(): RepositoryContract
    {
        $this->getModel()->delete();

        return $this;
    }
}
