function validarFormulario() {
  const infoPersona = document.getElementById("InfoPersona").value;
  if (!infoPersona || infoPersona.lenght == 0) {
    alert("FALTA INFORMACIÓN");
    return false;
  }

  const correo = document.getElementById("email").value;
  if (!/^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/.test(correo)) {
    alert("FALTA CORREO");
    return false;
  }

  const telefono = document.getElementById("Telefono").value;
  if (!/^\d{8}$/.test(telefono)) {
    alert("FALTA TELEFONO");
    return false;
  }
  const nombreEmpresa = document.getElementById("nombre_empresa").value;
  if (!nombreEmpresa || nombreEmpresa.lenght == 0) {
    alert("FALTA NOMBRE DE LA EMPRESA");
    return false;
  }
  const horario = document.getElementById("horario").value;
  if (!horario || horario.lenght == 0) {
    alert("FALTA EL HORARIO");
    return false;
  }

  const direccion = document.getElementById("direccion_empresa").value;
  if (!direccion || direccion.lenght == 0) {
    alert("FALTA LA DIRECCIÓN");
    return false;
  }

  const descripcion = document.getElementById("descripcion").value;
  if (!descripcion || descripcion.lenght == 0) {
    alert("FALTA LA DIRECCIÓN");
    return false;
  }
}
