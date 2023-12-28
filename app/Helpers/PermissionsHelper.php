<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Gate;

function can(string $permission, $element = null): bool
{
    return Gate::allows($permission) ? ($element ?? true) : false;
}
