<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!(isset($_SESSION['isLogin']) && isset($_SESSION['iemail']))){
    header('location:login');
}
?>
<header>
    <div class="inst_header">
        <a href="./" class="web_ttl">MK ELearning</a>
        <a href="logout" class="inst_logout">Logout</a>
        <span id="bars"><i class="fas fa-bars inst_bars"></i></span>        
    </div>
</header>

<script>
document.getElementById('bars').addEventListener('click',()=>{
    document.getElementById('sidebar').classList.toggle('mobsid');
});
</script>