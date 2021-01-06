<?php
require_once("database/dbconn.php");

$db = new Database();
?>
<hr class="fhr">

<footer>
    <div class="footer_sec">
        <div class="first box">
            <h2>More Links</h2>
            <hr class="hr" />
            <ul class="content">
                <li><a href="singup_instructor">Teach On MK Elearn</a></li>
                <li><a href="">Get the App</a></li>
                <li><a href="about">About Us</a></li>
                <li><a href="contact">Contact Us</a></li>
                <li><a href="instructor/login">Instructor Login</a></li>
            </ul>
            <div class="social_media_icons">
                <span class="s_icon"><i class="fab fa-facebook s_icons"></i></span>
                <span class="s_icon"><i class="fab fa-twitter s_icons"></i></span>
                <span class="s_icon"><i class="fab fa-instagram s_icons"></i></span>
                <span class="s_icon"><i class="fab fa-youtube s_icons"></i></span>
            </div>
        </div>
        <div class="second box">
            <h2>Categories</h2>
            <hr class="hr" />
            <ul class="content">
            <?php
                if($db->select('category','cat_name',null,null,null,['0'=>8])){
                    $em2 = $db->getResult();
                    $cnt2 = count($em2) > 0 ? count($em2) : false;
                    if($cnt2 >0){
                        $i=0;
                        while($i<$cnt2){
                            $cat_nm = $em2[$i]['cat_name'] ? $em2[$i]['cat_name'] : "No Data";
                            echo"<li><a href='category?cat_nm=$cat_nm'>$cat_nm</a></li>";
                        $i++;
                        }
                    }else{
                        $err = "Error Fetching Data!";
                    }
                }else{
                    $err = "Error Fetching Data!";
                }
                ?>
            </ul>
        </div>
        <div class="third box">
            <h2>Contact Us</h2>
            <hr class="hr" />
            <div class="content">
                <form action="" method="POST">
                    <div class="email_box">
                        <label for="email" class='labels'>EMail *</label>
                        <input type="email" name="email" id="email" required autocomplete="off">
                    </div>
                    <div class="message_box">
                        <label for="message" class='labels'>Message *</label>
                        <textarea type="textarea" name="message" id="message" row='4' cols='25' required></textarea>
                    </div>
                    <div class="s_button">
                        <input type="submit" id="s_btn" value="Send">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="copy_r">
        <span>Developed by | <span class="copy_rn"><a href="https://www.linkedin.com/in/koushil-mankali">Koushil Mankali</a></span> @ 2020</span>
    </div>
</footer>
