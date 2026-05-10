@extends('layouts.app')

@section('title', 'Create Station')

@section('content')
        @include('layouts.page-header', ['title' => 'Create New Station'])


<div class="container-custom max-w-6xl mx-auto px-4 mt-6">
    @if($errors->any())
        <div class="alert alert-error mb-6">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-red-600 h-1.5 w-full"></div>
        <div class="p-4 sm:p-6 md:p-8">
            <form action="{{ route('admin.stations.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                    {{-- Left column: fields --}}
                    <div class="space-y-5">
                        <div class="form-group">
                            <label class="form-label">Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="form-input rounded-lg">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Type <span class="text-red-500">*</span></label>
                            <select name="type" required class="form-select rounded-lg">
                                <option value="">Select type</option>
                                <option value="fire" {{ old('type') == 'fire' ? 'selected' : '' }}>Fire Station</option>
                                <option value="police" {{ old('type') == 'police' ? 'selected' : '' }}>Police Station</option>
                                <option value="medical" {{ old('type') == 'medical' ? 'selected' : '' }}>Medical / Hospital</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" value="{{ old('address') }}" class="form-input rounded-lg">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-input rounded-lg">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email (for alerts)</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-input rounded-lg" placeholder="station@example.com">
                            <p class="text-xs text-gray-500 mt-1">This email will receive emergency alerts.</p>
                        </div>
                    </div>

                    {{-- Right column: map (responsive height) --}}
                    <div>
                        <div class="form-group">
                            <label class="form-label">Station Location (Click on Map) <span class="text-red-500">*</span></label>
                            <div id="map" class="w-full rounded-xl border border-gray-300 shadow-sm"
                                 style="height: 500px; z-index: 1;"></div>
                            <p class="text-xs text-gray-500 mt-2">Click on the map to set the exact station location. (📍 button to use your current location)</p>
                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div>
                                    <label class="form-label text-sm">Latitude</label>
                                    <input type="text" name="latitude" id="latitude" class="form-input bg-gray-100 rounded-lg" readonly>
                                </div>
                                <div>
                                    <label class="form-label text-sm">Longitude</label>
                                    <input type="text" name="longitude" id="longitude" class="form-input bg-gray-100 rounded-lg" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-8 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.stations.index') }}" class="btn btn-secondary w-full sm:w-auto px-6 py-2.5 rounded-lg text-center">Cancel</a>
                    <button type="submit" class="btn btn-primary w-full sm:w-auto px-6 py-2.5 rounded-lg shadow-md hover:shadow-lg transition">Create Station</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
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

        var defaultLat = 12.8797, defaultLng = 121.7740;
        var oldLat = "{{ old('latitude') }}", oldLng = "{{ old('longitude') }}";
        var initialLat = (oldLat && oldLat !== "") ? parseFloat(oldLat) : defaultLat;
        var initialLng = (oldLng && oldLng !== "") ? parseFloat(oldLng) : defaultLng;

        // ✅ Enable zoom via touchpad/mouse wheel (removed scrollWheelZoom: false)
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
                            function(pos) {
                                setLocation(pos.coords.latitude, pos.coords.longitude);
                            },
                            function() {
                                alert("Unable to get your location. Please check your browser permissions.");
                            },
                            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                        );
                    } else {
                        alert("Geolocation is not supported by your browser.");
                    }
                    return false;
                };
                return container;
            }
        });
        map.addControl(new locateControl());

        window.addEventListener('resize', function () {
            map.invalidateSize();
        });
    });
</script>
@endpush
@endsection