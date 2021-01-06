// Course JS 

document.getElementById("share_btn").addEventListener('click',()=>{
    var url = document.getElementById("cshare");
    url.classList.remove('hide');
    url.classList.add('show');
    url.value = window.location.href;
    url.focus();
    url.select();  
    document.execCommand("Copy");  
    url.classList.remove('show');
    url.classList.add('hide');
    alert("Link Copied!");
});


document.getElementById('search').addEventListener('keyup',()=>{
    val = document.getElementById('search').value;
    // srh_val = document.getElementById('search_li_v');
    const xhr =new XMLHttpRequest();
    xhr.open('POST',"search",true);
    // xhr.setRequestHeader('Content-Type','application/json');
    xhr.responseType = "json";
    xhr.onload = () =>{
        if(xhr.status === 200){
            console.log(xhr.response);
            if(xhr.response){
                x = xhr.response;
            }else{
                x = "";
            }
            for(let i=0;i<x.length;i++){
                document.getElementById('search_li_v').innerHTML += "<a href='course?crs_id=" +x[i].crs_token + "' class='search_a'><li class='search_li'>" + x[i].crs_nm + "</li></a>";
            }
        }else{
            $err = "Error Fetxhing Data";
        }
    };
    document.getElementById('search_li_v').innerHTML ="";
    const mydata = {search : val};
    const data = JSON.stringify(mydata);
    console.log(data)
    xhr.send(data);
});


// Search2 


// Slider Code 


var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  slides[slideIndex-1].style.display = "block";  
}
