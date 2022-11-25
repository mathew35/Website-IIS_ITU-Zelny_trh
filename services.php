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
    // how to use add()
    // $db = new AccountService();
    // $db->add("SPECIFIC_CROP", "(NULL,'cibula','zelenina','najsamlepsiaaaaaaaa',0,0,0,NULL)");
    function add($table, $values)
    {
        $cols = $this->pdo->prepare("SHOW COLUMNS FROM " . $table . ";");
        $cols->execute(NULL);
        $item = $cols->fetch();
        $res = "(" . $item[0];
        $item = $cols->fetch();
        for ($i = 1; $i < $cols->rowCount(); $i++) {
            $res = $res . ", " . $item[0];
            $item = $cols->fetch();
        }
        $res = $res . ")";
        $query = $this->pdo->prepare("INSERT INTO " . $table . " " . $res . " VALUES " . $values . ";");
        $query->execute(NULL);
    }
    // how to use remove()
    // $db = new AccountService();
    // $test = $db->remove("SPECIFIC_CROP", "CROPID=2");
    function remove($table, $condition)
    {
        if ($condition == NULL) $condition = 0;
        $query = $this->pdo->prepare("DELETE FROM " . $table . " WHERE " . $condition);
        $query->execute(NULL);
    }
    // how to use get()
    // $db = new AccountService();
    // $test = $db->get("SPECIFIC_CROP", "CROP_NAME", "CROPID=2");
    // $item = $test->fetch();
    // echo $item[0];
    function get($table, $what, $condition)
    {
        if ($condition == NULL) $condition = 1;
        $query = $this->pdo->prepare("SELECT " . $what . " FROM " . $table . " WHERE " . $condition . ";");
        $query->execute();
        return $query;
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
