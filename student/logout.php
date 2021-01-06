<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['isLogin']) && isset($_SESSION['uemail'])){
    session_unset();
    session_destroy();
    header('location:../login');
}else{
    header('location:../login');
}

?>