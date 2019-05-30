<?php

namespace App\Security;

interface iHasRole
{
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_USER = 'ROLE_USER';

    public const USER_ROLE_VALUE_ADMIN = 'ROLE_ADMIN';
    public const USER_ROLE_TOKEN_ADMIN = 'USER_ROLE_TOKEN_ADMIN';
    public const USER_ROLE_VALUE_USER = 'ROLE_USER';
    public const USER_ROLE_TOKEN_USER = 'USER_ROLE_TOKEN_USER';

}