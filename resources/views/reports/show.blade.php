@extends('layouts.app')

@section('title', 'Report #'.$report->id)

@section('content')
        @include('layouts.page-header', ['title' => 'Report #' . $report->id])

<div class="container-custom max-w-4xl mx-auto px-4 mt-6">
    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-red-600 h-1.5 w-full"></div>
        <div class="p-5 sm:p-6 md:p-8">
            {{-- Header with back button --}}
            <div class="flex justify-end mb-6">
                <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-1 text-gray-500 hover:text-red-600 transition text-sm sm:text-base">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to My Reports
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 md:gap-6 mb-8">
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Type</p>
                        <p class="text-gray-800 font-medium capitalize">{{ $report->type }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Title</p>
                        <p class="text-gray-800 font-medium">{{ $report->title }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Location</p>
                        <p class="text-gray-800 font-medium">{{ $report->location }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Status</p>
                        <span class="badge 
                            @if($report->status == 'pending') badge-pending
                            @elseif($report->status == 'verifying') badge-verifying
                            @elseif($report->status == 'responding') badge-responding
                            @elseif($report->status == 'resolved') badge-resolved
                            @else badge-rejected
                            @endif text-sm px-3 py-1">
                            {{ ucfirst($report->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</p>
                        <p class="text-gray-800 font-medium">{{ $report->created_at->format('F d, Y \a\t h:i A') }}</p>
                    </div>
                </div>
            </div>

            <div class="mb-8 bg-gray-50 rounded-xl p-4 sm:p-5">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Description</p>
                <p class="text-gray-700 whitespace-pre-wrap text-sm sm:text-base">{{ $report->description }}</p>
            </div>

            @if($report->attachments->count())
                <div class="mb-8">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                        Attachments
                    </h3>
                    <div class="attachments-grid">
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
                                            <span class="text-xs sm:text-sm text-gray-500">{{ $update->created_at->format('M d, Y \a\t h:i A') }}</span>
                                        </div>
                                        @if($update->notes)
                                            <span class="text-xs text-gray-400">Note added</span>
                                        @endif
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

<div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/90 backdrop-blur-sm" onclick="closeLightbox()">
    <img id="lightbox-img" class="max-w-[90vw] max-h-[90vh] object-contain rounded-lg shadow-2xl" src="" alt="Full size image">
    <button class="absolute top-4 right-4 text-white text-4xl font-bold hover:text-gray-300 transition" onclick="closeLightbox()">&times;</button>
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