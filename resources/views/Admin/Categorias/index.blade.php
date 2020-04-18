@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="sweetalert2.all.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- Optional: include a polyfill for ES6 Promises for IE11 -->
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.css">
<style>
.mostrar{
   display: none;
}
#tabla>tbody>tr>td:hover>.mostrar{
  display:table-cell;
}
</style>
<div class="container">
     <h3 align="center">Administracion de Categorias</h3>
     <br />
     <div align="right">
      <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Agregar Categoria</button>
     </div>
     <br />
   <div class="table-responsive">
    <table class="table table-bordered table-striped" id="tabla">
           <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="25%">Nombre</th>
                <th width="50%">Descripcion</th>
                <th width="20%">Acciones</th>
            </tr>
           </thead>
       </table>
      </div>
   <br />
   <br />
  </div>


<div id="formModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h4 class="modal-title">Agregar Categoria</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
         <span id="form_result"></span>
         <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label class="control-label col-md-4" >Nombre : </label>
            <div class="col-md-12">
             <input type="text" name="nombre" id="nombre" class="form-control" />
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">Descripcion : </label>
            <div class="col-md-12">
             <input type="text" name="descripcion" id="descripcion" class="form-control" />
            </div>
           </div>
           <br />
           <div class="form-group" align="center">
            <input type="hidden" name="action" id="action" />
            <input type="hidden" name="hidden_id" id="hidden_id" />
            <input type="submit" name="action_button" id="action_button" class="btn btn-success btn-lg" value="Agregar" />
           </div>
         </form>
        </div>
     </div>
    </div>
</div>
<div class="modal" id="confirmModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h2 align="center" style="margin:0;">¿Seguro que quieres eliminarlo?</h2>
            <strong class="text-center ml-4">Esta accion podria afectar a los productos relacionados!</strong>
        </div>
        <div class="modal-footer">
            <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">Si, Eliminar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
</div>


<script>
$(document).ready(function(){

 $('#tabla').DataTable({
  serverSide: true,
  "language": {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
  ajax:{
   url: "{{ route('Categorias.index') }}",
  },
  columns:[
    {
    data:'id',
    name:'id'

    },
   {
    data: 'nombre',
    name: 'nombre'
   },
   {
    data: 'descripcion',
    name: 'descripcion'
   },
   {
    data: 'action',
    name: 'action',
    orderable: false
   }
  ]
 });

 $('#create_record').click(function(){

     $('#action_button').val("Agregar");
     $('.modal-title').text("Crear nueva categoria");
     $('#action').val("Agregar");
     $('#formModal').modal('show');
 });

 $('#sample_form').on('submit', function(event){
  event.preventDefault();
  if($('#action_button').val() == 'Agregar')
  {
   $.ajax({
    url:"{{ route('Categorias.store') }}",
    method:"POST",
    data: new FormData(this),
    contentType: false,
    cache:false,
    processData: false,
    dataType:"json",
    success:function(data)
    {
     var html = '';
     if(data.errors)
     {
      html = '<div class="alert alert-danger">';
      for(var count = 0; count < data.errors.length; count++)
      {
       html += '<p>' + data.errors[count] + '</p>';
      }
      html += '</div>';
     }
     if(data.success)
     {
      $('#sample_form')[0].reset();
      $('#tabla').DataTable().ajax.reload();
      $('#formModal').modal('hide');
      toastr.success('Categoria Registrada con exito');
     }else{
        $('#form_result').html(html);
     }


    }
   })
  }

  if($('#action').val() == "Editar")
  {
   $.ajax({
    url:"{{ route('Categorias.update') }}",
    method:"POST",
    data:new FormData(this),
    contentType: false,
    cache: false,
    processData: false,
    dataType:"json",
    success:function(data)
    {
     var html = '';
     if(data.errors)
     {
      html = '<div class="alert alert-danger">';
      for(var count = 0; count < data.errors.length; count++)
      {
       html += '<p>' + data.errors[count] + '</p>';
      }
      html += '</div>';
     }
     if(data.success)
     {
        html = '<div id="alert" class="alert alert-success">' + data.success + '</div>';
      $('#tabla').DataTable().ajax.reload();
      toastr.success('Categoria Actualizada con exito');
      $('#formModal').modal('hide');
     }
    }
   });
  }
 });
 var id;
 $(document).on('click', '.edit', function(){
  var id = $(this).attr('id');
  console.log(id);
  $('#form_result').html('');
  $.ajax({
   url:"/Categorias/"+id+"/edit",
   dataType:"json",
   success:function(html){
    $('#nombre').val(html.data.nombre);
    $('#descripcion').val(html.data.descripcion);
    $('#hidden_id').val(html.data.id);
    $('.modal-title').text("Editar Categoria");
    $('#action_button').val("Editar");
    $('#action').val("Editar");
    $('#formModal').modal('show');
   }
  })
 });

 var user_id;

 $(document).on('click', '.delete', function(){
  user_id = $(this).attr('id');
  $('.modal-title').text("Eliminar Categoria");
  $('#confirmModal').modal('show');
 });

 $('#ok_button').click(function(){
  $.ajax({
   url:"Categorias/destroy/"+user_id,

   success:function(data)
   {
     $('#confirmModal').modal('hide');
     $('#tabla').DataTable().ajax.reload();

   },
   complete: function(){
     toastr.error('Categoria Eliminado');
   }
  })
 });

});
</script>
@endsection
