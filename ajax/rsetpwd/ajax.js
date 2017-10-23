function load1(str,correo){
var xmlhttp;

if (window.XMLHttpRequest){
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
}else{
    // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}

  xmlhttp.onreadystatechange=function(){
    if (xmlhttp.readyState==4 && xmlhttp.status==200){
      document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    }
  }

    xmlhttp.open("POST","ajax/rsetpwd/comprobando.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("usuario="+str+"&correo="+correo);
}

function loado(str,correo)
{
var xmlhttp;

if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
}else{
    // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange=function(){
    if (xmlhttp.readyState==4 && xmlhttp.status==200){
        document.getElementById("myDiv6").innerHTML=xmlhttp.responseText;
    }
  }

    xmlhttp.open("POST","comprobando_docente.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("usuario="+str+"&correo="+correo);

}


function load(str)
{
var xmlhttp;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
    xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    }
  }

    xmlhttp.open("POST","proceso.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("q="+str);


}
function loadp(str,id)
{
var xmlhttp;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
    xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    }
  }

    xmlhttp.open("POST","proceso.php", true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("q="+str+"&id="+id);


}


function load2(str)
{
var xmlhttp;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
    xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      document.getElementById("myDiv2").innerHTML=xmlhttp.responseText;
    }
  }

    xmlhttp.open("POST","proceso2.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("q2="+str);
}

function load2p(str,id)
{
var xmlhttp;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
    xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      document.getElementById("myDiv2").innerHTML=xmlhttp.responseText;
    }
  }

    xmlhttp.open("POST","proceso2.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
      xmlhttp.send("q2="+str+"&id2="+id);
}

//para mostrar contenido (escribir comprobante)
function showContent() {
        element = document.getElementById("content");
        check = document.getElementById("check");
        if (check.checked) {
            element.style.display='block';
        }
        else {
            element.style.display='none';
        }
}
