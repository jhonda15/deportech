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
    <h1 class="mt-4">Materias</h1>
    <div class="d-flex justify-content-start mb-4">
      <button class="btn btn-primary" data-toggle="modal" data-target="#crearMateria"><i class="fas fa-plus"></i> Crear</button>
    </div>

    <table id="tabla" class="table table-hover">
      <thead class="text-center">
        <tr>
          <th>Materia</th>
          <th>Fecha creación</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="contenido-tabla" class="text-center"></tbody>
    </table>
  </div>

  <!-- Modal Crear Materia -->
  <div class="modal fade" id="crearMateria" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Crear Materia</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formCrearMateria">
          <input type="hidden" name="accion" value="formCrearMateria">
          <div class="modal-body">
            <div class="form-group">
              <label>Nombre: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="nombreMateria" id="nombreMateria" required>
            </div>
          </div>
          <div class="d-flex justify-content-center modal-footer">
            <button type="submit" class="btn btn-success"><i class="far fa-save"></i> Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Editar Materia -->
  <div class="modal fade" id="modalEditarMateria" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar Materia</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formEditarMateria" autocomplete="off">
          <input type="hidden" name="accion" value="formEditarMateria">
          <input type="hidden" name="idMateria" id="idMateria">
          <div class="modal-body">
            <div class="form-group">
              <label>Nombre: <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="editNombreMateria" id="editNombreMateria" required>
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
    cargarMaterias();

    //Formulario crear curso
    $("#formCrearMateria").validate({
      debug: true,
      rules: {
        nombreMateria: "required"
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

    $("#formCrearMateria").submit(function(event){
      event.preventDefault();
      if ($("#formCrearMateria").valid()){
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
              $("#formCrearMateria")[0].reset();
              $("#crearMateria").modal("hide");
              cargarMaterias();
              alertify.success(data.msj);
            }else{
              alertify.error("Error al crear la materia.");
            }
          },
          error: function(){
            alertify.error("No ha enviado la información")
          }
        });
      }
    });

    //Formulario Editar materia
    $("#formEditarMateria").validate({
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

    $("#formEditarMateria").submit(function(event){
      event.preventDefault();
      if ($("#formEditarMateria").valid()) {
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
              $('#modalEditarMateria').modal("hide");
              $('#formEditarMateria')[0].reset();
              cargarMaterias();
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

  function cargarMaterias(){
    $.ajax({
      url: 'acciones',
      type: 'POST',
      dataType: 'json',
      data: {accion: 'listaMaterias'},
      success: function(data){
        $("#tabla").dataTable().fnDestroy();
        $("#contenido-tabla").empty();
        for (let i = 0; i < data.cantidad_registros; i++) {
          $("#contenido-tabla").append(`
            <tr>
              <td>${data[i].m_nombre}</td>
              <td>${data[i].m_fechaCreacion}</td>
              <td><button class="btn btn-success" onClick="modificarMateria(${data[i].m_id}, '${data[i].m_nombre}')"><i class="far fa-edit"></i> Editar</button></td>
            </tr>
          `);
        }
        definirdataTable('#tabla');
      },
      error: function(){
        alertify.error("No se han listado las materias"); 
      }
    });
  }

  function modificarMateria(id, nombre){
    $("#idMateria").val(id);
    $("#editNombreMateria").val(nombre);
    $("#modalEditarMateria").modal("show");
  }
</script>
<?php 
  echo $lib->cambioPantalla();
?>
</body>
</html>