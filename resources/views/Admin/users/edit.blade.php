@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    @include('layouts.page-header', ['title' => 'Edit User: ' . $user->name])

<div class="container-custom max-w-2xl mx-auto px-4 mt-6">
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.users.index') }}" class="text-red-600 hover:text-red-800 transition flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Users
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-error mb-6">{{ implode('', $errors->all(':message<br>')) }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-red-600 h-1.5 w-full"></div>
        <div class="p-6 md:p-8">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-5">
                    <div class="form-group">
                        <label for="name" class="form-label">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="form-input rounded-lg">
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="form-input rounded-lg">
                    </div>

                    <div class="form-group">
                        <label for="role" class="form-label">Role <span class="text-red-500">*</span></label>
                        <select name="role" id="role" required class="form-select rounded-lg">
                            <option value="citizen" {{ old('role', $user->role) == 'citizen' ? 'selected' : '' }}>Citizen</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group relative">
                            <label for="password" class="form-label">New Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" class="form-input pr-10 rounded-lg">
                                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Leave blank to keep current password</p>
                        </div>

                        <div class="form-group relative">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input pr-10 rounded-lg">
                                <button type="button" id="toggleConfirmPassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-8">
                    <button type="submit" class="btn btn-primary px-8 py-2.5 rounded-lg shadow-md hover:shadow-lg transition">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Toggle for Password
    const togglePass = document.getElementById('togglePassword');
    const passInput = document.getElementById('password');
    if (togglePass && passInput) {
        togglePass.addEventListener('click', function() {
            const type = passInput.type === 'password' ? 'text' : 'password';
            passInput.type = type;
            this.querySelector('svg').innerHTML = type === 'password'
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 012.754-3.8M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"></path>';
        });
    }

    // Toggle for Confirm Password
    const toggleConfirm = document.getElementById('toggleConfirmPassword');
    const confirmInput = document.getElementById('password_confirmation');
    if (toggleConfirm && confirmInput) {
        toggleConfirm.addEventListener('click', function() {
            const type = confirmInput.type === 'password' ? 'text' : 'password';
            confirmInput.type = type;
            this.querySelector('svg').innerHTML = type === 'password'
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 012.754-3.8M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"></path>';
        });
    }
</script>
@endpush
@endsection