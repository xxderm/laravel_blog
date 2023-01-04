@extends('base')
@section('title', 'New post')

@section('content')
<form method="POST">
  @csrf
  @method('POST')
  <div class="form-group">
    <label for="exampleFormControlInput1">Название</label>
    <input type="text" name="title" class="form-control" id="exampleFormControlInput1">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Описание</label>
    <input type="text" name="desc" class="form-control" id="exampleFormControlInput1" >
  </div>  
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Содержание</label>
    <textarea name="content" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>

  <button type="submit" class="btn btn-primary">Добавить</button>
</form>
@endsection