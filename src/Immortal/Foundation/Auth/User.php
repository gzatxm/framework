<?php

namespace Immortal\Foundation\Auth;

use Immortal\Auth\Authenticatable;
use Immortal\Database\Eloquent\Model;
use Immortal\Auth\Passwords\CanResetPassword;
use Immortal\Foundation\Auth\Access\Authorizable;
use Immortal\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Immortal\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Immortal\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
}
