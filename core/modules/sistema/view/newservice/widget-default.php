
<script type="text/javascript">





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
	<h1>Nuevo Servicio</h1>
	<br>
		<form class="form-horizontal" method="post" id="addservice" action="index.php?view=addservice" role="form">
		  <div class="form-group">
		    <label for="nombre" class="col-lg-2 control-label">Nombre*</label>
		    <div class="col-md-6">
		      <input type="text" name="nombre" required class="form-control" id="nombre" placeholder="Nombre Del Servicio" onkeypress="return vNom(event,this)">
		    </div>
		  </div>
		   <div class="form-group">
		    <label for="descripcion" class="col-lg-2 control-label">Descripci&oacute;n*</label>
		    <div class="col-md-6">
		      <input type="text" name="descripcion" required class="form-control" id="descripcion" placeholder="Descripci&oacute;n Del Servicio">
		    </div>
		  </div>
			<div class="form-group">
		    <label for="precio" class="col-lg-2 control-label">Precio*</label>
		    <div class="col-md-6">
		      <input type="text" name="precio" class="form-control" required id="precio" placeholder="Precio">
		    </div>
		  </div>
		  <p class="alert alert-info">* Campos obligatorios</p>
		  <div class="form-group">
		    <div class="col-lg-offset-2 col-lg-10">
		      <button type="submit" class="btn btn-primary">Agregar Servicio</button>
		    </div>
		  </div>
		</form>
	</div>
</div>
