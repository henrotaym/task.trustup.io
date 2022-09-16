<?php
namespace App\Actions\Models\Task;

use App\Actions\Models\Task\Private\FromTaskRequest;
use App\Models\Task;

class StoreFromRequest extends FromTaskRequest
{
    public function handle(): void
    {
        $this->setModel(new Task());
        parent::handle();
    }
}