<?php

namespace App\Enums\Notification;

enum TypeEnum : string
{
    case ALWAYS = 'always'; // 毎回表示
    case ONCE = 'once'; // 1度のみ表示
}
