@extends('base')
@section('title', $post->title)

@section('content')
<section>
    <div class="container my-5 py-5">
        <div class="col-md-12 col-lg-10">
            <h2 align="left">{{ $post->title }}</h2>
            <p align="left" >{{ $post->desc }}</p>
            <p align="left" >{{ $post->content }}</p>
            <p align="left" >Издатель: {{ $post->Publisher->email }}</p>
            <p align="left" >Дата публикации: {{ $post->created_at }}</p>
            <p align="left" >Дата обновления: {{ $post->updated_at }}</p>
        </div>
    </div>
</section>

<section >
  <div class="container my-5 py-5">
    <div class="row d-flex justify-content-center">
      <div class="col-md-12 col-lg-10">
        <div class="card text-dark">
          <div class="card-body p-4">
            <h4 class="mb-0">Коментарии</h4>
            <p class="fw-light mb-4 pb-2">Последние коментарии от пользователей</p>

            @foreach ($post->Comments as $comment)
            <hr class="my-0" />
            <div class="d-flex flex-start" style="padding-top:15px;">
                <div>
                    <h6 class="fw-bold mb-1" align="left">{{ $comment->User->email }}</h6>
                    <div class="d-flex align-items-center mb-3">
                        <p class="mb-0">
                        {{ $comment->created_at }}
                        </p>
                    </div>
                    <p class="mb-0" align="left">
                        {{ $comment->content }}
                        </p>
                </div>
                
            </div>
            <div align="left" style="padding-bottom:10px;">
                <p >понравилось: {{ $comment->votes }}</p>
                <a class="btn btn-primary" href="{{ route('view-post.like-comment', $comment->id) }}" role="button">Нравится</a>
            </div>
            <hr class="my-0" />
            @endforeach

            <section>
                <div class="container my-5 py-5 text-dark">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-10 col-lg-10 col-xl-10">
                            <div class="card">
                                <div class="card-body p-4">
                                    <div class="d-flex flex-start w-100">
                                        <div class="w-100" >
                                            <form action="{{ route('view-post.push-comment', $post->id) }}" method="POST">
                                                @csrf 
                                                <h5>Добавить комментарий</h5>
                                                <div class="form-outline">
                                                <textarea name="content" class="form-control" id="textAreaExample" rows="4"></textarea>
                                                </div>
                                                <div class="d-flex justify-content-between mt-3">
                                                <button type="submit" class="btn btn-success">Отправить</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
          
        </div>
      </div>
    </div>
  </div>
</section>

@endsection