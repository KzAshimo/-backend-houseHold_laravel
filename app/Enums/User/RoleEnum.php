<?php

namespace App\Enums\User;

enum RoleEnum: string
{
    case USER = 'user'; // 一般ユーザ
    case ADMIN = 'admin'; // 管理者
}
