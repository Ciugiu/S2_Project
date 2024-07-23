<?php
require_once 'ManageData.php';

class User
{
    public static function login(string $login, string $password): ?int
    {
        $query = "SELECT * FROM users WHERE login=?";
        $dataManager = new ManageData();
        $aUser = $dataManager->getData($query, true, [$login]);
        if (empty($aUser) || $password !== $aUser['password']) {
            return null;
        } else {
            session_start();
            $_SESSION['user_id'] = $aUser['id'];
            $_SESSION['user_login'] = $aUser['login'];
            return $aUser['id'];
        }
    }

    public static function getUser(): array | bool
    {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }
        $query = "SELECT * FROM users WHERE id = ?";
        $dataManager = new ManageData();
        $user = $dataManager->getData($query, true, [$_SESSION['user_id']]);
        return $user;
    }

    public static function checkLoggedInUser(): bool
    {
        return isset($_SESSION['user_id']) ? true : false;
    }

    public static function logout()
    {
        session_start();
        unset($_SESSION['user_id']);
    }

    public static function getDrugs(): array
    {
        $query = "SELECT * FROM offer";
        $dataManager = new ManageData();
        $drugs = $dataManager->getData($query);
        return $drugs;
    }

    public static function changePassword($userId, $newPassword) {
        $query = "UPDATE users SET password = ? WHERE id = ?";
        $dataManager = new ManageData();
        $result = $dataManager->executeQuery($query, [$newPassword, $userId]);
        return $result !== false;
    }

    public static function checkPassword($userId, $password): bool
    {
        $query = "SELECT password FROM users WHERE id = ?";
        $dataManager = new ManageData();
        $result = $dataManager->getData($query, true, [$userId]);

        if ($result) {
            return $password === $result['password'];
        }

        return false;
    }
}
