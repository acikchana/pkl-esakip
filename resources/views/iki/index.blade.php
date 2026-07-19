@extends('layouts.app')

@section('title', 'Indikator Kinerja (IKI)')
@section('breadcrumb-parent', 'SAKIP Individu')
@section('breadcrumb-current', 'IKI')

@section('content')
<div x-data="ikiForm()">

    {{-- ============ PAGE HEADER ============ --}}
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Indikator Kinerja Individu (IKI)</h1>
            <p class="text-sm text-slate-500 mt-1 max-w-xl">
                Kelola target kinerja tahunan dan indikator keberhasilan pelaksanaan tugas jabatan.
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
                @click="simpanData()"
                class="px-4 py-2.5 rounded-lg bg-slate-900 text-sm font-semibold text-white hover:bg-slate-800">
                Simpan Data IKI
            </button>
        </div>
    </div>

    {{-- ============ DATA PEGAWAI ============ --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
        <h2 class="font-bold text-slate-800 mb-5">Data Pegawai</h2>

        <div class="flex flex-nowrap gap-5">
            <div class="flex-[5]">
                <label class="block text-xs font-bold text-slate-600 mb-1.5">PEGAWAI</label>
                <input
                    type="text"
                    x-model="pegawai.nama_lengkap"
                    disabled
                    class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-800 bg-slate-50 disabled:text-slate-500">
            </div>

            <div class="flex-[4]">
                <label class="block text-xs font-bold text-slate-600 mb-1.5">NIP</label>
                <input
                    type="text"
                    x-model="pegawai.nip"
                    disabled
                    class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-800 bg-slate-50 disabled:text-slate-500">
            </div>

            <div class="flex-[3]">
                <label class="block text-xs font-bold text-slate-600 mb-1.5">TAHUN KINERJA</label>
                <select
                    x-model="pegawai.tahun_kinerja"
                    class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400">
                    <template x-for="tahun in tahunOptions" :key="tahun">
                        <option :value="tahun" x-text="tahun"></option>
                    </template>
                </select>
            </div>
        </div>
    </div>

    {{-- ============ TUGAS & KINERJA ============ --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6">
        <h2 class="font-bold text-slate-800 mb-5">Tugas & Kinerja</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="text-left text-xs font-bold text-slate-500 pb-3 pr-4 w-1/4">KINERJA</th>
                        <th class="text-left text-xs font-bold text-slate-500 pb-3 pr-4 w-1/4">INDIKATOR</th>
                        <th class="text-left text-xs font-bold text-slate-500 pb-3 pr-4 w-1/3">PENJELASAN/FORMULASI/PERHITUNGAN</th>
                        <th class="text-left text-xs font-bold text-slate-500 pb-3 pr-4">SUMBER DATA</th>
                        <th class="w-8"></th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(row, index) in tugasKinerja" :key="index">
                        <tr class="border-b border-slate-100 align-top">
                            <td class="py-3 pr-4">
                                <textarea
                                    x-model="row.kinerja"
                                    rows="2"
                                    placeholder="Tuliskan kinerja..."
                                    class="w-full text-sm text-slate-800 placeholder:text-slate-300 border-0 focus:outline-none focus:ring-0 resize-none bg-transparent"></textarea>
                            </td>
                            <td class="py-3 pr-4">
                                <textarea
                                    x-model="row.indikator"
                                    rows="2"
                                    placeholder="Indikator kinerja..."
                                    class="w-full text-sm text-slate-800 placeholder:text-slate-300 border-0 focus:outline-none focus:ring-0 resize-none bg-transparent"></textarea>
                            </td>
                            <td class="py-3 pr-4">
                                <textarea
                                    x-model="row.formulasi"
                                    rows="2"
                                    placeholder="Formulasi perhitungan..."
                                    class="w-full text-sm text-slate-800 placeholder:text-slate-300 border-0 focus:outline-none focus:ring-0 resize-none bg-transparent"></textarea>
                            </td>
                            <td class="py-3 pr-4">
                                <textarea
                                    x-model="row.sumber_data"
                                    rows="2"
                                    placeholder="Sumber data"
                                    class="w-full text-sm text-slate-800 placeholder:text-slate-300 border-0 focus:outline-none focus:ring-0 resize-none bg-transparent"></textarea>
                            </td>
                            <td class="py-3 text-right">
                                <button type="button" @click="hapusBaris(index)" class="text-slate-300 hover:text-rose-500">
                                    <x-heroicon-o-trash class="w-4 h-4" />
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <button
            type="button"
            @click="tambahBaris()"
            class="flex items-center gap-1.5 mt-4 text-sm font-semibold text-blue-600 hover:text-blue-700">
            <x-heroicon-o-plus class="w-4 h-4" />
            Tambah Rencana Aksi Kegiatan
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function ikiForm() {
        return {
            // dummy data — nanti diganti data asli dari backend (relasi ke Master Pegawai)
            pegawai: {
                nama_lengkap: 'Dita Ratna Sari, S.Kom',
                nip: '199007272025212020',
                tahun_kinerja: '2026',
            },

            tahunOptions: ['2024', '2025', '2026'],

            tugasKinerja: [
                {
                    kinerja: 'Menyediakan Layanan Keamanan Informasi dan Persandian Pemerintah Daerah',
                    indikator: 'Jumlah laporan rekapitulasi data administrasi layanan keamanan',
                    formulasi: 'Jumlah laporan administrasi layanan yang disusun',
                    sumber_data: 'Bidang Persandian dan Keamanan Informasi',
                },
                {
                    kinerja: 'Melaksanakan tugas administrasi kepegawaian (tugas agile)',
                    indikator: 'Jumlah laporan rekapitulasi data administrasi kepegawaian',
                    formulasi: 'Jumlah laporan administrasi layanan yang disusun',
                    sumber_data: 'Sub Bagian Umum dan Kepegawaian',
                },
                {
                    kinerja: '',
                    indikator: '',
                    formulasi: '',
                    sumber_data: '',
                },
            ],

            tambahBaris() {
                this.tugasKinerja.push({
                    kinerja: '',
                    indikator: '',
                    formulasi: '',
                    sumber_data: '',
                });
            },

            hapusBaris(index) {
                this.tugasKinerja.splice(index, 1);
            },

            autoFill() {
                // sementara dummy — nanti backend dev ganti jadi request
                // yang narik data dari Master Pegawai & Master Jabatan
                alert('Data pegawai ditarik otomatis dari Master Pegawai (dummy) - belum terhubung ke backend.');
            },

            simpanData() {
                alert('Data IKI disimpan (dummy) - belum terhubung ke backend.');
            },
        }
    }
</script>
@endpush