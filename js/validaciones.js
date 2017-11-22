var dui = new Array(8,1)
var nit = new Array(4,6,3,1)
var nrc = new Array(4,6,3,1)
var tel = new Array(4,4)
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
            if (valor3[1] > 13243434) {
              valor = valor3[0];
            } else if (valor3[2] > 4444) {
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
      return false;
    }
    // Convertir 1° letra a mayuscula
    if (txt.length==0 || txt.substr(txt.length-1,1)==' ') {
      solicitar.value = txt+te.toUpperCase();
      return false;
    }
    return true;
  }

  function vNomX(e,solicitar){
    // Admitir solo letras
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8 || tecla == 0) return true;
    patron =/[Á-Úá-ú#().,_/\w\s]/;
    te = String.fromCharCode(tecla);
    if (!patron.test(te)) return false;
    // No admitir espacios iniciales
    txt = solicitar.value;
    if(txt.length==0 && te==' '){
      return false;
    }
    // Convertir 1° letra a mayuscula
    if (txt.length==0 || txt.substr(txt.length-1,1)==' ') {
      solicitar.value = txt+te.toUpperCase();
      return false;
    }
    return true;
  }

  function soloNumeros(e){key = (window.Event) ? e.which : e.keyCode; return (key >= 48 && key <= 57 || key >= 8 && key <= 31 || key == 0);}

  function precio(e){
    key = (window.Event) ? e.which : e.keyCode;
    return (key >= 48 && key <= 57 || key >= 8 && key <= 31 || key == 0 || key == 46);
  }
  function inventario(e){
    key = (window.Event) ? e.which : e.keyCode;
    return (key >= 48 && key <= 57 || key >= 8 && key <= 31 || key == 0 );
  }
