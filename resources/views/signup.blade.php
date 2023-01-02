@extends('base')
@section('title', 'Sign up')

@section('content')
<form class="vh-20" method="POST">
    @csrf
    @method('POST')
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">

                    <h3 class="mb-5">Sign up</h3>

                    <div class="form-outline mb-4">
                        <input name="email" type="email" id="typeEmailX-2" class="form-control form-control-lg" />
                        <label class="form-label" for="typeEmailX-2">Email</label>
                    </div>

                    <div class="form-outline mb-4">
                        <input name="password" type="password" id="typePasswordX-2" class="form-control form-control-lg" />
                        <label class="form-label" for="typePasswordX-2">Password</label>
                    </div>

                    <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>

                    <hr/>
                    <a href="login" for="form1Example3">Sign in</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection