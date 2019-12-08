<?php  
	$max_salida=10; // Previene algun posible ciclo infinito limitando a 10 los ../
  $ruta_raiz=$ruta="";
  while($max_salida>0){
    if(@is_file($ruta.".htaccess")){
      $ruta_raiz=$ruta; //Preserva la ruta superior encontrada
      break;
    }
    $ruta.="../";
    $max_salida--;
  }

  include_once($ruta_raiz . 'clases/librerias.php');
  include_once($ruta_raiz . 'clases/sessionActiva.php');
  include_once($ruta_raiz . 'clases/Conectar.php');

  $usuario = $session->get("usuario");

  if ($usuario['tipo'] != 1) {
    header('Location: ' . $ruta_raiz . "clases/sessionCerrar.php");
  }

  $lib = new Libreria;

?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
  <?php  
    echo $lib->jquery();
    echo $lib->bootstrap();
    echo $lib->fontAwesome();
    echo $lib->proyecto();
    echo $lib->jqueryValidate();
    echo $lib->alertify();
    echo $lib->datatables();
  ?>
</head>
<body>
  <?php 
      include_once($ruta_raiz . 'navBar.php'); 
  ?>
  <div class="container">
    <h1 class="mt-4">Jugadores</h1>
    <div class="d-flex justify-content-start mb-4">
      <button class="btn btn-primary" data-toggle="modal" data-target="#crearJugadores"><i class="fas fa-plus"></i> Crear</button>
    </div>

    <table id="tabla" class="table table-hover table-sm">
      <thead class="text-center">
        <tr>
          <th>Documento</th>
          <th>Nombres</th>
          <th>apellidos</th>
          <th>direccion</th>
          <th>telefono</th>
          <th>correo</th>
          <th>eps</th>
          <th>talla</th>
          <th>peso</th>
          <th>dominacion</th>
          <th>#Camiseta</th>
          <th>edad</th>
          <th>foto</th>
          <th>Acciones</th>
          
        </tr>
      </thead>
      <tbody id="contenido-tabla" class="text-center"></tbody>
    </table>
  </div>

  <!-- Modal Crear jugadores -->
  <div class="modal fade" id="crearJugadores" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Crear Jugadores</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formCrearJugadores">
          <input type="hidden" name="accion" value="formCrearJugadores">
          <div class="modal-body">
            <div class="form-group">
              <label>Numero Documento: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="documento" id="documento" required>
            </div>
            <div class="form-group">
              <label>Nombres: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="nombre" id="nombre" required>
            </div>
            <div class="form-group">
              <label>apellidos: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="apellido" id="apellido" required>
            </div>
            <div class="form-group">
              <label>Direccion: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="direccion" id="direccion" required>
            </div>
            <div class="form-group">
              <label>Telefono: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="telefono" id="telefono" required>
            </div>
            <div class="form-group">
              <label>Correo: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="correo" id="correo" required>
            </div>
            <div class="form-group">
              <label>Eps: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="eps" id="eps" required>
            </div>
            <div class="form-group">
              <label>Talla: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="talla" id="talla" required>
            </div>
            <div class="form-group">
              <label>Peso: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="peso" id="peso" required>
            </div>
            <div class="form-group">
              <label>Dominacion: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="dominacion" id="dominacion" required>
            </div>
            <div class="form-group">
              <label>Numero Camiseta: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="numeroCamisa" id="numeroCamisa" required>
            </div>
            <div class="form-group">
              <label>edad: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="edad" id="edad" required>
            </div>
            <div class="form-group">
              <label>foto: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="foto" id="foto" required>
            </div>
          </div>
          <div class="d-flex justify-content-center modal-footer">
            <button type="submit" class="btn btn-success"><i class="far fa-save"></i> Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Editar jugadores -->
  <div class="modal fade" id="modalEditarJugadores" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar Jugadores</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formEditarJugadores" autocomplete="off">
          <input type="hidden" name="accion" value="formEditarJugadores">
          <input type="hidden" name="idJugadores" id="idJugadores">
          <div class="modal-body">
            <div class="form-group">
              <label>Numero Documento: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="documento" id="editdocumento" required>
            </div>
            <div class="form-group">
              <label>Nombres: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="nombre" id="editnombre" required>
            </div>
            <div class="form-group">
              <label>apellidos: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="apellido" id="editapellido" required>
            </div>
            <div class="form-group">
              <label>Direccion: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="direccion" id="editdireccion" required>
            </div>
            <div class="form-group">
              <label>Telefono: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="telefono" id="edittelefono" required>
            </div>
            <div class="form-group">
              <label>Correo: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="correo" id="editcorreo" required>
            </div>
            <div class="form-group">
              <label>Eps: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="eps" id="editeps" required>
            </div>
            <div class="form-group">
              <label>Talla: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="talla" id="edittalla" required>
            </div>
            <div class="form-group">
              <label>Peso: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="peso" id="editpeso" required>
            </div>
            <div class="form-group">
              <label>Dominacion: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="dominacion" id="editdominacion" required>
            </div>
            <div class="form-group">
              <label>Numero Camiseta: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="NumeroCamisa" id="editnumeroCamisa" required>
            </div>
            <div class="form-group">
              <label>edad: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="edad" id="editedad" required>
            </div>
            <div class="form-group">
              <label>foto: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="foto" id="editfoto" required>
            </div>
          </div>
          <div class="d-flex justify-content-center modal-footer">
            <button type="submit" class="btn btn-success"><i class="far fa-save"></i> Actualizar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<script>
  $(function(){
    cargarJugadores();

    //Formulario crear Jugadores
    $("#formCrearJugadores").validate({
      debug: true,
      rules: {
        nombreJugador: "required"
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      }
    });

    $("#formCrearJugadores").submit(function(event){
      event.preventDefault();
      if ($("#formCrearJugadores").valid()){
        $.ajax({
          url: 'acciones',
          type: 'POST',
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          data: new FormData(this),
          success: function(data){
            if (data.success) {
              $("#formCrearJugadores")[0].reset();
              $("#crearJugadores").modal("hide");
              cargarJugadores();
              alertify.success(data.msj);
            }else{
              alertify.error("Error al crear el Jugador.");
            }
          },
          error: function(){
            alertify.error("No ha enviado la información")
          }
        });
      }
    });

    //Formulario Editar Jugadores
    $("#formEditarJugadores").validate({
      debug: true,
      rules:{
        editNombre: "required"
      }, 
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      }
    });

    $("#formEditarJugadores").submit(function(event){
      event.preventDefault();
      if ($("#formEditarJugadores").valid()) {
        $.ajax({
          url: 'acciones',
          type: 'POST',
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          data: new FormData(this),
          success: function(data){
            console.log(data);
            if (data.success) {
              $('#modalEditarJugadores').modal("hide");
              $('#formEditarJugadores')[0].reset();
              cargarJugadores();
              alertify.success(data.msj);
            }else{
              alertify.error(data.msj);
            }
          },
          error: function(){
            alertify.error("Error al enviar el formulario.");
          }
        });
      }
      
    });

  });

  function cargarJugadores(){
    $.ajax({
      url: 'acciones',
      type: 'POST',
      dataType: 'json',
      data: {accion: 'listarJugadores'},
      success: function(data){
        $("#tabla").dataTable().fnDestroy();
        $("#contenido-tabla").empty();
        for (let i = 0; i < data.cantidad_registros; i++) {
          $("#contenido-tabla").append(`
            <tr>
              <td>${data[i].j_nroDocumento}</td>
              <td>${data[i].j_nombre}</td>
              <td>${data[i].j_apellido}</td>
              <td>${data[i].j_direccion}</td>
              <td>${data[i].j_telefono}</td>
              <td>${data[i].j_correo}</td>
              <td>${data[i].j_eps}</td>
              <td>${data[i].j_talla}</td>
              <td>${data[i].j_peso}</td>
              <td>${data[i].j_dominacion}</td>
              <td>${data[i].j_numeroCamisa}</td>
              <td>${data[i].j_edad}</td>
              <td>${data[i].j_foto}</td>
              <td><button class="btn btn-success" onClick="modificarJugadores(${data[i].j_id}, ${data[i].j_nroDocumento},${data[i].j_nombre},${data[i].j_apellido},${data[i].j_direccion},${data[i].j_telefono},${data[i].j_correo},${data[i].j_eps},${data[i].j_talla},${data[i].j_peso},${data[i].j_dominacion},${data[i].j_numeroCamisa},${data[i].j_edad},${data[i].j_foto}')"><i class="far fa-edit"></i> Editar</button></td>
            </tr>
          `);
        }
        definirdataTable('#tabla');
      },
      error: function(){
        alertify.error("No se han listado los Jugadores"); 
      }
    });
  }

  function modificarJugadores(id, documento, nombre, apellido, direccion, telefono, correo, eps,talla,peso,dominacion,numeroCamisa,edad,foto){
    $("#idJugador").val(id);
    $("#editnombre").val(nombre);
    $("#editapellido").val(apellido);
    $("#editdireccion").val(direccion);
    $("#edittelefono").val(telefono);
    $("#editcorreo").val(correo);
    $("#editeps").val(eps);
    $("#edittalla").val(talla);
    $("#editpeso").val(peso);
    $("#editdominacion").val(dominacion);
    $("#editnumeroCamisa").val(numeroCamisa);
    $("#editedad").val(edad);
    $("#editfoto").val(foto);
    $("#modalEditarJugadores").modal("show");
  }
</script>
<?php 
  echo $lib->cambioPantalla();
?>
</body>
</html>