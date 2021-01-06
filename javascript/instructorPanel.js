// Sidebar JS Start 

document.getElementById('opt1').addEventListener('click',()=>{
    location.href="index";
});
document.getElementById('opt2').addEventListener('click',()=>{
    location.href="create_courses";
});
document.getElementById('opt3').addEventListener('click',()=>{
    location.href="courses";
});
document.getElementById('opt4').addEventListener('click',()=>{
    location.href="students";
});
document.getElementById('opt5').addEventListener('click',()=>{
    location.href="payments";
});
document.getElementById('opt6').addEventListener('click',()=>{
    location.href="account_settings";
});
document.getElementById('opt7').addEventListener('click',()=>{
    location.href="close_acc";
});

// Sidebar JS End

document.getElementById('delete').addEventListener('click',(e)=>{
    var ck = document.getElementById('agree').checked;
    if(!(ck)){
        e.preventDefault();
    }
});


