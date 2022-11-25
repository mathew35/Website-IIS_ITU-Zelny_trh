<?php
session_start();
if (isset($_SESSION['farmer'])) {
    unset($_SESSION['farmer']);
    echo false;
} else {
    $_SESSION['farmer'] = "farmer";
    echo true;
}
