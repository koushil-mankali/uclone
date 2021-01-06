<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['isLogin'])){
    session_unset();
    session_destroy();
    header('location:./');
}else{
    header('location:login');
}

?>