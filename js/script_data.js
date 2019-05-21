// var form = document.getElementById("form1")
// var heihei = document.getElementById("heihei")

function submitFormData(){
    var type = form.type.value;
    var content = form.content.value;
    var search = form.search.value;
    var sexe = form.sexe.value;
    var prix_min = form.prix_min.value;
    var prix_max = form.prix_max.value;

    //console.log(type);
    //console.log(content);
    //console.log(search);
    //console.log(sexe);
    //console.log(prix_min);
    //console.log(prix_max);
    // heihei.innerText=type+content+search+sexe+prix_min+prix_max;

    //alert("submitted")
}

form.addEventListener("submit", function (event) {    
    event.preventDefault();   // 取消按键的原始提交行为
    submitFormData();         //启动监听提交按钮
});