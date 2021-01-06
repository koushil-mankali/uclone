<?php

if(!$_SESSION['isLogin'] || $_SESSION['isLogin'] == "false"){
    echo "<script>location.href='login.php'</script>";
}else{
    $uemail = $_SESSION['uemail'];
    $db->select('user_data','uname',null,"uemail = '$uemail'");
    $unamea = $db->getResult();
    if(count($unamea) != 0){
        $name = $unamea['0']['uname'];
        if(isset($_POST['star']) && isset($_POST['comment'])){
            $star = $_POST['star'];
            $cmmt = $_POST['comment'];
            if($db->insert('review',['name'=>$name,'ratings'=>$star,'comment'=>$cmmt,'stu_email'=>$uemail,'crs_token'=>$crs_token])){
                echo "<script>location.href='course.php'</script>";
            }

        }
    }else{
        echo "<script>location.href='login.php'</script>";
    }
   
}     
?>