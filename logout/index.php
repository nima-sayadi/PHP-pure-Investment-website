<?php session_start();
if(!isset($_SESSION['user_mail']) && !isset($_SESSION['manager_mail'])){
    header("Location: ../");
    exit();
}
else{
    unset($_SESSION['user_mail']);
    unset($_SESSION['manager_mail']);
    unset($_SESSION['priv']);
    unset($_SESSION['start_time']);
    session_destroy();
    session_start();
    $_SESSION['start_time'] = time();
    header("Location: ../");
    exit();
}