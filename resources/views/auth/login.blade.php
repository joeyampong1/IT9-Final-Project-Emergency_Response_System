@extends('layouts.app')

@section('title', 'Login')

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
                <h2 class="text-xl sm:text-2xl font-bold text-center text-gray-800 mb-6">Welcome Back</h2>

                @if($errors->any())
                    <div class="alert alert-error mb-4 text-sm">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required class="form-input rounded-lg">
                    </div>
                    <div class="form-group relative">
                        <label for="password" class="form-label">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" required class="form-input pr-10 rounded-lg">
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="form-group flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="form-checkbox rounded">
                            <span class="text-sm text-gray-600 ml-2">Remember me</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm text-red-600 hover:underline">Forgot password?</a>
                    </div>
                    <button type="submit" class="btn btn-primary w-full py-3 rounded-xl font-semibold text-base">Log In</button>
                </form>
                <p class="mt-6 text-center text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-red-600 hover:underline font-medium">Register</a>
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#password');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('svg').innerHTML = type === 'password'
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 012.754-3.8M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"></path>';
        });
    }
</script>
@endpush
@endsection