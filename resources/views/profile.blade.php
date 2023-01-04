@extends('base')
@section('title', 'Profile')

@section('content')
<section class="h-100 gradient-custom-2">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-lg-9 col-xl-7">
        <div class="card">
          <div class="p-4 text-black" style="background-color: #f8f9fa;">
            <h5>{{ $user->email; }}</h5>
            <div class="d-flex justify-content-center text-center py-1">
              <div>
                <p class="mb-1 h5">{{
                    $user->Publications->count();
                  }}</p>
                <p class="small text-muted mb-0">Публикации</p>
              </div>
            </div>
          </div>
          <div class="card-body p-4 text-black">
            <div class="mb-5">
              <p class="lead fw-normal mb-1">Аккаунт</p>
              <div class="p-4" style="background-color: #f8f9fa;">
                <p class="mb-1">{{ $user->email }}</p>
                @if(!$user->hasVerifiedEmail())
                  <a href="/profile/verify">Подтвердите почту</a>
                @else 
                  <p class="mb-1">Почта подтверждена!</p>
                @endif
                <p class="mb-1">На сайте с {{ $user->created_at }}</p>
                <a href="/password-change" class="mb-1">Сменить пароль</a>
                @if (Session::has('message'))
                    <div class="alert alert-success">
                      {{ Session::get('message') }}
                    </div>
                @endif
              </div>
            </div>
            <a href="/profile/new-post">Новая публикация</a>

            <hr/>

            <div class="d-flex justify-content-between align-items-center mb-4">
              <p class="lead fw-normal mb-0">Предыдущие публикации</p>
            </div>

            @foreach ($user->Publications as $publication)
            <hr/>
            <div class="row g-2">
              <div style="margin:5px;" class="col mb-2 border-left border-primary">
                  <a href="{{ route('view-post', ['id' => $publication->id]) }}"><h3 align="left">{{ $publication->title }}</h3></a>
                  <p align="left">{{ $publication->desc }}</p>  
                  <p align="left">{{ $publication->content }}</p>
              </div>     
            </div>  
            <div align="left">
              <a href="{{ route('view-post', ['id' => $publication->id]) }}">перейти</a>     
              <a href="">редактировать</a>     
              <a href="">удалить</a>    
            </div>
            @endforeach

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection