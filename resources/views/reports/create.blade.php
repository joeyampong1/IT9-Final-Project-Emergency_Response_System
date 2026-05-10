@extends('layouts.app')

@section('title', 'Submit Report')

@section('content')
        @include('layouts.page-header', ['title' => 'Submit an Emergency Report'])

        <div class="container-custom max-w-5xl mx-auto px-4 mt-6">
            @if($errors->any())
                <div class="alert alert-error mb-6">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" id="reportForm">
                @csrf

                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="bg-red-600 h-1.5 w-full"></div>
                    <div class="p-4 sm:p-6 md:p-8">

                        {{-- TWO-COLUMN GRID --}}
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8 items-start">
                            {{-- LEFT COLUMN --}}
                            <div class="space-y-5">
                                <!-- Type -->
                                <div class="form-group">
                                    <label class="form-label">Type <span class="text-red-500">*</span></label>
                                    <select name="type" required class="form-select rounded-lg">
                                        <option value="">Select type</option>
                                        <option value="accident" {{ old('type') == 'accident' ? 'selected' : '' }}>Medical Team</option>
                                        <option value="fire" {{ old('type') == 'fire' ? 'selected' : '' }}>Fire Team</option>
                                        <option value="crime" {{ old('type') == 'crime' ? 'selected' : '' }}>Crime Team</option>
                                    </select>
                                </div>

                                <!-- Title -->
                                <div class="form-group">
                                    <label class="form-label">Title <span class="text-red-500">*</span></label>
                                    <input type="text" name="title" value="{{ old('title') }}" required class="form-input rounded-lg">
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label class="form-label">Description <span class="text-red-500">*</span></label>
                                    <textarea name="description" rows="4" required class="form-textarea rounded-lg">{{ old('description') }}</textarea>
                                </div>

                                <!-- Location -->
                                <div class="form-group">
                                    <label class="form-label">Location Details (Street/Barangay) <span class="text-red-500">*</span></label>
                                    <input type="text" name="location" value="{{ old('location') }}" required class="form-input rounded-lg">
                                    <p class="text-xs text-gray-500 mt-1">Provide a descriptive address to help responders find the location quickly.</p>
                                </div>

                                <!-- Attachments (working as before) -->
                                <div class="form-group">
                                    <label class="form-label">Attachments (photos/videos)</label>
                                    <div class="relative inline-block w-full sm:w-auto">
                                        <button type="button" id="addFileBtn" class="btn btn-secondary text-sm py-2 px-4 rounded-lg flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Add Photo/Video
                                        </button>
                                        <input type="file" name="attachments[]" id="attachments" multiple accept="image/*,video/*"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    </div>
                                    <span class="text-xs text-gray-500 ml-2">Select multiple files at once (hold Ctrl/Cmd). Max 5 files, 20MB each.</span>
                                    <div id="previewContainer" class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-3"></div>
                                    <p class="text-xs text-red-500 mt-2">⚠️ Maximum 5 files, each up to 20MB.</p>
                                </div>
                            </div> {{-- end left column --}}

                            {{-- RIGHT COLUMN: Map --}}
                            <div>
                                <div class="bg-gray-50 rounded-xl p-4 sm:p-5 h-full">
                                    <label class="form-label block">Pin Location on Map <span class="text-red-500">*</span></label>
                                    <div id="map" class="rounded-xl border border-gray-300 shadow-sm" style="height: 400px; width: 100%; z-index: 1;"></div>
                                    <p class="text-xs text-gray-500 mt-3">Click on the map to set the exact location. This helps responders pinpoint the emergency.</p>
                                    <div class="grid grid-cols-2 gap-4 mt-4">
                                        <div>
                                            <label class="form-label text-sm">Latitude</label>
                                            <input type="text" name="latitude" id="latitude" class="form-input bg-gray-100 rounded-lg" readonly required>
                                        </div>
                                        <div>
                                            <label class="form-label text-sm">Longitude</label>
                                            <input type="text" name="longitude" id="longitude" class="form-input bg-gray-100 rounded-lg" readonly required>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div> 

                        {{-- BUTTONS (outside grid, inside card) --}}
                        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                            <a href="{{ route('reports.index') }}" class="btn btn-secondary w-full sm:w-auto px-5 py-2 rounded-lg text-center text-sm font-medium">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary w-full sm:w-auto px-6 py-2 rounded-lg shadow-md hover:shadow-lg transition text-sm font-medium">
                                Submit Report
                            </button>
                        </div>

                    </div> 
                </div> 
            </form>
        </div>

