function definirdataTable(nombreDataTable){
  // =======================  Data tables ==================================
  $(nombreDataTable).DataTable({
    "language": {
      "decimal":        "",
      "emptyTable":     "No hay datos disponibles en la tabla",
      "info":           "Mostrando _START_ desde _END_ hasta _TOTAL_ registros",
      "infoEmpty":      "Mostrando 0 desde 0 hasta 0 registros",
      "infoFiltered":   "(Filtrado por _MAX_ total)",
      "infoPostFix":    "",
      "thousands":      ",",
      "lengthMenu":     "Mostrar _MENU_",
      "loadingRecords": "Cargando...",
      "processing":     "Procesando...",
      "search":         "Buscar:",
      "zeroRecords":    "No se encontraron registros",
      "paginate": {
        "first":      "Primero",
        "last":       "Último",
        "next":       "Siguiente",
        "previous":   "Anterior"
      }
    },
    stateSave: true,
    "processing": true
  });
}

function definirdataTableDragAndDrop(nombreDataTable){
  // =======================  Data tables ==================================
  $(nombreDataTable).DataTable({
    rowReorder: true,
    "language": {
      "decimal":        "",
      "emptyTable":     "No hay datos disponibles en la tabla",
      "info":           "Mostrando _START_ desde _END_ hasta _TOTAL_ registros",
      "infoEmpty":      "Mostrando 0 desde 0 hasta 0 registros",
      "infoFiltered":   "(Filtrado por _MAX_ total)",
      "infoPostFix":    "",
      "thousands":      ",",
      "lengthMenu":     "Mostrar _MENU_",
      "loadingRecords": "Cargando...",
      "processing":     "Procesando...",
      "search":         "Buscar:",
      "zeroRecords":    "No se encontraron registros",
      "paginate": {
        "first":      "Primero",
        "last":       "Último",
        "next":       "Siguiente",
        "previous":   "Anterior"
      }
    },
    stateSave: true,
    "processing": true
  });
}

function definirdataTableExport(nombreDataTable){
  // =======================  Data tables ==================================
  var tabla = $(nombreDataTable).DataTable({
    responsive: true,
    "language": {
      "decimal":        "",
      "emptyTable":     "No hay datos disponibles en la tabla",
      "info":           "Mostrando _START_ desde _END_ hasta _TOTAL_ registros",
      "infoEmpty":      "Mostrando 0 desde 0 hasta 0 registros",
      "infoFiltered":   "(Filtrado por _MAX_ total)",
      "infoPostFix":    "",
      "thousands":      ",",
      "lengthMenu":     "Mostrar _MENU_",
      "loadingRecords": "Cargando...",
      "processing":     "Procesando...",
      "search":         "Buscar:",
      "zeroRecords":    "No se encontraron registros",
      "paginate": {
        "first":      "Primero",
        "last":       "Ãšltimo",
        "next":       "Siguiente",
        "previous":   "Anterior"
      }
    },
    stateSave: true,
    "processing": true,
    lengthChange: true,
    buttons: ['excel', 'pdf',
              {
                extend: 'colvis',
                text: 'Mostrar columnas'
              }
            ]
  });

  tabla.buttons().container().appendTo(nombreDataTable + '_wrapper .col-md-6:eq(0)');
}

function soloNumeros(e){
  var keynum = window.event ? window.event.keyCode : e.which;
  if ((keynum == 8) || (keynum == 46))
    return true;
    return /\d/.test(String.fromCharCode(keynum));
}