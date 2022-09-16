<?php
namespace App\Contracts\Actions;

interface ActionContract
{
    public function handle(): void;
}