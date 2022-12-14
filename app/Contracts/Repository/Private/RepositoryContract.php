<?php
namespace App\Contracts\Repository\Private;

use App\Models\Abstracts\Model;
use Henrotaym\LaravelContainerAutoRegister\Services\AutoRegister\Contracts\AutoRegistrableContract;

/**
 * @template TModel of \App\Models\Abstracts\Model
 */
interface RepositoryContract extends AutoRegistrableContract
{
    /**
     * Setting related model.
     * 
     * @param TModel $model
     * @return static
     */
    public function setModel(Model $model): RepositoryContract;

    /**
     * Getting related model.
     * 
     * @return TModel
     */
    public function getModel(): ?Model;

    /**
     * Persisting model.
     * 
     * @return static
     */
    public function persist(): RepositoryContract;

    /**
     * Deleting model.
     * 
     * @return static
     */
    public function delete(): RepositoryContract;
}