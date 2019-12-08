<?php
  @session_start();

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

  require_once($ruta_raiz . 'clases/funciones_generales.php');
  require_once($ruta_raiz . 'clases/Session.php');
  require_once($ruta_raiz . 'clases/librerias.php');

  $lib = new Libreria;
?>
<!DOCTYPE html>
<html>
<head>
  <?php  
    echo $lib->metaTagsRequired();
  ?>

  <title>Proyecto de Grado</title>
  <?php  
    echo $lib->iconoPag();
    echo $lib->jquery();
    echo $lib->bootstrap();
    echo $lib->fontAwesome();
    echo $lib->jqueryValidate();
    echo $lib->alertify();
    echo $lib->proyecto();
  ?>

  <style>
    html,
    body {
      height: 100%;
    }

    body {
      display: -ms-flexbox;
      display: flex;
      -ms-flex-align: center;
      align-items: center;
      padding-top: 40px;
      padding-bottom: 40px;
      background-color: #f5f5f5;
    }

    .form-signin {
      width: 100%;
      max-width: 330px;
      padding: 15px;
      margin: auto;
    }

    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
</head>
<body class="text-center">
<form id="formLogin" class="form-signin" autocomplete="off">
    <img class="mb-4" src="img/logo.png" alt="Logo del instituto" width="70%">
    <div class="form-group">
    <label for="nroDoc" class="sr-only">Número de documento</label>
      <input type="text" id="nroDoc" name="nroDoc" class="form-control" placeholder="Ingrese su nro de documento" required autofocus autocomplete="off">
    </div>
    
    <div class="form-group">
      <div class="input-group">
        <input class="form-control" type="password" id="password" name="password" placeholder="Ingrese la contraseña" required>
        <div class="input-group-append">
          <button class="btn btn-secondary btn-login" type="button" id="btnEye" data-toggle="button" aria-pressed="false" autocomplete="off"><i id="passicon" class="fas fa-eye"></i></button>
        </div>
      </div>
    </div>

    <div class="form-group">
      <select name="tipo" class="custom-select" id="tipo" required>
        <option value="0" disabled selected>Seleccione una opción</option>
        <option value="1">Administrativo</option>
      </select>
    </div>
    
    <button class="btn btn-lg btn-primary btn-block" type="submit">Inicio de sesión</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2019</p>
  </form>
</body>
<script type="text/javascript">
  $(function(){
    $("#btnEye").on("click", function(){
      if ($("#btnEye").attr("aria-pressed") == "false") {
        $("#passicon").removeClass("fa-eye");
        $("#passicon").addClass("fa-eye-slash");
        $("#password").attr("type", "text");
      }else if ($("#btnEye").attr("aria-pressed") == "true") {
        $("#passicon").removeClass("fa-eye-slash");
        $("#passicon").addClass("fa-eye");
        $("#password").attr("type", "password");
      }
    });

    $("#formLogin").validate({
      debug: false,
      rules:{
        usuario: "required",
        password: "required",
        tipo: "required"
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

    $("#formLogin").submit(function(event) {
      event.preventDefault();
      if($("#formLogin").valid()){
        $.ajax({
          type: "POST",
          url: "<?php echo($ruta_raiz); ?>ajax/login.php",
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          data: new FormData(this),
          success: function(data){
            if (data.success) {
              switch ($("#tipo").val()) {
                case "1":
                  localStorage.proyectourl = "modulos/admin/"; 
                  break;
                }
              window.location.href="central.php";
            }else{
              alertify.error(data.mjs);
            }
          },
          error: function(){
              alertify.error("No se ha encontrado el archivo");
          }
        });
      }
    });
  }); 
</script>
</html>