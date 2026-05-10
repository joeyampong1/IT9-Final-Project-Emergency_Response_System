@extends('layouts.app')

@section('title', 'Report #'.$report->id)

@section('content')
        @include('layouts.page-header', ['title' => 'Report #' . $report->id])

<div class="container-custom max-w-5xl mx-auto px-4 mt-4 sm:mt-6">
    {{-- Success / Error messages --}}
    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error mb-6">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-red-600 h-1.5 w-full"></div>
        <div class="p-4 sm:p-6 md:p-8">
            {{-- Header row with back button --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                <div>
                    <p class="text-xs text-gray-500">Report ID</p>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">#{{ $report->id }}</h2>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <span class="badge 
                        @if($report->status == 'pending') badge-pending
                        @elseif($report->status == 'verifying') badge-verifying
                        @elseif($report->status == 'responding') badge-responding
                        @elseif($report->status == 'resolved') badge-resolved
                        @else badge-rejected
                        @endif text-sm px-3 py-1">
                        {{ ucfirst($report->status) }}
                    </span>
                    <a href="{{ $returnUrl ?? route('admin.dashboard') }}" class="text-gray-500 hover:text-red-600 transition flex items-center gap-1 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Dashboard
                    </a>
                </div>
            </div>

            {{-- Two‑column info grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6 mb-8">
                <div class="space-y-3">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Citizen</p>
                        <p class="text-gray-800 font-medium">{{ $report->reporter->name ?? 'Unknown' }}</p>
                        <p class="text-sm text-gray-500">{{ $report->reporter->email ?? '' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Type</p>
                        <p class="text-gray-800 font-medium capitalize">{{ $report->type }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Title</p>
                        <p class="text-gray-800 font-medium">{{ $report->title }}</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Location</p>
                        <p class="text-gray-800 font-medium">{{ $report->location }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</p>
                        <p class="text-gray-800 font-medium">{{ $report->created_at->format('F d, Y \a\t h:i A') }}</p>
                    </div>
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-8 bg-gray-50 rounded-xl p-4 sm:p-5">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Description</p>
                <p class="text-gray-700 whitespace-pre-wrap text-sm sm:text-base">{{ $report->description }}</p>
            </div>

            {{-- Attachments with lightbox (responsive grid) --}}
            @if($report->attachments->count())
                <div class="mb-8">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                        Attachments
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($report->attachments as $attachment)
                            <div class="attachment cursor-pointer transition hover:opacity-80" @if($attachment->file_type == 'image') onclick="openLightbox('{{ asset('storage/' . $attachment->file_path) }}')" @endif>
                                @if($attachment->file_type == 'image')
                                    <img src="{{ asset('storage/' . $attachment->file_path) }}" alt="Attachment" class="w-full h-32 object-cover">
                                @else
                                    <video controls class="w-full h-32 object-cover">
                                        <source src="{{ asset('storage/' . $attachment->file_path) }}" type="video/mp4">
                                    </video>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Update form --}}
            <div class="mb-8 border-t border-gray-100 pt-8">
                <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Update Report
                </h3>
                <form action="{{ route('admin.reports.update', $report) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="return_url" value="{{ $returnUrl ?? route('admin.dashboard') }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="form-group">
                            <label for="status" class="form-label">Status *</label>
                            <select name="status" id="status" required class="form-select rounded-lg">
                                <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="verifying" {{ $report->status == 'verifying' ? 'selected' : '' }}>Verifying</option>
                                <option value="responding" {{ $report->status == 'responding' ? 'selected' : '' }}>Responding</option>
                                <option value="resolved" {{ $report->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="rejected" {{ $report->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="assigned_to" class="form-label">Assign to (responder)</label>
                            <select name="assigned_to" id="assigned_to" class="form-select rounded-lg">
                                <option value="">Unassigned</option>
                                @foreach(\App\Models\User::where('role', 'admin')->get() as $user)
                                    <option value="{{ $user->id }}" {{ $report->assigned_to == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="verification_status" class="form-label">Verification Status *</label>
                        <select name="verification_status" id="verification_status" required class="form-select rounded-lg">
                            <option value="unverified" {{ $report->verification_status == 'unverified' ? 'selected' : '' }}>Unverified</option>
                            <option value="legit" {{ $report->verification_status == 'legit' ? 'selected' : '' }}>Legit ✅</option>
                            <option value="scam" {{ $report->verification_status == 'scam' ? 'selected' : '' }}>Scam ⚠️</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="notes" class="form-label">Admin Notes (optional)</label>
                        <textarea name="notes" id="notes" rows="3" class="form-textarea rounded-lg">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end gap-3 mt-2">
                        <button type="submit" class="btn btn-primary w-full sm:w-auto px-6 py-2.5 rounded-lg shadow-md hover:shadow-lg transition">Update Report</button>
                    </div>
                </form>
            </div>

            {{-- Timeline (responsive) --}}
            @if($report->updates->count())
                <div class="border-t border-gray-100 pt-8">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-5 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Timeline
                    </h3>
                    <div class="space-y-4">
                        @foreach($report->updates as $update)
                            <div class="flex gap-4">
                                <div class="flex-shrink-0 w-2 h-2 mt-2 rounded-full 
                                    @if($update->status == 'pending') bg-yellow-500
                                    @elseif($update->status == 'verifying') bg-blue-500
                                    @elseif($update->status == 'responding') bg-indigo-500
                                    @elseif($update->status == 'resolved') bg-green-500
                                    @else bg-red-500
                                    @endif">
                                </div>
                                <div class="flex-1">
                                    <div class="flex flex-wrap items-baseline justify-between gap-2">
                                        <div class="flex items-center gap-2">
                                            <span class="badge 
                                                @if($update->status == 'pending') badge-pending
                                                @elseif($update->status == 'verifying') badge-verifying
                                                @elseif($update->status == 'responding') badge-responding
                                                @elseif($update->status == 'resolved') badge-resolved
                                                @else badge-rejected
                                                @endif">
                                                {{ ucfirst($update->status) }}
                                            </span>
                                            <span class="text-xs text-gray-500">{{ $update->created_at->format('M d, Y \a\t h:i A') }}</span>
                                        </div>
                                        <span class="text-xs text-gray-400">by {{ $update->user->name ?? 'System' }}</span>
                                    </div>
                                    @if($update->notes)
                                        <p class="mt-1 text-gray-600 text-sm">{{ $update->notes }}</p>
                                    @endif
                                </div>
                            </div>
                            @if(!$loop->last)
                                <div class="border-l-2 border-gray-100 ml-1 h-2"></div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Lightbox Modal with larger close button on mobile --}}
<div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/90 backdrop-blur-sm" onclick="closeLightbox()">
    <img id="lightbox-img" class="max-w-[90vw] max-h-[90vh] object-contain rounded-lg shadow-2xl" src="" alt="Full size image">
    <button class="absolute top-4 right-4 text-white text-3xl sm:text-4xl font-bold hover:text-gray-300 transition p-2" onclick="closeLightbox()">&times;</button>
</div>

@push('scripts')
<script>
    function openLightbox(imageUrl) {
        const lightbox = document.getElementById('lightbox');
        const img = document.getElementById('lightbox-img');
        img.src = imageUrl;
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.add('hidden');
        lightbox.classList.remove('flex');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const lightbox = document.getElementById('lightbox');
            if (lightbox && !lightbox.classList.contains('hidden')) {
                closeLightbox();
            }
        }
    });
</script>
@endpush
@endsection