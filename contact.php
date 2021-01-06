<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact US</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/custom.css">
</head>
<body>

<!-- Header Section Start -->
    <?php include_once('inc/header.php') ?>
<!-- Header Section End -->

<!-- Section 1 Start  -->
<div class="cnt_sec1">
    <div class="cnt_sec1_bnr">
        <img src="images/site/contact_bnr.jpg" alt="contactus banner">
    </div>
    <div class="cnt_sec1_bnr_txt">
        <div>Improving Lives Through Learning</div>
    </div>
</div>
<!-- Section 1 End -->

<!-- Section 2 Start  -->
<div class="cnt_sec2">
    <div class="cnt_sec2_abt">
        <div class="cnt_sec2_abt1">The leading global marketplace for learning and instruction</div>
        <div class="cnt_sec2_abt2">By connecting students all over the world to the best instructors, Udemy is helping individuals reach their goals and pursue their dreams.</div>
    </div>
</div>
<!-- Section 2 End -->


<!-- Section 3 Start -->
<div class="cnt_sec3">
    <form action="#" method="POST" id="cnt_form" class="cnt_form">
        <div class="cnt_name">
            <label for="cnt_name" class="cnt_lbl">Name</label>
            <input type="text" name="cnt_name" id="cnt_name" class="int_cnt">
        </div>
        <div class="cnt_email">
            <label for="cnt_email" class="cnt_lbl">Email</label>
            <input type="email" name="cnt_email" id="cnt_email" class="int_cnt">
        </div>
        <div class="cnt_msg">
            <label for="cnt_msg" class="cnt_lbl">Message</label>
            <textarea name="cnt_msg" id="cnt_msg" class="int_cnt_msg"></textarea>
        </div>
        <div class="cnt_btn">
            <input type="submit" name="cnt_name" id="cnt_name" class="cnt_snd_btn">
        </div>
    </form>
</div>
<!-- Section 3 End -->

<div class="exp">
</div>

<!-- Footer Section Start -->
<?php include_once('inc/footer.php') ?>
<!-- Footer Section End -->
    <script src="javascript/jquery.js"></script>
    <script src="javascript/all.js"></script>
    <script src="javascript/frontend.js"></script>
</body>
</html>