document.getElementById('delete').addEventListener('click',(e)=>{
    var ck = document.getElementById('agree').checked;
    if(!(ck)){
        e.preventDefault();
    }
});
