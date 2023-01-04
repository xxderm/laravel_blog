@extends('base')
@section('title', 'Edit post')

@section('content')
<form method="POST">
  @csrf
  @method('POST')
  <div class="form-group">
    <label for="exampleFormControlInput1">Название</label>
    <input value="{{ $post->title }}" type="text" name="title" class="form-control" id="exampleFormControlInput1">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Описание</label>
    <input value="{{ $post->desc }}" type="text" name="desc" class="form-control" id="exampleFormControlInput1" >
  </div>  
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Содержание</label>
    <textarea name="content" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $post->content }}</textarea>
  </div>

  <button type="submit" class="btn btn-primary">Обновить</button>
</form>
@endsection