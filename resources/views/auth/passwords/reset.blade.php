@extends('tithe::auth')

@section('content')
    <main class="col-12 col-lg-5">
        <div class="mb-5 text-center">
            <h1>Please <span class="font-cursive">reset</span> your password</h1>
        </div>
        <div class="card shadow-lg w-auto">
            <div class="card-body">
                <form method="POST" action="{{ route('tithe.password.update') }}" class="w-100 my-auto">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="form-group row">
                        <div class="col-12">
                            <label for="email" class="font-weight-bold text-uppercase text-muted small"> Email </label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                id="email"
                                class="form-control border-0"
                                placeholder="Email address"
                                required
                                autofocus
                            />
                            {{-- @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror --}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <label for="password" class="font-weight-bold text-uppercase text-muted small"> Password </label>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control border-0"
                                placeholder="Password"
                                required
                            />
                            {{-- @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror --}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <label for="password_confirmation" class="font-weight-bold text-uppercase text-muted small"> Confirm password </label>
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="form-control border-0"
                                placeholder="Confirm password"
                                required
                            />
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <button class="btn btn-success btn-block mt-3" type="submit">Reset password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection