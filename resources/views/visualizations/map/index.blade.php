@extends('layouts.app')

{{-- Menyisipkan CSS Leaflet dan library tambahan --}}
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
    <style>
        /* Mengatur layout utama halaman */
        .map-container-grid {
            display: grid;
            grid-template-columns: 350px 1fr; /* Kolom kiri 350px, kolom kanan mengisi sisa */
            gap: 1.5rem; /* Jarak antar kolom */
            height: 85vh; /* Tinggi container utama */
        }
        
        /* Gaya untuk Peta */
        #map {
            width: 100%;
            height: 100%;
            border-radius: 0.75rem; /* rounded-xl */
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            z-index: 1;
        }

        /* Gaya untuk panel samping yang lebih harmonis */
        .sidebar-panel {
            background-color: #ffffff;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .dark .sidebar-panel {
            background-color: #1f2937; /* bg-gray-800 */
        }
        .sidebar-panel-body {
            overflow-y: auto;
            flex-grow: 1;
        }

        /* Ikon SVG Kustom dengan Animasi */
        .pulsing-icon {
            border-radius: 50%;
            box-shadow: 0 0 0 rgba(0, 128, 255, 0.7);
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.6); }
            70% { box-shadow: 0 0 0 12px rgba(59, 130, 246, 0); }
            100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
        }

        /* Lingkaran populasi dengan animasi breathing */
        .population-circle {
            animation: breathing 3s ease-in-out infinite alternate;
        }
        @keyframes breathing {
            from { opacity: 0.1; }
            to { opacity: 0.35; }
        }

        /* Styling untuk popup */
        .leaflet-popup-content-wrapper {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .dark .leaflet-popup-content-wrapper, .dark .leaflet-popup-tip {
            background: #2d3748; /* bg-gray-700 */
            color: #e2e8f0; /* text-gray-300 */
        }

        /* Scrollbar kustom */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #4a5568; }
    </style>
@endpush

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Dasbor Pemetaan Jaringan Sekolah
    </h2>
@endsection

@section('content')
<div class="py-6">
    <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
        <div class="map-container-grid">
            
           {{-- KOLOM KIRI: DAFTAR & INFO PANEL --}}
            <aside class="sidebar-panel bg-white dark:bg-slate-800 border border-blue-600 dark:border-blue-400 rounded-xl overflow-hidden shadow-lg">
                {{-- HEADER PANEL --}}
                <div class="p-6 bg-blue-600 dark:bg-blue-500 text-white">
                    <h3 class="text-lg font-semibold">📍 Daftar Lokasi Sekolah</h3>
                    <p class="text-sm mt-1 opacity-90">Klik nama sekolah untuk fokus ke peta.</p>
                </div>

                {{-- LIST SEKOLAH --}}
                <div id="school-list" class="sidebar-panel-body custom-scrollbar bg-white dark:bg-slate-800 text-gray-800 dark:text-gray-100">
                    {{-- Diisi oleh JavaScript --}}
                </div>

                {{-- INFO FOOTER --}}
                <div class="p-6 bg-sky-50 dark:bg-slate-700 border-t border-blue-100 dark:border-blue-500">
                    <h4 class="font-semibold text-blue-700 dark:text-blue-300">🌐 Informasi Jaringan</h4>
                    <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">Total Jarak Terhubung:</p>
                    <p id="total-distance" class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">0 km</p>
                </div>
            </aside>

            {{-- KOLOM KANAN: PETA --}}
            <main>
                <div id="map"></div>
            </main>

        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Memuat library JS dari CDN --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- DATA & KONFIGURASI ---
    const cityColors = {
        "Jakarta": "#ef4444", "Bandung": "#3b82f6", "Surabaya": "#22c55e",
        "Cirebon": "#8b5cf6", "Makassar": "#f97316", "Medan": "#a16207",
    };

    const schools = [
        { id: 1, name: "Al-Bahjah Pusat", city: "Cirebon", lat: -6.746, lng: 108.520, students: 1000 },
        { id: 2, name: "Al-Bahjah Jakarta", city: "Jakarta", lat: -6.229, lng: 106.81, students: 500 },
        { id: 3, name: "Al-Bahjah Surabaya", city: "Surabaya", lat: -7.29, lng: 112.73, students: 600 },
        { id: 4, name: "Al-Bahjah Bandung", city: "Bandung", lat: -6.921, lng: 107.607, students: 400 },
        { id: 5, name: "Al-Bahjah Medan", city: "Medan", lat: 3.58, lng: 98.67, students: 350 },
        { id: 6, name: "Al-Bahjah Makassar", city: "Makassar", lat: -5.135, lng: 119.423, students: 300 },
    ];

    // --- INISIALISASI PETA ---
    const lightMap = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="https://carto.com/attributions">CARTO</a>'
    });
    
    const darkMap = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="https://carto.com/attributions">CARTO</a>'
    });
    
    const map = L.map('map', {
        center: [-2.5, 118],
        zoom: 5,
        layers: [lightMap] // Peta default sekarang terang
    });

    const baseMaps = { "Terang": lightMap, "Gelap": darkMap };
    L.control.layers(baseMaps).addTo(map);

    const markers = L.markerClusterGroup();
    const schoolMarkers = {}; // Objek untuk menyimpan referensi marker

    // --- FUNGSI-FUNGSI BANTUAN ---
    const haversine = (lat1, lon1, lat2, lon2) => {
        const R = 6371; // Radius bumi dalam km
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLon / 2) * Math.sin(dLon / 2);
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    };

    const createIcon = (city, size = 32) => {
        const color = cityColors[city] || 'gray';
        const svg = `
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="${color}" width="${size}" height="${size}" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.4));">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                <circle cx="12" cy="9.5" r="3.5" fill="white" fill-opacity="0.5" class="pulsing-icon" />
            </svg>`;
        return L.divIcon({
            html: svg,
            className: '',
            iconSize: [size, size],
            iconAnchor: [size / 2, size],
        });
    };

    // --- PROSES UTAMA ---
    const schoolListContainer = document.getElementById('school-list');
    let totalDistance = 0;
    
    // 1. Render Daftar Sekolah di Sidebar
    schools.forEach(school => {
        const schoolDiv = document.createElement('div');
        schoolDiv.className = 'px-6 py-4 border-b border-gray-200 dark:border-gray-700 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700/50 transition duration-200';
        schoolDiv.innerHTML = `<h4 class="font-semibold text-gray-800 dark:text-gray-100">${school.name}</h4><p class="text-sm text-gray-500">${school.city}</p>`;
        
        schoolDiv.addEventListener('click', () => {
            map.flyTo([school.lat, school.lng], 14);
            schoolMarkers[school.id].openPopup();
        });
        
        schoolDiv.addEventListener('mouseenter', () => schoolMarkers[school.id].setIcon(createIcon(school.city, 48)));
        schoolDiv.addEventListener('mouseleave', () => schoolMarkers[school.id].setIcon(createIcon(school.city, 32)));
        
        schoolListContainer.appendChild(schoolDiv);
    });

    // 2. Render Marker dan Lingkaran di Peta
    const latlngs = schools.map((s, i) => {
        const marker = L.marker([s.lat, s.lng], { icon: createIcon(s.city, 32) })
            .bindPopup(`<b>${s.name}</b><br>${s.students} Siswa`);
        markers.addLayer(marker);
        schoolMarkers[s.id] = marker; // Simpan referensi

        L.circle([s.lat, s.lng], {
            color: cityColors[s.city], fillColor: cityColors[s.city],
            fillOpacity: 0.1, radius: s.students * 20, weight: 1,
            className: 'population-circle'
        }).addTo(map);

        if (i > 0) totalDistance += haversine(schools[i-1].lat, schools[i-1].lng, s.lat, s.lng);
        return [s.lat, s.lng];
    });

    map.addLayer(markers);

    // 3. Render Garis Penghubung
    const polyline = L.polyline(latlngs, { color: 'rgba(107, 114, 128, 0.5)', weight: 2, dashArray: '5, 5' }).addTo(map);
    map.fitBounds(markers.getBounds().pad(0.1));

    // 4. Update Tampilan Info
    document.getElementById('total-distance').textContent = `${totalDistance.toFixed(0)} km`;
});
</script>
@endpush