@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-8 sm:py-12 bg-cover bg-center"
     style="background-image: url('{{ asset('images/ERS bg_2.png') }}');">
    <div class="w-full max-w-md">
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-2xl shadow-black/40 overflow-hidden transition-all duration-300 hover:shadow-red-500/20">
            <div class="bg-red-600 h-1.5 w-full"></div>
            <div class="p-5 sm:p-6 md:p-8">
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('images/ERS logo Login.png') }}" alt="ERS Logo" class="h-16 sm:h-20 w-auto rounded-lg">
                </div>
                <h2 class="text-xl sm:text-2xl font-bold text-center text-gray-800 mb-6">Reset Password</h2>

                @if(session('status'))
                    <div class="alert alert-success mb-4 text-sm">{{ session('status') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error mb-4 text-sm">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus class="form-input rounded-lg">
                    </div>
                    <button type="submit" class="btn btn-primary w-full py-3 rounded-xl font-semibold text-base mt-2">Send Password Reset Link</button>
                </form>
                <p class="mt-6 text-center text-sm text-gray-600">
                    <a href="{{ route('login') }}" class="text-red-600 hover:underline">Back to Login</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection