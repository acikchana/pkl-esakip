@extends('layouts.app')

@section('title', 'Master Pegawai')
@section('breadcrumb-parent', 'Master Data')
@section('breadcrumb-current', 'Master Pegawai')

@section('content')
<div x-data="masterPegawaiForm()">

    {{-- ============ PAGE HEADER ============ --}}
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Master Pegawai</h1>
            <p class="text-sm text-slate-500 mt-1 max-w-xl">
                Data Master Pegawai harus selaras dengan struktur Master Jabatan yang tersedia.
                Data ini akan menjadi dasar perhitungan Capaian Kinerja pada modul RENAKSI.
            </p>
        </div>

        <div class="flex items-center gap-3 flex-shrink-0">
            <button
                type="button"
                @click="editMode = !editMode"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg border border-slate-300 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                <x-heroicon-o-pencil class="w-4 h-4" />
                <span x-text="editMode ? 'Batal Edit' : 'Edit Data'"></span>
            </button>
            <button
                type="button"
                @click="simpanData()"
                class="px-4 py-2.5 rounded-lg bg-slate-900 text-sm font-semibold text-white hover:bg-slate-800">
                Simpan Master Data
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ============ FORM CARD ============ --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 p-6">
            <h2 class="font-bold text-slate-800 mb-5">Form Master Pegawai</h2>

            <form class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">
                            NAMA LENGKAP <span class="text-rose-500">*</span>
                        </label>
                        <p class="text-[11px] text-slate-400 mb-1.5">Contoh penulisan: Nagita Slavina, S.Kom</p>
                        <input
                            type="text"
                            x-model="form.nama_lengkap"
                            :disabled="!editMode"
                            minlength="30"
                            required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-800 disabled:bg-slate-50 disabled:text-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400">
                    </div>

                    {{-- NIP --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">
                            NIP <span class="text-rose-500">*</span>
                        </label>
                        <p class="text-[11px] text-slate-400 mb-1.5">&nbsp;</p>
                        <input
                            type="text"
                            x-model="form.nip"
                            :disabled="!editMode"
                            maxlength="18"
                            pattern="\d{18}"
                            required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-800 disabled:bg-slate-50 disabled:text-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400">
                    </div>

                    {{-- Unit Kerja / Bidang --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">
                            UNIT KERJA / BIDANG <span class="text-rose-500">*</span>
                        </label>
                        <select
                            x-model="form.unit_kerja"
                            @change="form.jabatan = ''"
                            :disabled="!editMode"
                            required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-800 disabled:bg-slate-50 disabled:text-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400">
                            <option value="">Pilih Unit Kerja / Bidang</option>
                            <template x-for="unit in unitKerjaOptions" :key="unit">
                                <option :value="unit" x-text="unit"></option>
                            </template>
                        </select>
                    </div>

                    {{-- Jabatan (dependent ke Unit Kerja) --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">
                            JABATAN <span class="text-rose-500">*</span>
                        </label>
                        <select
                            x-model="form.jabatan"
                            :disabled="!editMode || !form.unit_kerja"
                            required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-800 disabled:bg-slate-50 disabled:text-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400">
                            <option value="">Pilih Jabatan</option>
                            <template x-for="jab in jabatanOptions[form.unit_kerja] || []" :key="jab">
                                <option :value="jab" x-text="jab"></option>
                            </template>
                        </select>
                    </div>

                    {{-- Pangkat / Golongan --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">
                            PANGKAT / GOLONGAN <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            x-model="form.pangkat_golongan"
                            :disabled="!editMode"
                            required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-800 disabled:bg-slate-50 disabled:text-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400">
                    </div>

                    {{-- Email Dinas --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">EMAIL DINAS</label>
                        <input
                            type="email"
                            x-model="form.email_dinas"
                            :disabled="!editMode"
                            placeholder="email@gmail.com"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-800 disabled:bg-slate-50 disabled:text-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400">
                    </div>
                </div>

                <div class="flex items-start gap-2 text-xs text-slate-400 pt-1">
                    <x-heroicon-o-information-circle class="w-4 h-4 flex-shrink-0 mt-0.5" />
                    <span>Daftar jabatan disesuaikan dengan bidang yang dipilih.</span>
                </div>
            </form>
        </div>

        {{-- ============ SIDE CARDS ============ --}}
        <div class="space-y-6">

            {{-- Informasi Alur --}}
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="font-bold text-slate-800 mb-3">Informasi Alur</h3>
                <p class="text-sm text-slate-500 mb-4">
                    Pengisian Master Pegawai harus selaras dengan struktur Master Jabatan yang telah terdaftar.
                </p>

                <div class="bg-slate-50 rounded-lg p-4 space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-700">Status Validasi</span>
                        <span
                            class="text-[10px] font-bold px-2 py-0.5 rounded"
                            :class="{
                                'bg-amber-100 text-amber-700': status === 'DRAFT',
                                'bg-emerald-100 text-emerald-700': status === 'VALID',
                            }"
                            x-text="status"></span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500">Terakhir diubah</span>
                        <span class="text-slate-700 font-mono">{{ now()->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500">Petugas</span>
                        <span class="text-slate-700 font-mono">{{ auth()->user()->username ?? 'ADMIN_CENTRAL' }}</span>
                    </div>
                </div>
            </div>

            {{-- Petunjuk --}}
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="font-bold text-slate-800 mb-3">Petunjuk</h3>
                <ul class="space-y-2 text-sm text-slate-500 list-disc pl-4">
                    <li>Penulisan nama lengkap diawali dengan huruf kapital</li>
                    <li>NIP wajib 18 digit angka tanpa spasi</li>
                    <li>Nama lengkap minimal 30 karakter</li>
                    <li>Pastikan data yang diisi sudah sesuai dan tepat</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function masterPegawaiForm() {
        return {
            editMode: false,
            status: 'DRAFT',

            // dummy data sementara — nanti diganti data asli dari backend
            form: {
                nama_lengkap: 'Dita Ratna Sari, S.Kom',
                nip: '199007272025212020',
                unit_kerja: '',
                jabatan: '',
                pangkat_golongan: '',
                email_dinas: '',
            },

            unitKerjaOptions: [
                'Bidang Pengelolaan Data & Informasi',
                'Bidang Persandian & Keamanan Informasi',
                'Bidang Teknologi Informasi',
                'Sekretariat',
            ],

            jabatanOptions: {
                'Bidang Pengelolaan Data & Informasi': ['Pranata Komputer Ahli Pertama', 'Analis Data'],
                'Bidang Persandian & Keamanan Informasi': ['Sandiman Ahli Pertama', 'Analis Keamanan Informasi'],
                'Bidang Teknologi Informasi': ['Pranata Komputer Ahli Muda', 'Administrator Jaringan'],
                'Sekretariat': ['Analis Kepegawaian', 'Pengadministrasi Umum'],
            },

            simpanData() {
                // sementara cuma alert dummy — backend dev akan ganti ini
                // jadi submit form / request AJAX ke server
                alert('Data disimpan (dummy) — belum terhubung ke backend.');
                this.editMode = false;
            },
        }
    }
</script>
@endpush