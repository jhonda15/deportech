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
    <h1 class="mt-4">partidos</h1>
      <div class="row">

      
        
        <table id="tabla" class="table table-hover col-8">
          <thead class="text-center">
            <tr>
              <th># camiseta</th>
              <th>Nombre</th>
              <th>Posicion</th>
              <th>Goles</th>
              <th>Tarjeta Amarilla</th>
              <th>Tarjeta Roja</th>
              <th>Sustitucion</th>
              
              
            </tr>
          </thead>
          <tbody id="contenido-tabla" class="text-center"></tbody>
        </table>
      
        <div class="chronometer col-4">
        <div id="vista">00 : 00 : 00 : 00</div>
          <div class="reloj">
            <button class="emerald" onclick="start()">START &#9658;</button>
            <button class="emerald" onclick="stop()">STOP &#8718;</button>
            <button class="emerald" onclick="resume()" >RESUME &#8634;</button>
            <button class="emerald" onclick="reset()">RESET &#8635;</button>
          </div>
        </div>
      </div>
    </div>
  

  <!-- Modal Crear estudiante -->
  <div class="modal fade" id="crearEstudiante" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Crear Estudiante</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formCrearEstudiante">
          <input type="hidden" name="accion" value="formCrearEstudiante">
          <div class="modal-body">
            <div class="form-group">
              <label>Numero Documento: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="documento" id="nombreEstudiante" required>
            </div>
            <div class="form-group">
              <label>Primer Nombre: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="Pnombre" id="nombreEstudiante" required>
            </div>
            <div class="form-group">
              <label>Segundo Nombre: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="Snombre" id="nombreEstudiante" required>
            </div>
            <div class="form-group">
              <label>Primer Apellido: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="Papellido" id="nombreEstudiante" required>
            </div>
            <div class="form-group">
              <label>Segundo Apellido: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="Sapellido" id="nombreEstudiante" required>
            </div>
            <div class="form-group">
              <label>Telefono: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="telefono" id="nombreEstudiante" required>
            </div>
            <div class="form-group">
              <label>Direccion: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="direccion" id="nombreEstudiante" required>
            </div>
            <div class="form-group">
              <label>correo: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="correo" id="nombreEstudiante" required>
            </div>
            <div class="form-group">
              <label>password: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="password" id="nombreEstudiante" required>
            </div>
          </div>
          <div class="d-flex justify-content-center modal-footer">
            <button type="submit" class="btn btn-success"><i class="far fa-save"></i> Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Editar Estudiante -->
  <div class="modal fade" id="modalEditarPartidos" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar Estudiante</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formEditarEstudiante" autocomplete="off">
          <input type="hidden" name="accion" value="formEditarEstudiante">
          <input type="hidden" name="idEstudiante" id="idEstudiante">
          <div class="modal-body">
          <div class="form-group">
              <label>Numero Documento: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="documento" id="nombreEstudiante" required>
            </div>
            <div class="form-group">
              <label>Primer Nombre: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="Pnombre" id="nombreEstudiante" required>
            </div>
            <div class="form-group">
              <label>Segundo Nombre: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="Snombre" id="nombreEstudiante" required>
            </div>
            <div class="form-group">
              <label>Primer Apellido: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="Papellido" id="nombreEstudiante" required>
            </div>
            <div class="form-group">
              <label>Segundo Apellido: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="Sapellido" id="nombreEstudiante" required>
            </div>
            <div class="form-group">
              <label>Telefono: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="telefono" id="nombreEstudiante" required>
            </div>
            <div class="form-group">
              <label>Direccion: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="direccion" id="nombreEstudiante" required>
            </div>
            <div class="form-group">
              <label>correo: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="correo" id="nombreEstudiante" required>
            </div>
            <div class="form-group">
              <label>password: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="password" id="nombreEstudiante" required>
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
    cargarPartidos();

    //Formulario crear partidos
    $("#formCrearEstudiante").validate({
      debug: true,
      rules: {
        nombreEstudiante: "required"
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

    $("#formCrearEstudiante").submit(function(event){
      event.preventDefault();
      if ($("#formCrearEstudiante").valid()){
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
              $("#formCrearEstudiante")[0].reset();
              $("#crearEstudiante").modal("hide");
              cargarPartidos();
              alertify.success(data.msj);
            }else{
              alertify.error("Error al crear el estudiante.");
            }
          },
          error: function(){
            alertify.error("No ha enviado la información")
          }
        });
      }
    });

    //Formulario Editar partidos
    $("#formEditarEstudiante").validate({
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

    $("#formEditarEstudiante").submit(function(event){
      event.preventDefault();
      if ($("#formEditarEstudiante").valid()) {
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
              $('#modalEditarPartidos').modal("hide");
              $('#formEditarPartidos')[0].reset();
              cargarPartidos();
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

  function cargarPartidos(){
    $.ajax({
      url: 'acciones',
      type: 'POST',
      dataType: 'json',
      data: {accion: 'listaPartidos'},
      success: function(data){
        $("#tabla").dataTable().fnDestroy();
        $("#contenido-tabla").empty();
        for (let i = 0; i < data.cantidad_registros; i++) {
          $("#contenido-tabla").append(`
            <tr>
              <td>${data[i].e_nroDocumento}</td>
              <td>${data[i].e_nombre}</td>
              <td>${data[i].e_nombre1}</td>
              <td>${data[i].e_apellido}</td>
              <td>${data[i].e_apellido2}</td>
              <td>${data[i].e_telefono}</td>
              <td>${data[i].e_direccion}</td>
              <td>${data[i].e_correo}</td>
              <td>${data[i].e_pass}</td>
              <td>${data[i].e_fechaCreacion}</td>
              <td><button class="btn btn-success" onClick="modificarPartidos(${data[i].e_id}, ${data[i].e_nroDocumento},${data[i].e_nombre},${data[i].e_nombre1},${data[i].e_apellido},${data[i].e_apellido2},${data[i].e_telefono},${data[i].e_direccion},${data[i].e_correo},${data[i].e_password},${data[i].e_fechaCreacion}')"><i class="far fa-edit"></i> Editar</button></td>
            </tr>
          `);
        }
        definirdataTable('#tabla');
      },
      error: function(){
        alertify.error("No se han listado los Partidos"); 
      }
    });
  }

  function modificarPartidos(id, documento, Pnombre, Snombre, Papellido, Sapellido,telefono, direccion, correo, password,Fcreacion){
    $("#idPartidos").val(id);
    $("#editnombreEstudiante").val(Pnombre);
    $("#editnombreEstudiante").val(Snombre);
    $("#editnombreEstudiante").val(Papellido);
    $("#editnombreEstudiante").val(Sapellido);
    $("#editnombreEstudiante").val(telefono);
    $("#editnombreEstudiante").val(direccion);
    $("#editnombreEstudiante").val(correo);
    $("#editnombreEstudiante").val(password);
    $("#editnombreEstudiante").val(Fcreacion);
    $("#modalEditarEstudiante").modal("show");
  }
</script>
<?php 
  echo $lib->cambioPantalla();
?>
</body>
</html>