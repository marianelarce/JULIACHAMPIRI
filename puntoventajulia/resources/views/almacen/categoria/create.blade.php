@extends('layouts.admin')
@section('contenido')
<!-- left colum -->
<div class="col-md-6">
  <!-- general form elements -->
  <div class="card card-primary">
    <div class ="card-header">
    <h3 class="card-title">Nueva Categoria</h3>
</div>
<!-- /.card-header -->
<!-- form start -->

<form action="{{ route('categoria.store') }}" method="POST" class="form">
  @csrf 
  <div class="card-body">
  <div class="form-group">
    <label for="categoria">Nombre</label>
    <input type="text" class="form-control" name="categoria" id="categoria" placeholder="Ingresa el nombre de la categoria">
</div>

<div class="form-group">
    <label for="descripcion">Descripcion</label>
    <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Ingresa la ">
</div>
<!-- /.card-boy -->

<div class="card-footer">
    <button type="submit" class ="btn btn-success me-1 mb-1">Guardar</button>
    <button type="reset" class="btn btn-danger me-1 mb-1">Cancelar></button>
        </div>
      </div>
   </form>
 </div>
</div>
@endsection
