<?php
namespace App\Models\Traits;

trait Persistable
{
    public function persist(array $options = [])
    {
        $this->save($options);
    }
}