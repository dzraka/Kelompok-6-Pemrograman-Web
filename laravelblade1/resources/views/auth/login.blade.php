@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Login</div>

            <div class="card-body">
                {{-- Formulir login. Data dikirim ke route login menggunakan POST --}}
                <form method="POST" action="{{ route('login') }}">
                    @csrf {{-- Token keamanan agar form hanya bisa dikirim dari aplikasi ini --}}

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}"
                               required autocomplete="email" autofocus>
                        {{-- Tampilkan pesan kesalahan jika input email bermasalah --}}
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong> {{-- Menampilkan pesan validasi --}}
                            </span>
                        @enderror
                    </div>

                    {{-- Input untuk password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong> {{-- Menampilkan pesan validasi --}}
                            </span>
                        @enderror
                    </div>

                    {{-- Checkbox untuk "Ingat Saya" --}}
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                               {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Remember Me 
                        </label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
