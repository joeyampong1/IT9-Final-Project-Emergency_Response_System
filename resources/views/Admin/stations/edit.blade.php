@extends('layouts.app')

@section('title', 'Edit Station')

@section('content')
        @include('layouts.page-header', ['title' => 'Edit Station: ' . $station->name])

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
            <form action="{{ route('admin.stations.update', $station) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                    <div class="space-y-5">
                        <div class="form-group">
                            <label class="form-label">Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $station->name) }}" required class="form-input rounded-lg">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Type <span class="text-red-500">*</span></label>
                            <select name="type" required class="form-select rounded-lg">
                                <option value="fire" {{ old('type', $station->type) == 'fire' ? 'selected' : '' }}>Fire Station</option>
                                <option value="police" {{ old('type', $station->type) == 'police' ? 'selected' : '' }}>Police Station</option>
                                <option value="medical" {{ old('type', $station->type) == 'medical' ? 'selected' : '' }}>Medical / Hospital</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" value="{{ old('address', $station->address) }}" class="form-input rounded-lg">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $station->phone) }}" class="form-input rounded-lg">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email (for alerts)</label>
                            <input type="email" name="email" value="{{ old('email', $station->email) }}" class="form-input rounded-lg" placeholder="station@example.com">
                            <p class="text-xs text-gray-500 mt-1">This email will receive emergency alerts.</p>
                        </div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label class="form-label">Station Location (Click on Map) <span class="text-red-500">*</span></label>
                            <div id="map" class="w-full rounded-xl border border-gray-300 shadow-sm"
                                 style="height: 300px; z-index: 1;"></div>
                            <p class="text-xs text-gray-500 mt-2">Click on the map to set the exact station location.</p>
                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div>
                                    <label class="form-label text-sm">Latitude</label>
                                    <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $station->latitude) }}" class="form-input bg-gray-100 rounded-lg" readonly>
                                </div>
                                <div>
                                    <label class="form-label text-sm">Longitude</label>
                                    <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $station->longitude) }}" class="form-input bg-gray-100 rounded-lg" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-8 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.stations.index') }}" class="btn btn-secondary w-full sm:w-auto px-6 py-2.5 rounded-lg text-center">Cancel</a>
                    <button type="submit" class="btn btn-primary w-full sm:w-auto px-6 py-2.5 rounded-lg shadow-md hover:shadow-lg transition">Update Station</button>
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
        var tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
        var attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
        
        var lat = {{ $station->latitude ?? 12.8797 }};
        var lng = {{ $station->longitude ?? 121.7740 }};
        var map = L.map('map').setView([lat, lng], defaultZoom);
        L.tileLayer(tileUrl, { attribution: attribution }).addTo(map);
        var marker = L.marker([lat, lng]).addTo(map);
        map.on('click', function(e) {
            marker.setLatLng([e.latlng.lat, e.latlng.lng]);
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        });
    });
</script>
@endpush
@endsection