@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Chat AI') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 h-[calc(100vh-180px)]"> {{-- Main container for overall height --}}
            <div class="flex flex-col lg:flex-row gap-6 h-full"> {{-- Flex container for two columns --}}

                {{-- Left Column (Chat Conversation - lg:w-7/12 for ~58% width) --}}
                <div class="lg:w-7/12 flex-grow h-full"> {{-- Ensures left column fills height --}}
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6 h-full flex flex-col border border-gray-200">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 border-b-2 pb-2">
                            <i class="fas fa-comments text-indigo-600 mr-2"></i> Percakapan AI
                        </h3>

                        <div class="flex-1 flex flex-col">
                            <label for="chat-input" class="sr-only">Mulai Obrolan dengan AI:</label>
                            <div id="chat-window" class="w-full bg-gray-100 p-4 rounded-lg shadow-inner flex-1 overflow-y-auto mb-4 border border-gray-200">
                                {{-- Loop through existing conversations --}}
                                @foreach($conversations as $conversation)
                                    <div class="mb-3 p-2 rounded-lg {{ $conversation->user_id == Auth::id() ? 'bg-blue-100 text-blue-800 ml-auto text-right' : 'bg-green-100 text-green-800 mr-auto' }} max-w-[80%] break-words">
                                        <p class="font-semibold">{{ $conversation->user_id == Auth::id() ? 'Anda' : 'AI' }}:</p>
                                        <p>{!! nl2br(e($conversation->user_message ?? $conversation->ai_response)) !!}</p>
                                    </div>
                                @endforeach
                            </div>
                            {{-- Chat Input Form - Styled as a card --}}
                            <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200">
                                <form id="chat-form" class="flex items-center space-x-3">
                                    @csrf
                                    <input id="message" name="message" type="text" class="flex-1 rounded-full shadow-inner border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 text-base" placeholder="Ketik pesan Anda di sini..." required />
                                    <button type="submit" class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-indigo-600 text-white shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <i class="fas fa-paper-plane text-xl"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column (Features and Tools - lg:w-5/12 for ~42% width) --}}
                <div class="lg:w-5/12 flex-shrink-0 flex flex-col gap-6 h-full overflow-y-auto pr-2 custom-scrollbar"> {{-- Added h-full and overflow-y-auto to this container --}}
                    {{-- Upload Document Section (Sticky Card) --}}
                    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white overflow-hidden shadow-xl sm:rounded-lg p-6 sticky top-0 z-10 border border-purple-700 transform hover:scale-105 transition-transform duration-300 ease-in-out">
                        <h4 class="text-xl font-bold mb-4 border-b border-white border-opacity-50 pb-2">
                            <i class="fas fa-cloud-upload-alt mr-2"></i> Unggah Dokumen
                        </h4>
                        <p class="text-sm text-white text-opacity-80 mb-4">
                            Unggah dokumen pribadi atau publik untuk dianalisis oleh AI.
                        </p>
                        <form id="upload-form" action="{{ route('core.ai.upload.document') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label for="document" class="block text-sm font-medium text-white">Pilih Dokumen (PDF, DOCX, TXT, maks 10MB):</label>
                                <input id="document" type="file" name="document" class="mt-1 block w-full text-sm text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-white file:text-purple-700 hover:file:bg-purple-100 cursor-pointer" required>
                            </div>
                            <div>
                                <label for="description" class="block text-sm font-medium text-white">Deskripsi Dokumen (Opsional):</label>
                                <textarea id="description" name="description" rows="2" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 bg-white bg-opacity-20 placeholder-white placeholder-opacity-70 text-white focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                            </div>
                            <div class="flex items-center">
                                <input id="is_public" type="checkbox" name="is_public" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <label for="is_public" class="ml-2 text-sm text-white">Jadikan Publik</label>
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-white text-purple-600 border border-transparent rounded-md font-bold text-xs uppercase tracking-widest hover:bg-gray-100 focus:bg-gray-100 active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-upload mr-2"></i> Unggah
                            </button>
                        </form>
                    </div>

                    {{-- Documents List Section --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h4 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-folder-open text-blue-600 mr-2"></i> Dokumen Saya
                        </h4>
                        @if($documents->isEmpty())
                            <p class="text-gray-600">Anda belum mengunggah dokumen apa pun.</p>
                        @else
                            <ul class="list-disc ml-5 space-y-2">
                                @foreach($documents as $doc)
                                    <li class="text-gray-700">
                                        <i class="fas fa-file-alt mr-2 text-blue-500"></i>
                                        {{ $doc->file_name }} ({{ $doc->is_public ? 'Publik' : 'Pribadi' }})
                                        @if($doc->description)
                                            <span class="text-sm text-gray-500 italic">- {{ $doc->description }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <h4 class="text-xl font-semibold text-gray-800 mt-8 mb-4 border-b pb-2">
                            <i class="fas fa-folder text-green-600 mr-2"></i> Dokumen Publik
                        </h4>
                        @if($publicDocuments->isEmpty())
                            <p class="text-gray-600">Belum ada dokumen publik yang tersedia.</p>
                        @else
                            <ul class="list-disc ml-5 space-y-2">
                                @foreach($publicDocuments as $doc)
                                    <li class="text-gray-700">
                                        <i class="fas fa-file-import mr-2 text-green-500"></i>
                                        {{ $doc->file_name }}
                                        @if($doc->description)
                                            <span class="text-sm text-gray-500 italic">- {{ $doc->description }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    {{-- AI Generation Features Section --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h4 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-cogs text-yellow-600 mr-2"></i> Fitur Generasi AI
                        </h4>

                        {{-- Generate Content Form --}}
                        <div class="mb-6">
                            <label for="generate-content-prompt-input" class="block text-lg font-medium text-gray-700 mb-2">Buat Dokumen (Soal, Ringkasan, Laporan):</label>
                            <form id="generate-content-form" action="{{ route('core.ai.generate.content') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="content_type" class="block text-sm font-medium text-gray-700">Jenis Konten:</label>
                                    <select id="content_type" name="type" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="question">Soal</option>
                                        <option value="summary">Ringkasan Materi</option>
                                        <option value="report">Laporan</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="generate-content-prompt-input" class="block text-sm font-medium text-gray-700">Berikan Perintah:</label>
                                    <textarea id="generate-content-prompt-input" name="prompt" rows="4" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Misal: 'Buatkan 5 soal pilihan ganda tentang Hukum Newton', atau 'Ringkas materi pelajaran fisika bab energi'"></textarea>
                                </div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class="fas fa-magic mr-2"></i> Hasilkan Konten
                                </button>
                            </form>
                        </div>

                        <div class="mb-6">
                            <label for="generate-visualization-desc-input" class="block text-lg font-medium text-gray-700 mb-2">Buat Visualisasi Data (Diagram, Statistik):</label>
                            <form id="generate-visualization-form" action="{{ route('core.ai.generate.visualization') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="viz_type" class="block text-sm font-medium text-gray-700">Jenis Visualisasi:</label>
                                    <select id="viz_type" name="type" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="diagram">Diagram</option>
                                        <option value="chart">Grafik</option>
                                        <option value="statistic">Statistik</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="generate-visualization-desc-input" class="block text-sm font-medium text-gray-700">Deskripsikan Data untuk Visualisasi:</label>
                                    <textarea id="generate-visualization-desc-input" name="data_description" rows="4" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Misal: 'Tampilkan grafik nilai rata-rata siswa per mata pelajaran', atau 'Buat diagram batang kehadiran siswa bulan ini'"></textarea>
                                </div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class="fas fa-chart-bar mr-2"></i> Hasilkan Visualisasi
                                </button>
                            </form>
                        </div>

                        <div>
                            <label for="query-database-question-input" class="block text-lg font-medium text-gray-700 mb-2">Tanya Database:</label>
                            <form id="query-database-form" action="{{ route('core.ai.query.database') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="query-database-question-input" class="block text-sm font-medium text-gray-700">Ajukan Pertanyaan:</label>
                                    <input id="query-database-question-input" name="question" type="text" class="block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Misal: 'Berapa nilai anak saya, [Nama Anak]?', atau 'Tampilkan daftar siswa yang sering terlambat'"/>
                                </div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 focus:bg-orange-700 active:bg-orange-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class="fas fa-database mr-2"></i> Tanya Database
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Future Features Section --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h4 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-lightbulb text-gray-600 mr-2"></i> Ide Fitur Masa Depan
                        </h4>
                        <ul class="list-disc ml-5 text-gray-700 space-y-2">
                            <li>
                                <span class="font-semibold">Analisis Kinerja Siswa Prediktif:</span> AI dapat menganalisis data nilai historis, kehadiran, dan interaksi untuk memprediksi potensi masalah akademik atau keberhasilan siswa di masa depan.
                            </li>
                            <li>
                                <span class="font-semibold">Personalisasi Pembelajaran:</span> Berdasarkan gaya belajar dan kinerja siswa, AI dapat merekomendasikan materi pembelajaran yang dipersonalisasi, soal latihan, atau jalur pembelajaran adaptif.
                            </li>
                            <li>
                                <span class="font-semibold">Deteksi Anomali Data:</span> AI dapat memantau data nilai, kehadiran, atau keuangan untuk mendeteksi pola yang tidak biasa atau potensi kecurangan.
                            </li>
                            <li>
                                <span class="font-semibold">Asisten Guru untuk Rencana Pelajaran:</span> AI dapat membantu guru membuat rencana pelajaran, ide aktivitas kelas, dan bahkan skenario penilaian.
                            </li>
                            <li>
                                <span class="font-semibold">Ringkasan Otomatis Komunikasi Orang Tua:</span> AI dapat meringkas pesan dan komunikasi antara sekolah dan orang tua, menyoroti poin-poin penting.
                            </li>
                            <li>
                                <span class="font-semibold">Pencarian Semantik Dokumen:</span> Selain pencarian kata kunci, AI dapat memahami makna pertanyaan untuk menemukan dokumen yang paling relevan.
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Fungsi untuk menampilkan pesan di chat window
        function appendMessage(sender, message, isUser) {
            const chatWindow = document.getElementById('chat-window');
            const messageElement = document.createElement('div');
            messageElement.classList.add('mb-3', 'p-2', 'rounded-lg', 'max-w-[80%]');

            if (isUser) {
                messageElement.classList.add('bg-blue-100', 'text-blue-800', 'ml-auto', 'text-right');
                messageElement.innerHTML = `<p class="font-semibold">Anda:</p><p>${message}</p>`;
            } else {
                messageElement.classList.add('bg-green-100', 'text-green-800', 'mr-auto');
                messageElement.innerHTML = `<p class="font-semibold">AI:</p><p>${message}</p>`;
            }
            chatWindow.appendChild(messageElement);
            chatWindow.scrollTop = chatWindow.scrollHeight; // Scroll ke bawah
        }

        // Chat Form Submission
        document.getElementById('chat-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const messageInput = document.getElementById('message');
            const message = messageInput.value;

            if (!message.trim()) return;

            appendMessage('You', message, true); // Tampilkan pesan pengguna
            messageInput.value = ''; // Kosongkan input

            try {
                const response = await fetch('{{ route('core.ai.chat') }}', { // Route 'core.ai.chat'
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ message: message })
                });

                const data = await response.json();
                if (response.ok) {
                    appendMessage('AI', data.message, false); // Tampilkan respons AI
                } else {
                    appendMessage('AI', `Error: ${data.message || 'Something went wrong.'}`, false);
                }
            } catch (error) {
                console.error('Error during chat:', error);
                appendMessage('AI', 'Maaf, terjadi kesalahan saat berkomunikasi dengan AI.', false);
            }
        });

        // Document Upload Form Submission
        document.getElementById('upload-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(e.target);

            try {
                const response = await fetch('{{ route('core.ai.upload.document') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                });

                const data = await response.json();
                if (response.ok) {
                    alert(data.message); // Gunakan alert() untuk notifikasi sederhana
                    location.reload(); // Reload halaman untuk menampilkan dokumen baru
                } else {
                    alert(`Error: ${data.message || 'Gagal mengunggah dokumen.'}`);
                }
            } catch (error) {
                console.error('Error during document upload:', error);
                alert('Terjadi kesalahan saat mengunggah dokumen.');
            }
        });

        // Generate Content Form Submission
        document.getElementById('generate-content-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const prompt = formData.get('prompt');
            const type = formData.get('type');

            appendMessage('You', `Tolong buatkan ${type}: "${prompt}"`, true);

            try {
                const response = await fetch('{{ route('core.ai.generate.content') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        type: type,
                        prompt: prompt,
                        conversation_id: getLastConversationId() // Opsional: kirim ID percakapan terakhir
                    })
                });

                const data = await response.json();
                if (response.ok) {
                    appendMessage('AI', `Konten (${type}) berhasil dibuat: ${data.generated_document.content}`, false);
                    alert(data.message);
                } else {
                    appendMessage('AI', `Error: ${data.message || 'Gagal menghasilkan konten.'}`, false);
                    alert(`Error: ${data.message || 'Gagal menghasilkan konten.'}`);
                }
            } catch (error) {
                console.error('Error generating content:', error);
                appendMessage('AI', 'Maaf, terjadi kesalahan saat menghasilkan konten.', false);
                alert('Terjadi kesalahan saat menghasilkan konten.');
            }
        });

        // Generate Visualization Form Submission
        document.getElementById('generate-visualization-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const dataDescription = formData.get('data_description');
            const type = formData.get('type');

            appendMessage('You', `Tolong buatkan visualisasi ${type} untuk data: "${dataDescription}"`, true);

            try {
                const response = await fetch('{{ route('core.ai.generate.visualization') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        type: type,
                        data_description: dataDescription,
                        conversation_id: getLastConversationId()
                    })
                });

                const data = await response.json();
                if (response.ok) {
                    appendMessage('AI', `Visualisasi (${type}) berhasil dibuat. Path gambar: ${data.visualization.image_path}. Deskripsi: ${data.visualization.description}`, false);
                    // Di sini Anda mungkin ingin menampilkan gambar visualisasi langsung
                    alert(data.message);
                } else {
                    appendMessage('AI', `Error: ${data.message || 'Gagal menghasilkan visualisasi.'}`, false);
                    alert(`Error: ${data.message || 'Gagal menghasilkan visualisasi.'}`);
                }
            } catch (error) {
                console.error('Error generating visualization:', error);
                appendMessage('AI', 'Maaf, terjadi kesalahan saat menghasilkan visualisasi.', false);
                alert('Terjadi kesalahan saat menghasilkan visualisasi.');
            }
        });

        // Query Database Form Submission
        document.getElementById('query-database-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const questionInput = document.getElementById('query-database-question-input');
            const question = questionInput.value;

            if (!question.trim()) return;

            appendMessage('You', `Tanya database: "${question}"`, true);
            questionInput.value = '';

            try {
                const response = await fetch('{{ route('core.ai.query.database') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        question: question,
                        conversation_id: getLastConversationId()
                    })
                });

                const data = await response.json();
                if (response.ok) {
                    appendMessage('AI', `Respons database: ${data.message}`, false);
                    alert(data.message);
                } else {
                    appendMessage('AI', `Error: ${data.message || 'Gagal query database.'}`, false);
                    alert(`Error: ${data.message || 'Gagal query database.'}`);
                }
            } catch (error) {
                console.error('Error querying database:', error);
                appendMessage('AI', 'Maaf, terjadi kesalahan saat bertanya ke database.', false);
                alert('Terjadi kesalahan saat bertanya ke database.');
            }
        });

        // Helper untuk mendapatkan ID percakapan terakhir jika ada
        function getLastConversationId() {
            // Ini akan memerlukan penyesuaian jika Anda menyimpan ID percakapan di frontend
            // Untuk saat ini, asumsikan kita selalu membuat percakapan baru atau tidak ada konteks
            return null; // Atau ambil dari elemen di DOM jika ada
        }
    </script>
@endpush