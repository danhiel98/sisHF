
<script type="text/javascript">

function validarnombre(){
  var nombre=document.addsucursal.txtNombre;
  if (nombre.values ==="") {
    alert("el campo esta vacio");
    nombre=document.addsucursal.txtNombre.focus();
        return false;

  }

}
var patron = new Array(4,4)
function fnc(elem,separador,pat,numerico) {
if(elem.valoranterior != elem.value) {
valor = elem.value;
largo = valor.length;
valor = valor.split(separador);
valor2 = "";

for(i=0; i<valor.length; i++) {
valor2 += valor[i];
}

if(numerico){
for(j=0; j<valor2.length; j++){
if(isNaN(valor2.charAt(j))){
letra = new RegExp(valor2.charAt(j),"g");
valor2 = valor2.replace(letra,"");
}
}
}

valor = "";
valor3 = new Array();
for(n=0; n<pat.length; n++) {
valor3[n] = valor2.substring(0,pat[n]);
valor2 = valor2.substr(pat[n]);
}

for(q=0; q<valor3.length; q++) {
if(q == 0) {
valor = valor3[q];
}else{
if(valor3[q] != "") {
if (valor3[1] > 10000 ) {
valor = valor3[0];
} else if (valor3[2] > 31) {
valor = valor3[0] + separador + valor3[1];
}else{
valor += separador + valor3[q];
}

}
}
}

elem.value = valor;
elem.valoranterior = valor;
}
}




 function vNom(e,solicitar){
     // Admitir solo letras
     tecla = (document.all) ? e.keyCode : e.which;
     if (tecla==8) return true;
     patron =/[\D\s]/;
     te = String.fromCharCode(tecla);
     if (!patron.test(te)) return false;
    // No admitir espacios iniciales
     txt = solicitar.value;
     if(txt.length==0 && te==' '){
     alert('No se permiten espacios iniciales.');
     return false;
     }
    // Convertir 1° letra a mayuscula
     if (txt.length==0 || txt.substr(txt.length-1,1)==' ') {
     solicitar.value = txt+te.toUpperCase();
                 return false;
                 }
     return true;
           }
</script>
<div class="row">
	<div class="col-md-12">
	<h1>Registrar Banco</h1>
	<br>
		<form class="form-horizontal" method="post" id="addBanco" action="index.php?view=addbanco" role="form">

  <div class="form-group">
    <label for="txtNombre" class="col-lg-2 control-label">Nombre</label>
    <div class="col-md-6">
      <input type="text" name="txtNombre" class="form-control" id="txtNombre" placeholder="Nombre Del Banco" onkeypress="return vNom(event,this)" data-validation-regex-regex="[A-Za-zÁ-Úá-ú ]{3,}" data-validation-regex-message="Introduzca un NOMBRE válido">
      <p class="help-block"></p>
    </div>
  </div>
  <div class="form-group">
    <label for="txtDireccion" class="col-lg-2 control-label">Direcci&oacute;n</label>
    <div class="col-md-6">
      <input type="text" name="txtDireccion" class="form-control" id="txtDireccion" placeholder="Direcci&oacute;n">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Tel&eacute;fono*</label>
    <div class="col-md-6">
      <input type="text" name="txtPhone" class="form-control" id="txtPhone" placeholder="Tel&eacute;fono" onkeyup="fnc(this,'-',patron,true)">
    </div>
  </div>

  <p class="alert alert-info">* Campos obligatorios</p>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-primary">Agregar Banco</button>
    </div>
  </div>
</form>
	</div>
</div>