@push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ==================== MAP CODE ====================
            var defaultZoom = {{ setting('map_zoom', 13) }};
            var mapStyle = '{{ setting('map_style', 'street') }}';
            var tileLayers = {
                street: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                satellite: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
                terrain: 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png'
            };
            var attributions = {
                street: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                satellite: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
                terrain: '&copy; <a href="https://opentopomap.org">OpenTopoMap</a>'
            };
            var tileUrl = tileLayers[mapStyle] || tileLayers.street;
            var attribution = attributions[mapStyle] || attributions.street;
            var defaultLat = 12.8797;
            var defaultLng = 121.7740;
            var oldLat = "{{ old('latitude') }}";
            var oldLng = "{{ old('longitude') }}";
            var initialLat = (oldLat && oldLat !== "") ? parseFloat(oldLat) : defaultLat;
            var initialLng = (oldLng && oldLng !== "") ? parseFloat(oldLng) : defaultLng;
            var map = L.map('map').setView([initialLat, initialLng], defaultZoom);
            L.tileLayer(tileUrl, { attribution: attribution }).addTo(map);
            var marker;
            if (oldLat && oldLng) {
                marker = L.marker([initialLat, initialLng]).addTo(map);
                document.getElementById('latitude').value = initialLat;
                document.getElementById('longitude').value = initialLng;
            }
            function setLocation(lat, lng) {
                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng]).addTo(map);
                }
                map.setView([lat, lng], map.getZoom());
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
            }
            if (navigator.geolocation && !(oldLat && oldLng)) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        setLocation(position.coords.latitude, position.coords.longitude);
                    },
                    function(error) {
                        var mapContainer = document.getElementById('map').parentNode;
                        var hint = document.createElement('p');
                        hint.className = 'text-xs text-amber-600 mt-2';
                        hint.innerText = '⚠️ Could not detect your location automatically. Click the "📍" button on the map to set your location.';
                        if (!mapContainer.querySelector('.location-hint')) {
                            hint.classList.add('location-hint');
                            mapContainer.appendChild(hint);
                        }
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );
            }
            map.on('click', function(e) {
                setLocation(e.latlng.lat, e.latlng.lng);
            });
            var locateControl = L.Control.extend({
                options: { position: 'topleft' },
                onAdd: function(map) {
                    var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
                    container.innerHTML = '<a href="#" title="Use my current location" style="background:white; display:block; width:30px; height:30px; text-align:center; line-height:30px; font-size:18px; cursor:pointer;">📍</a>';
                    container.onclick = function() {
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(
                                function(pos) { setLocation(pos.coords.latitude, pos.coords.longitude); },
                                function() { alert("Unable to get your location."); }
                            );
                        } else {
                            alert("Geolocation not supported.");
                        }
                        return false;
                    };
                    return container;
                }
            });
            map.addControl(new locateControl());

            // ==================== ATTACHMENT UPLOAD WITH PREVIEW (Reliable) ====================
            // Uses a native file input that is visually hidden (opacity:0, absolute positioning)
            // over a custom button. The browser handles selection and submission natively.
            (function() {
                const fileInput = document.getElementById('attachments');
                const addBtn = document.getElementById('addFileBtn');
                const previewContainer = document.getElementById('previewContainer');
                
                if (!fileInput || !addBtn) return;
                
                // Position the file input absolutely on top of the button
                fileInput.style.position = 'absolute';
                fileInput.style.top = '0';
                fileInput.style.left = '0';
                fileInput.style.width = '100%';
                fileInput.style.height = '100%';
                fileInput.style.opacity = '0';
                fileInput.style.cursor = 'pointer';
                fileInput.style.zIndex = '2';
                
                // Make the button's container relatively positioned so the absolute input stays inside
                const btnContainer = addBtn.parentNode;
                btnContainer.style.position = 'relative';
                btnContainer.style.display = 'inline-block';
                btnContainer.style.overflow = 'hidden';
                
                // Move the file input into the button container
                btnContainer.appendChild(fileInput);
                
                let selectedFiles = []; // For preview only, not for upload
                
                function renderPreviews() {
                    previewContainer.innerHTML = '';
                    if (selectedFiles.length === 0) return;
                    selectedFiles.forEach((file, idx) => {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'relative border rounded-lg overflow-hidden bg-gray-100 shadow-sm';
                        if (file.type.startsWith('image/')) {
                            const img = document.createElement('img');
                            img.className = 'w-full h-32 object-cover';
                            img.src = URL.createObjectURL(file);
                            img.onload = () => URL.revokeObjectURL(img.src);
                            wrapper.appendChild(img);
                        } else if (file.type.startsWith('video/')) {
                            const video = document.createElement('video');
                            video.className = 'w-full h-32 object-cover';
                            video.controls = false;
                            video.muted = true;
                            video.src = URL.createObjectURL(file);
                            video.onload = () => URL.revokeObjectURL(video.src);
                            wrapper.appendChild(video);
                        } else {
                            const div = document.createElement('div');
                            div.className = 'w-full h-32 flex items-center justify-center bg-gray-200 text-gray-500 text-xs text-center p-2';
                            div.innerText = file.name;
                            wrapper.appendChild(div);
                        }
                        // Remove button for preview only – does NOT affect actual file input
                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.className = 'absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 text-xs font-bold hover:bg-red-800 z-10';
                        removeBtn.innerText = '✕';
                        removeBtn.onclick = (function(index) {
                            return function(e) {
                                e.stopPropagation();
                                selectedFiles.splice(index, 1);
                                updatePreviewFromInput();
                                renderPreviews();
                            };
                        })(idx);
                        wrapper.appendChild(removeBtn);
                        previewContainer.appendChild(wrapper);
                    });
                }
                
                function updatePreviewFromInput() {
                    // Get actual files from the file input (not from tempFiles)
                    const files = Array.from(fileInput.files);
                    selectedFiles = files.slice(0, 5); // Limit to 5
                    renderPreviews();
                }
                
                // Event handler when user selects files
                fileInput.addEventListener('change', function(e) {
                    const files = Array.from(e.target.files);
                    if (files.length > 5) {
                        alert('Maximum 5 files only.');
                        fileInput.value = ''; // Reset
                        selectedFiles = [];
                        renderPreviews();
                        return;
                    }
                    selectedFiles = files;
                    renderPreviews();
                });
                
                // Load existing files if any (e.g., after validation error)
                if (fileInput.files.length > 0) {
                    selectedFiles = Array.from(fileInput.files);
                    renderPreviews();
                }
            })();
        });
    </script>
    @endpush
@endsection