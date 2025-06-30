/**
 * File JavaScript Utama Aplikasi.
 * * File ini mengimpor semua dependensi yang diperlukan, termasuk Bootstrap, Alpine,
 * dan kini juga library serta logika untuk Peta Statistik.
 */

// Impor bootstrap default Laravel
import './bootstrap';

// Impor Alpine.js untuk komponen interaktif
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// == Integrasi Peta Leaflet ==

// 1. Impor library CSS dan JS yang diperlukan dari node_modules
import 'leaflet/dist/leaflet.css';
import 'leaflet.markercluster/dist/MarkerCluster.css';
import 'leaflet.markercluster/dist/MarkerCluster.Default.css';

import L from 'leaflet';
import 'leaflet.markercluster';
import 'leaflet.heat';


// 2. Logika Peta Geografis
// Skrip ini akan berjalan setelah seluruh halaman dimuat.
document.addEventListener('DOMContentLoaded', function () {

    // Cek apakah elemen peta ada di halaman saat ini untuk menghindari error
    const interactiveMapEl = document.getElementById('map-interactive');
    const bannerMapEl = document.getElementById('map-banner');

    // Hanya jalankan kode jika kedua elemen peta ditemukan
    if (interactiveMapEl && bannerMapEl) {
        
        // --- INISIALISASI PETA BANNER (STATIS) ---
        const bannerMap = L.map('map-banner', {
            center: [-2.5, 118.0],
            zoom: 4.5,
            zoomControl: false,
            dragging: false,
            scrollWheelZoom: false,
            touchZoom: false,
            doubleClickZoom: false,
        });
        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png').addTo(bannerMap);

        // --- INISIALISASI PETA INTERAKTIF ---
        const interactiveMap = L.map('map-interactive').setView([-2.548926, 118.0148634], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(interactiveMap);

        // Layer untuk data
        const schoolLayer = L.markerClusterGroup().addTo(interactiveMap);
        let studentHeatLayer = null;
        const loadingIndicator = document.getElementById('loading-indicator');
        const schoolCountEl = document.getElementById('school-count');
        const studentCountEl = document.getElementById('student-count');

        // Fungsi untuk memuat data sekolah
        function loadSchoolData() {
            fetch("{{ route('api.statistics.schools.data') }}")
                .then(response => response.json())
                .then(data => {
                    schoolLayer.clearLayers();
                    const geoJsonLayer = L.geoJSON(data, {
                        onEachFeature: function (feature, layer) {
                            layer.bindPopup(`<b>${feature.properties.name}</b><br>Estimasi: ${feature.properties.student_count} siswa`);
                        }
                    });
                    schoolLayer.addLayer(geoJsonLayer);
                    if (schoolCountEl) {
                        schoolCountEl.textContent = data.features.length;
                    }
                })
                .catch(error => console.error('Gagal memuat data sekolah:', error));
        }

        // Fungsi untuk memuat heatmap siswa
        function loadStudentData() {
            if(loadingIndicator) loadingIndicator.classList.remove('hidden');
            if (studentHeatLayer) interactiveMap.removeLayer(studentHeatLayer);

            const params = new URLSearchParams(new FormData(document.getElementById('map-filters-form'))).toString();
            
            fetch(`{{ route('api.statistics.students.data') }}?${params}`)
                .then(response => response.json())
                .then(data => {
                    const heatPoints = data.map(p => [p.latitude, p.longitude, 0.9]);
                    if (heatPoints.length > 0) {
                        studentHeatLayer = L.heatLayer(heatPoints, { radius: 25, blur: 20 }).addTo(interactiveMap);
                    }
                    if (studentCountEl) {
                        studentCountEl.textContent = heatPoints.length;
                    }
                })
                .catch(error => console.error('Gagal memuat data siswa:', error))
                .finally(() => {
                    if(loadingIndicator) loadingIndicator.classList.add('hidden');
                });
        }

        // Event listener untuk form filter
        document.getElementById('map-filters-form').addEventListener('submit', function(event) {
            event.preventDefault();
            loadStudentData();
        });

        // Memuat data awal
        loadSchoolData();
        loadStudentData();
    }
});
