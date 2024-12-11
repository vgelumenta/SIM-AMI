<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('forms.{formId}', function ($user) {
    return ['id' => $user->id, 'name' => $user->name];
});
