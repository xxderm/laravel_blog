@extends('base')
@section('title', 'Home')

@section('content')
<section class="h-100 gradient-custom-2">
  <div class="container py-5 h-100">
        @foreach ($posts as $publication)
        <hr/>
        <div class="row g-2">
            <div style="margin:5px;" class="col mb-2 border-left border-primary">
                <a href=""><h3 align="left">{{ $publication->title }}</h3></a>
                <p align="left">{{ $publication->desc }}</p>  
                <p align="left">{{ $publication->content }}</p>
            </div>     
        </div>  
        @endforeach
    </div>
</section>
@endsection