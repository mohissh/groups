<?php

namespace Mohiqssh\Groups\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Mohiqssh\Groups\Traits\GroupHelpers;

class User extends Authenticatable
{
    use GroupHelpers;
}
