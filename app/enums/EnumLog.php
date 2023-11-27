<?php

namespace app\enums;

use Exception;

enum EnumLog:string
{
    case LoginError = 'Login Error';
    case DatabaseErrorConnection = 'Database Connection Error'; 
}
