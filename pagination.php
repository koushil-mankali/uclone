<?php
if(!isset($_SERVER['HTTP_REFERER'])){
    // redirect them to your desired location
    header('location:err404.php');
    exit;
}
require_once("database/dbconn.php");
$db = new Database();

    $db->select('courses','id',null,"crs_cat='$search'");
    $pcn = $db->getResult();
    $pcnt = count($pcn) > 0 ? count($pcn) : 0;


    $page_number = (isset($_GET['page']) AND !empty($_GET['page'])) ? $_GET['page'] : 1;
    $per_page_records = 5;
  

    echo '<div class="cat_sec7_res_bdy" id="cat_sec7_res_bdy">';
    display_content((($page_number-1)*5),$per_page_records);
    echo '</div>';
    
    function pagination(){
        global $search,$pcnt,$page_number,$per_page_records;

        $pagination_buttons = 5;
        $rows = $pcnt;
        $last_page = ceil($rows/$per_page_records);
        $pagination = "";

        
        if($page_number < 1){
            $page_number = 1;
        }else if($page_number > $last_page){
            $page_number = $last_page;
        }
        
        
        $half = floor($pagination_buttons/2);

        $pagination = "<div class='cat_sec8_f'>
                        <ul class='cat_sec8'>";

        if($page_number < $pagination_buttons AND ($last_page == $pagination_buttons OR $last_page > $pagination_buttons)){
            for($i=1; $i<$pagination_buttons; $i++){
                if($i == $page_number){
                    $pagination .= "<li class='pageNumber activep'><a href='category?cat_nm=$search&page=$i'>$i</a></li>";
                }else{
                    $pagination .= "<li class='pageNumber'><a href='category?cat_nm=$search&page=$i'>$i</a></li>";
                }
            }

            if($last_page > $pagination_buttons){
                $pagination .= '<li class="nextt"><a href="category?cat_nm='.$search .'&page='.($pagination_buttons + 1).'">Next<i class="fas fa-angle-right"></i></a></li>';
            }
        }
        else if($page_number >= $pagination_buttons AND $last_page >$pagination_buttons){
            if(($page_number + $half) >= $last_page){
                $pagination .= '<li class="prevv"><a href="category?cat_nm='.$search .'&page='.($last_page - $pagination_buttons).'"><i class="fas fa-angle-left"></i>Prev</a></li>';

                for($i = (($last_page - $pagination_buttons)+1); $i<=$last_page; $i++){
                    if($i == $page_number){
                        $pagination .= "<li class='pageNumber activep'><a href='category?cat_nm=$search&page=$i'>$i</a></li>";
                    }else{
                        $pagination .= "<li class='pageNumber'><a href='category?cat_nm=$search&page=$i'>$i</a></li>";
                    }
                }
            }
        }
        else if (($page_number + $half) < $last_page){
            $pagination .= '<li class="prevv"><a href="category?cat_nm='.$search .'&page='.(($page_number - $half)-1).'"><i class="fas fa-angle-left"></i>Prev</a></li>';
            for($i = (($page_number - $half)+1); $i<=($page_number+$half); $i++){
                if($i == $page_number){
                    $pagination .= "<li class='pageNumber activep'><a href='category?cat_nm=$search&page=$i'>$i</a></li>";
                }else{
                    $pagination .= "<li class='pageNumber'><a href='category?cat_nm=$search&page=$i'>$i</a></li>";
                }
            }
            $pagination .= '<li class="nextt"><a href="category?cat_nm='.$search .'&page='.(($page_number+$half)+1).'">Next<i class="fas fa-angle-right"></i></a></li>';
        }else{
            for($i=1; $i<=$last_page; $i++){
                if($i == $page_number){
                    $pagination .= "<li class='pageNumber activep'><a href='category?cat_nm=$search&page=$i'>$i</a></li>";
                }else{
                    $pagination .= "<li class='pageNumber'><a href='category?cat_nm=$search&page=$i'>$i</a></li>";
                }
            }
        }


        $pagination .= "</ul> </div>";
        echo $pagination;
    }

?>
