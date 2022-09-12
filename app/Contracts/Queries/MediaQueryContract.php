<?php
namespace App\Contracts\Queries;

use App\Models\MediaModel;
use Henrotaym\LaravelModelQueries\Queries\Contracts\QueryContract;

interface MediaQueryContract extends QueryContract
{
    /** @return static */
    public function whereMediaModel(MediaModel $model): MediaQueryContract;

    /** @return static */
    public function whereCollection(?string $collection): MediaQueryContract;
}