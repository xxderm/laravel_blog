@extends('base')
@section('title', 'Login')

@section('content')
<form class="vh-20" method="POST">
    @csrf
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">

                    <h3 class="mb-5">Sign in</h3>

                    <div class="form-outline mb-4">
                        <input name="email" type="email" id="typeEmailX-2" class="form-control form-control-lg" />
                        <label class="form-label" for="typeEmailX-2">Email</label>
                    </div>

                    <div class="form-outline mb-4">
                        <input name="password" type="password" id="typePasswordX-2" class="form-control form-control-lg" />
                        <label class="form-label" for="typePasswordX-2">Password</label>
                    </div>

                    @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>

                    <hr/>
                    <a href="signup" for="form1Example3">Sign Up</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection