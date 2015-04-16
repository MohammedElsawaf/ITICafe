
 var order = document.getElementById('order');
var increase = document.getElementsByClassName('incre');
var decrease = document.getElementsByClassName('decre');
var del = document.getElementsByClassName('del');
var leftdiv = document.getElementById('lfdiv');
$(document).ready(function () {
   

    if (window.XMLHttpRequest) {
        var ajaxRequest = new XMLHttpRequest();
        console.log("XMLHttpRequest");
    } else {
        var ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
        console.log("ActiveXObject");
    }

    ajaxRequest.open("GET", "http://localhost/sawafcafe/public/Makeorder/made", true);
    ajaxRequest.send();
    ajaxRequest.onreadystatechange = function () {
        console.log(ajaxRequest.readyState);
        console.log(ajaxRequest.status);
        if (ajaxRequest.readyState === 4 && ajaxRequest.status === 200) {
            lfdiv.innerHTML = "";
            lfdiv.innerHTML = ajaxRequest.responseText;

        }
    };


//window.onload = myorder;
var myorder = $("#avprod").on("click", ".action", function () {
    //function (){
    
    var attribute = this.getAttribute("prodid");
 //alert("id product = " + attribute);
   
    if (window.XMLHttpRequest) {
       //alert(' vvvvvvvvvvv');
        var ajaxRequest = new XMLHttpRequest();
        console.log("XMLHttpRequest");
    } else {
        var ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
        console.log("ActiveXObject");
    }
    ajaxRequest.open("GET", "http://localhost/sawafcafe/public/Makeorder/made?product_id=" + attribute, true);
    ajaxRequest.send();
    ajaxRequest.onreadystatechange = function () {
        
         
        console.log(ajaxRequest.readyState);
        console.log(ajaxRequest.status);
         if (ajaxRequest.readyState === 4 && ajaxRequest.status === 200) {
            leftdiv.innerHTML = "";
                alert(ajaxRequest.responseText)
            leftdiv.innerHTML = ajaxRequest.responseText;

        }
    };
});
console.log(myorder);
$("#lfdiv").on("click", ".incre", function () {
    var attribute = this.getAttribute("prodid");
  
    if (window.XMLHttpRequest) {
        var ajaxRequest = new XMLHttpRequest();
        console.log("XMLHttpRequest");
    } else {
        var ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
        console.log("ActiveXObject");
    }
    ajaxRequest.open("GET", "http://localhost/sawafcafe/public/Makeorder/update?incid=" + attribute, true);
    ajaxRequest.send();
    ajaxRequest.onreadystatechange = function () {
        if (ajaxRequest.readyState === 4 && ajaxRequest.status === 200) {
//               alert(ajaxRequest.responseText);

            leftdiv.innerHTML = "";
            leftdiv.innerHTML = ajaxRequest.responseText;
            //location.reload();
        }
    }
});
$("#lfdiv").on("click", ".decre", function () {
    var attribute = this.getAttribute("prodid");

   // alert(attribute);
    if (window.XMLHttpRequest) {
        var ajaxRequest = new XMLHttpRequest();
        console.log("XMLHttpRequest");
    } else {
        var ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
        console.log("ActiveXObject");
    }
             //alert("jjjj"+attribute); 

    ajaxRequest.open("GET", "http://localhost/sawafcafe/public/Makeorder/update?decid=" + attribute, true);
    ajaxRequest.send();
    ajaxRequest.onreadystatechange = function () {
        if (ajaxRequest.readyState === 4 && ajaxRequest.status === 200) {
//               alert(ajaxRequest.responseText);
            lfdiv.innerHTML = "";
            lfdiv.innerHTML = ajaxRequest.responseText;
//                location.reload();
            //console.log(ajaxRequest.responseText);
        }
    }
});
$("#lfdiv").on("click", ".del", function () {
    var attribute = this.getAttribute("prodid");

//    alert(attribute);
    if (window.XMLHttpRequest) {
        var ajaxRequest = new XMLHttpRequest();
        console.log("XMLHttpRequest");
    } else {
        var ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
        console.log("ActiveXObject");
    }
    ajaxRequest.open("GET", "http://localhost/sawafcafe/public/Makeorder/update?delid=" + attribute, true);
    ajaxRequest.send();
    ajaxRequest.onreadystatechange = function () {
        if (ajaxRequest.readyState === 4 && ajaxRequest.status === 200) {
//     alert(ajaxRequest.responseText);
            lfdiv.innerHTML = "";
            lfdiv.innerHTML = ajaxRequest.responseText;
//                location.reload();
        }
    }
});
});
