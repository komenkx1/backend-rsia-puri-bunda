<?php

namespace App\Traits;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;


trait LoggableTrait
{
    protected function logModelOperation($action, $description)
    {
        Log::create([
            'action' => $action,
            'user_id' => Auth::user()->id,
            'description' => $description,
        ]);
    }

    public static function bootLoggableTrait()
    {
        foreach (['CREATED', 'UPDATED', 'DELETED'] as $event) {
            self::{$event}(function ($model) use ($event) {
                $action = ucfirst($event);
                $description = "{$action} Data " . class_basename($model);
                $model->logModelOperation($action, $description);
            });
        }
    }
}
