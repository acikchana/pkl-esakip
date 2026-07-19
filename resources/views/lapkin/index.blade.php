@extends('layouts.app')

@section('title', 'Laporan Kinerja (LAPKIN)')
@section('breadcrumb-parent', 'SAKIP Individu')
@section('breadcrumb-current', 'LAPKIN')

@push('head')
<link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css" rel="stylesheet">
<style>
    /* samain tinggi & tipografi editor Quill dengan textarea biasa */
    .ql-toolbar.ql-snow { border-color: #cbd5e1; border-radius: 0.5rem 0.5rem 0 0; background: #f8fafc; }
    .ql-container.ql-snow { border-color: #cbd5e1; border-radius: 0 0 0.5rem 0.5rem; font-size: 0.875rem; min-height: 140px; }
    .ql-editor.ql-blank::before { color: #94a3b8; font-style: normal; }
</style>
@endpush

@section('content')
<div x-data="lapkinForm()" x-init="initEditors()">

    {{-- ============ PAGE HEADER ============ --}}
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Laporan Kinerja (LAPKIN)</h1>
            <p class="text-sm text-slate-500 mt-1 max-w-xl">
                Isi realisasi capaian kinerja Anda pada periode berjalan. Data tugas & sasaran diambil otomatis dari IKI dan JAKIN.
            </p>
        </div>

        <div class="flex items-center gap-3 flex-shrink-0">
            <button
                type="button"
                @click="autoFill()"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg border border-blue-200 bg-blue-50 text-sm font-semibold text-blue-600 hover:bg-blue-100">
                <x-heroicon-o-sparkles class="w-4 h-4" />
                Auto-filled
            </button>
            <button
                type="button"
                @click="ajukanLaporan()"
                class="px-4 py-2.5 rounded-lg bg-slate-900 text-sm font-semibold text-white hover:bg-slate-800">
                Ajukan LAPKIN
            </button>
        </div>
    </div>

    {{-- ============ IDENTITAS LAPORAN ============ --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
        <h2 class="font-bold text-slate-800 mb-5">Identitas Laporan</h2>
        <div class="flex flex-nowrap gap-5">
            <div class="flex-[3]">
                <label class="block text-xs font-bold text-slate-600 mb-1.5">PEGAWAI</label>
                <input type="text" :value="pegawai.nama_lengkap" disabled
                    class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-800 bg-slate-50 disabled:text-slate-500">
            </div>
            <div class="flex-[2]">
                <label class="block text-xs font-bold text-slate-600 mb-1.5">NIP</label>
                <input type="text" :value="pegawai.nip" disabled
                    class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-800 bg-slate-50 disabled:text-slate-500">
            </div>
            <div class="flex-[2]">
                <label class="block text-xs font-bold text-slate-600 mb-1.5">PERIODE PELAPORAN (OPSIONAL)</label>
                <input type="text" x-model="periodePelaporan" placeholder="Pilih satu bulan"
                    class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400">
            </div>
            <div class="flex-[2]">
                <label class="block text-xs font-bold text-slate-600 mb-1.5">TAHUN KINERJA</label>
                <select x-model="tahunKinerja"
                    class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400">
                    <template x-for="tahun in tahunOptions" :key="tahun">
                        <option :value="tahun" x-text="tahun"></option>
                    </template>
                </select>
            </div>
        </div>
    </div>

    {{-- ============ ATASAN LANGSUNG ============ --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
        <h2 class="font-bold text-slate-800 mb-5">Atasan Langsung (Penandatanganan Laporan)</h2>
        <div class="bg-slate-50 rounded-lg p-4">
            <p class="font-bold text-slate-800" x-text="atasan.nama"></p>
            <p class="text-sm text-slate-500 mt-1" x-text="'NIP. ' + atasan.nip"></p>
            <p class="text-sm text-slate-500" x-text="atasan.jabatan"></p>
        </div>
    </div>

    {{-- ============ URAIAN TUGAS JABATAN ============ --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-bold text-slate-800">Uraian Tugas Jabatan</h2>
            <span class="flex items-center gap-1 text-xs font-semibold text-blue-600">
                <x-heroicon-o-arrow-down-tray class="w-3.5 h-3.5" />
                DIAMBIL DARI IKI
            </span>
        </div>
        <div class="flex flex-nowrap gap-8">
            <div class="flex-1">
                <p class="text-xs font-bold text-slate-500 mb-2">TUGAS POKOK</p>
                <ul class="space-y-1.5 text-sm text-slate-700 list-disc pl-4">
                    <template x-for="(tugas, i) in tugasPokok" :key="i">
                        <li x-text="tugas"></li>
                    </template>
                </ul>
            </div>
            <div class="flex-1">
                <p class="text-xs font-bold text-slate-500 mb-2">TUGAS AGILE</p>
                <ul class="space-y-1.5 text-sm text-slate-700 list-disc pl-4">
                    <template x-for="(tugas, i) in tugasAgile" :key="i">
                        <li x-text="tugas"></li>
                    </template>
                </ul>
            </div>
        </div>
    </div>

    {{-- ============ SASARAN STRATEGIS DAN TARGET ============ --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
        <h2 class="font-bold text-slate-800 mb-5">Sasaran Strategis dan Target</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border border-slate-200 rounded-lg">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="text-left text-xs font-bold text-slate-500 p-4 w-12 border-r border-slate-100">NO.</th>
                        <th class="text-left text-xs font-bold text-slate-500 p-4 w-56 border-r border-slate-100">SASARAN STRATEGIS</th>
                        <th class="text-left text-xs font-bold text-slate-500 p-4 border-r border-slate-100">INDIKATOR KINERJA UTAMA</th>
                        <th class="text-left text-xs font-bold text-slate-500 p-4 w-28 border-r border-slate-100">TARGET</th>
                        <th class="text-left text-xs font-bold text-slate-500 p-4 w-40 border-r border-slate-100">REALISASI</th>
                        <th class="text-left text-xs font-bold text-slate-500 p-4 w-32">CAPAIAN (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(row, index) in sasaranStrategis" :key="index">
                        <tr class="border-b border-slate-100 align-top">
                            <td class="p-4 text-slate-500 border-r border-slate-100" x-text="index + 1"></td>
                            <td class="p-4 border-r border-slate-100 text-slate-700" x-text="row.sasaran"></td>
                            <td class="p-4 border-r border-slate-100 text-slate-700" x-text="row.indikator"></td>
                            <td class="p-4 border-r border-slate-100 text-slate-700" x-text="row.target"></td>
                            <td class="p-4 border-r border-slate-100">
                                <input type="text" x-model="row.realisasi" placeholder="mis. 18 laporan"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400">
                            </td>
                            <td class="p-4">
                                <input type="text" x-model="row.capaian" placeholder="mis. 100"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400">
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ============ EVALUASI & ANALISIS KINERJA (WYSIWYG) ============ --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
        <label class="block text-xs font-bold text-slate-600 mb-2">EVALUASI & ANALISIS KINERJA</label>
        <div x-ref="evaluasiEditor"></div>
        {{-- hidden input ini yang dikirim ke server pas form disubmit --}}
        <input type="hidden" name="evaluasi_analisis" x-model="evaluasiAnalisis">
    </div>

    {{-- ============ RINGKASAN REALISASI TOTAL (WYSIWYG) ============ --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
        <label class="block text-xs font-bold text-slate-600 mb-2">RINGKASAN REALISASI TOTAL</label>
        <div x-ref="ringkasanEditor"></div>
        <input type="hidden" name="ringkasan_realisasi" x-model="ringkasanRealisasi">
    </div>

    {{-- ============ PENYEBAB KEBERHASILAN ============ --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
        <h2 class="font-bold text-slate-800 mb-4">Penyebab Keberhasilan</h2>
        <div class="space-y-2.5">
            <template x-for="(item, index) in penyebabKeberhasilan" :key="index">
                <div class="flex items-center gap-3">
                    <span class="text-sm text-slate-400 w-4" x-text="hurufAbjad(index)"></span>
                    <input type="text" x-model="penyebabKeberhasilan[index]" placeholder="Tambahkan penyebab keberhasilan..."
                        class="flex-1 px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400">
                    <button type="button" @click="penyebabKeberhasilan.splice(index, 1)" class="text-slate-300 hover:text-rose-500">
                        <x-heroicon-o-trash class="w-4 h-4" />
                    </button>
                </div>
            </template>
        </div>
        <button type="button" @click="penyebabKeberhasilan.push('')"
            class="flex items-center gap-1.5 mt-4 text-sm font-semibold text-blue-600 hover:text-blue-700">
            <x-heroicon-o-plus class="w-4 h-4" />
            Tambah Keberhasilan
        </button>
    </div>

    {{-- ============ RENCANA TINDAK LANJUT ============ --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
        <h2 class="font-bold text-slate-800 mb-4">Rencana Tindak Lanjut</h2>
        <div class="space-y-2.5">
            <template x-for="(item, index) in rencanaTindakLanjut" :key="index">
                <div class="flex items-center gap-3">
                    <span class="text-sm text-slate-400 w-4" x-text="hurufAbjad(index)"></span>
                    <input type="text" x-model="rencanaTindakLanjut[index]" placeholder="Tambahkan rencana tindak lanjut..."
                        class="flex-1 px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400">
                    <button type="button" @click="rencanaTindakLanjut.splice(index, 1)" class="text-slate-300 hover:text-rose-500">
                        <x-heroicon-o-trash class="w-4 h-4" />
                    </button>
                </div>
            </template>
        </div>
        <button type="button" @click="rencanaTindakLanjut.push('')"
            class="flex items-center gap-1.5 mt-4 text-sm font-semibold text-blue-600 hover:text-blue-700">
            <x-heroicon-o-plus class="w-4 h-4" />
            Tambah Rencana
        </button>
    </div>

    {{-- ============ LAMPIRAN ============ --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6">
        <h2 class="font-bold text-slate-800 mb-4">Lampiran - Dokumen Perjanjian Kinerja</h2>
        <label
            class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-slate-300 rounded-xl py-12 cursor-pointer hover:border-slate-400 hover:bg-slate-50">
            <x-heroicon-o-arrow-up-tray class="w-6 h-6 text-slate-400" />
            <p class="text-sm font-semibold text-slate-700">Klik atau tarik file ke sini</p>
            <p class="text-xs text-slate-400">Format: JPG, PNG, PDF &middot; Maks 5MB per file</p>
            <input type="file" @change="fileNames = Array.from($event.target.files).map(f => f.name)" class="hidden" accept=".jpg,.jpeg,.png,.pdf" multiple>
        </label>
        <ul class="mt-3 space-y-1" x-show="fileNames.length">
            <template x-for="name in fileNames" :key="name">
                <li class="text-sm text-slate-600" x-text="name"></li>
            </template>
        </ul>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>
<script>
    function lapkinForm() {
        return {
            // ============ dummy data — nanti diganti data asli dari backend ============
            pegawai: {
                nama_lengkap: 'Dita Ratna Sari, S.Kom',
                nip: '199007272025212020',
            },
            atasan: {
                nama: 'Linden Suryawan, S.T., M.Eng',
                nip: '197901012006041045',
                jabatan: 'Kepala Bidang Persandian dan Keamanan Informasi',
            },
            periodePelaporan: '',
            tahunKinerja: '2026',
            tahunOptions: ['2024', '2025', '2026'],

            // idealnya ditarik dari IKI
            tugasPokok: [
                'Melaksanakan monitoring dan evaluasi keamanan informasi secara berkala',
                'Melaporkan pelaksanaan layanan keamanan informasi dan persandian',
            ],
            tugasAgile: [
                'Menyusun data kepegawaian',
                'Melaporkan tingkat kesesuaian data kepegawaian dengan sistem / aplikasi kepegawaian daerah / nasional',
            ],

            // idealnya ditarik dari JAKIN/RENAKSI, kolom realisasi & capaian diisi user
            sasaranStrategis: [
                {
                    sasaran: 'Data pelaporan tugas pokok',
                    indikator: 'Jumlah laporan yang disusun',
                    target: '21 Laporan',
                    realisasi: '',
                    capaian: '',
                },
                {
                    sasaran: 'Data pelaporan tugas agile',
                    indikator: 'Jumlah laporan yang disusun',
                    target: '14 Laporan',
                    realisasi: '',
                    capaian: '',
                },
            ],

            evaluasiAnalisis: '',
            ringkasanRealisasi: '',

            penyebabKeberhasilan: [
                'Tersusunnya data administrasi server',
                'Tersusunnya data administrasi data center',
                'Data kepegawaian yang telah tersedia',
                '',
            ],

            rencanaTindakLanjut: [
                'Memahami dan melaksanakan perintah dari Kepala Bidang Persandian dan Keamanan Informasi dan Kepala Sub Bagian Umum dan Kepegawaian sesuai pedoman pelaksanaan',
                'Menelit dengan cermat jenis tugas yang diberikan',
                'Melakukan koordinasi dengan Kepala Bidang Persandian dan Keamanan Informasi dan Kepala Sub Bagian Umum dan Kepegawaian',
                'Menyajikan hasil pekerjaan yang dilaksanakan dengan baik dan tepat waktu',
                'Meningkatkan monitoring dan dokumentasi pemeliharaan server dan data center',
                'Melakukan pembaruan data kepegawaian secara berkala dan terintegrasi',
                'Mengoptimalkan pengelolaan website kepegawaian agar lebih informatif dan responsif',
                '',
            ],

            fileNames: [],

            // ============ WYSIWYG (Quill) ============
            initEditors() {
                const evaluasiQuill = new Quill(this.$refs.evaluasiEditor, {
                    theme: 'snow',
                    placeholder: 'Jelaskan pencapaian tugas, kendala organisasi, dan kendala yang dihadapi...',
                    modules: {
                        toolbar: [['bold', 'italic', 'underline'], [{ list: 'ordered' }, { list: 'bullet' }], ['clean']],
                    },
                });
                evaluasiQuill.on('text-change', () => {
                    this.evaluasiAnalisis = evaluasiQuill.root.innerHTML;
                });

                const ringkasanQuill = new Quill(this.$refs.ringkasanEditor, {
                    theme: 'snow',
                    placeholder: 'mis. Target 20 laporan (tugas pokok + tugas agile) → terealisasi 100%...',
                    modules: {
                        toolbar: [['bold', 'italic', 'underline'], [{ list: 'ordered' }, { list: 'bullet' }], ['clean']],
                    },
                });
                ringkasanQuill.on('text-change', () => {
                    this.ringkasanRealisasi = ringkasanQuill.root.innerHTML;
                });
            },

            hurufAbjad(index) {
                return String.fromCharCode(97 + index) + '.';
            },

            autoFill() {
                // sementara dummy — nanti backend dev ganti jadi request
                // yang narik Uraian Tugas dari IKI dan Sasaran Strategis dari JAKIN
                alert('Data tugas & sasaran ditarik otomatis dari IKI/JAKIN (dummy) - belum terhubung ke backend.');
            },

            ajukanLaporan() {
                alert('Laporan LAPKIN diajukan (dummy) - belum terhubung ke backend.');
            },
        }
    }
</script>
@endpush