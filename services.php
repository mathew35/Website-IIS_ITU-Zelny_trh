<?php

class AccountService
{
    private $pdo;
    private $lastError;

    function __construct()
    {
        $this->pdo = $this->connect_db();
        $this->lastError = NULL;
    }

    function connect_db()
    {
        $dsn = 'mysql:host=localhost;dbname=zelnytrh';
        $username = 'root';
        $password = 'passwd';
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        $pdo = new PDO($dsn, $username, $password, $options);
        return $pdo;
    }

    function getErrorMessage()
    {
        if ($this->lastError === NULL)
            return '';
        else
            return $this->lastError[2]; //the message
    }

    function addAccount($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO ACCOUNTS (login, password) VALUES (?, ?)');
        $login = $data['login'];
        $pwd = password_hash($data['password'], PASSWORD_DEFAULT);
        if ($stmt->execute([$login, $pwd])) {
            $newid = $this->pdo->lastInsertId();
            $data['id'] = $newid;
            return $data;
        } else {
            $this->lastError = $stmt->errorInfo();
            return FALSE;
        }
    }

    function getAccount($login)
    {
        $stmt = $this->pdo->prepare('SELECT id, login, password FROM ACCOUNTS WHERE login = ?');
        $stmt->execute([$login]);
        return $stmt->fetch();
    }

    function isValidAccount($login, $password)
    {
        $data = $this->getAccount($login);
        return password_verify($password, $data['password']);
    }
    function getCrops($which)
    {
        if ($which == NULL || $which == 'none') {
            $where = '';
        } else {
            $where = "WHERE CATEGORY='" . $which . "'";
        }
        $stmt = $this->pdo->prepare('SELECT * FROM SPECIFIC_CROP ' . $where . ';');
        $stmt->execute(NULL);
        return $stmt;
    }
}
function require_user()
{
    if (!isset($_SESSION['user'])) {
        echo "<h1>Access forbidden</h1>";
        exit();
    }
}
function redirect($dest)
{
    $script = $_SERVER["PHP_SELF"];
    if (strpos($dest, '/') === 0) {
        $path = $dest;
    } else {
        $path = substr($script, 0, strrpos($script, '/')) . "/$dest";
    }
    $name = $_SERVER["SERVER_NAME"];
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: http://$name$path");
}
