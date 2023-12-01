<?php

namespace app\services;

use Exception;
use app\dto\AuthDto;
use app\database\models\User;

class AuthService
{
    public function authenticate()
    {
        $email = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']);

        $user = User::where('email', $email);

        if (!$user) {
            throw new Exception("Usuário ou senha inválidos");
        }
        // var_dump(password_hash('123', PASSWORD_DEFAULT));
        if (!password_verify($password, $user->password)) {
            throw new Exception("Usuário ou senha inválidos");
        }

        $this->loginAs($user);
    }

    private function loginAs(User $user)
    {
        if (!isset($_SESSION['auth'])) {
            $authDto = new AuthDto(
                $user->id,
                $user->firstName,
                $user->lastName,
            );

            $_SESSION['auth'] = $authDto;
        }
    }

    public static function isAuth()
    {
        return isset($_SESSION['auth']);
    }

    public static function auth()
    {
        return $_SESSION['auth'] ?? null;
    }

    public function logout()
    {
        if (isset($_SESSION['auth'])) {
            unset($_SESSION['auth']);
        }
    }
}
