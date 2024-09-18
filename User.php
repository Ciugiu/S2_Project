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
}