@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-8 sm:py-12 bg-cover bg-center"
     style="background-image: url('{{ asset('images/ERS bg_2.png') }}');">
    <div class="w-full max-w-md">
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden">
            <div class="bg-red-600 h-1.5 w-full"></div>
            <div class="p-5 sm:p-6 md:p-8 text-center">
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('images/ERS logo Login.png') }}" alt="ERS Logo" class="h-16 sm:h-20 w-auto rounded-lg">
                </div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4">Verify Your Email Address</h2>

                @if (session('resent'))
                    <div class="alert alert-success mb-4 text-sm">
                        A fresh verification link has been sent to your email address.
                    </div>
                @endif

                <p class="text-gray-600 mb-4 text-sm sm:text-base">
                    Before proceeding, please check your email for a verification link.
                </p>
                <p class="text-gray-600 mb-6 text-sm sm:text-base">
                    If you did not receive the email,
                </p>

                <form method="POST" action="{{ route('verification.resend') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium underline">
                        click here to request another
                    </button>.
                </form>
            </div>
        </div>
    </div>
</div>
@endsection