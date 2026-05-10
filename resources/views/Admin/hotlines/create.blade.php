@extends('layouts.app')

@section('title', 'Add Hotline')

@section('content')
        @include('layouts.page-header', ['title' => 'Add Hotline'])

<div class="container-custom max-w-2xl mx-auto px-4 mt-6">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-red-600 h-1.5 w-full"></div>
        <div class="p-5 sm:p-6">
            <form action="{{ route('admin.hotlines.store') }}" method="POST">
                @csrf
                <div class="space-y-5">
                    <div class="form-group">
                        <label class="form-label">Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" class="form-input rounded-lg" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Number <span class="text-red-500">*</span></label>
                        <input type="text" name="number" class="form-input rounded-lg" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Icon (e.g., police, fire, medical)</label>
                        <input type="text" name="icon" class="form-input rounded-lg" placeholder="police">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-input rounded-lg" value="0">
                    </div>
                </div>

                <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-8 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.hotlines.index') }}" class="btn btn-secondary w-full sm:w-auto px-6 py-2.5 rounded-lg text-center">Cancel</a>
                    <button type="submit" class="btn btn-primary w-full sm:w-auto px-6 py-2.5 rounded-lg shadow-md hover:shadow-lg transition">Create Hotline</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection