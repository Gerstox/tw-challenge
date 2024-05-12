@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="">
                <div class="fs-3 text-center fw-bold mt-2 text-primary">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <h2 class="mt-4 text-primary fw-bold">Ubicación</h2>
                <form method="POST" action="{{ route('location.save') }}">
                    @csrf
                    <div class="form-group">
                        <label for="latitude">Latitud</label>
                        <input 
                        type="text" 
                        class="form-control" 
                        name="latitude" 
                        id="latitude" 
                        readonly 
                        aria-describedby="latitudeHelp"
                        value="{{ Auth::user()->location ? Auth::user()->location->latitude : 0 }}"
                        >
                    </div>
                    <div class="form-group">
                        <label for="longitude">Longitud</label>
                        <input 
                        type="text" 
                        class="form-control"  
                        name="longitude" 
                        id="longitude" 
                        readonly 
                        aria-describedby="longitudeHelp"
                        value="{{ Auth::user()->location ? Auth::user()->location->longitude : 0 }}"
                        >
                    </div>
                    <input 
                        type="hidden" 
                        name="user_id" 
                        value="{{ Auth::user()->id }}"
                        >
                    <button type="submit" class="btn btn-primary mt-4 w-100 fw-bold">Guardar</button>
                </form>
            </div>
            <div class="col-md-10">
                <div id="mapid" class="center-block mt-4" style="width: 100%; height: 600px;"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        let userLatitude = document.getElementById('latitude');
        let userLongitude = document.getElementById('longitude');
        let coords = new L.LatLng('53.413764', '-6.387348');
        let userName = "{{Auth::user()->name}}";
        if (userLatitude.value !== '0' && userLongitude.value !== '0') {
            coords = new L.LatLng(userLatitude.value, userLongitude.value);
        }

        let map = L.map('mapid');

        let icon = new L.Icon();
        icon.options.shadowSize = [0,0];
        icon.options.iconSize = [20, 40];
        icon.options.iconAnchor = [10, 70];
        icon.options.iconUrl = "{{asset('images/vendor/leaflet/dist/marker-icon.png')}}";
        L.tileLayer(`{{ config('mapbox.url', 'MAPBOX_URL') }}{{ config('mapbox.token', 'MAPBOX_TOKEN') }}`, {
            attribution: 'Map data © <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
        }).addTo(map);

         map.setView(coords, 13); 

        let marker = new L.Marker(coords);

        map.addLayer(marker);
        marker.bindPopup(`<b>Estas aquí!</b><br />${userName}.`).openPopup();


        function onMapClick(e) {

            if (marker != undefined) {
                map.removeLayer(marker);
            };
            userLatitude.value = e.latlng.lat.toFixed(4);
            userLongitude.value = e.latlng.lng.toFixed(4);
            marker = new L.Marker(e.latlng);
            map.addLayer(marker);
            marker.bindPopup(`<b>Estas aquí!</b><br />${userName}.`).openPopup();
        }

        map.on('click', onMapClick);

    </script>
@endpush
