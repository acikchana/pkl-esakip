@extends('layouts.app')

@section('title', 'Perjanjian Kinerja (JAKIN)')
@section('breadcrumb-parent', 'SAKIP Individu')
@section('breadcrumb-current', 'JAKIN')

@section('content')
<div x-data="jakinForm()">

    {{-- ============ PAGE HEADER ============ --}}
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Perjanjian Kinerja (JAKIN)</h1>
            <p class="text-sm text-slate-500 mt-1 max-w-xl">
                Dokumen kesepakatan kinerja antara Pihak Pertama (pegawai) dan Pihak Kedua (atasan langsung).
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
                Simpan Data JAKIN
            </button>
        </div>
    </div>

    {{-- ============ PARA PIHAK ============ --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
        <h2 class="font-bold text-slate-800 mb-5">Para Pihak</h2>

        <div class="flex flex-nowrap gap-5">
            <div class="flex-1 bg-slate-50 rounded-lg p-5">
                <p class="text-xs font-bold text-blue-600 mb-2 tracking-wide">PIHAK 1</p>
                <p class="font-bold text-slate-800" x-text="pihak1.nama"></p>
                <p class="text-sm text-slate-500 mt-1" x-text="'NIP. ' + pihak1.nip"></p>
                <p class="text-sm text-slate-500" x-text="pihak1.jabatan"></p>
            </div>

            <div class="flex-1 bg-slate-50 rounded-lg p-5">
                <p class="text-xs font-bold text-blue-600 mb-2 tracking-wide">PIHAK 2 (ATASAN LANGSUNG)</p>
                <p class="font-bold text-slate-800" x-text="pihak2.nama"></p>
                <p class="text-sm text-slate-500 mt-1" x-text="'NIP. ' + pihak2.nip"></p>
                <p class="text-sm text-slate-500" x-text="pihak2.jabatan"></p>
            </div>
        </div>
    </div>

    {{-- ============ SASARAN STRATEGIS DAN TARGET ============ --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6">
        <h2 class="font-bold text-slate-800 mb-5">Sasaran Strategis dan Target</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="text-left text-xs font-bold text-slate-500 pb-3 px-4 w-12 border-r border-slate-200">NO.</th>
                        <th class="text-left text-xs font-bold text-slate-500 pb-3 px-4 w-2/5 border-r border-slate-200">SASARAN STRATEGIS</th>
                        <th class="text-left text-xs font-bold text-slate-500 pb-3 px-4 border-r border-slate-200">INDIKATOR KINERJA UTAMA</th>
                        <th class="text-center text-xs font-bold text-slate-500 pb-3 px-4 w-80">TARGET</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(row, index) in sasaranStrategis" :key="index">
                        <tr class="border-b border-slate-100 align-top">
                            <td class="py-4 px-4 text-slate-500 border-r border-slate-100" x-text="index + 1"></td>
                            <td class="py-4 px-4 border-r border-slate-100">
                                <textarea
                                    x-model="row.sasaran"
                                    rows="2"
                                    class="w-full text-sm text-slate-800 border-0 focus:outline-none focus:ring-0 resize-none bg-transparent"></textarea>
                            </td>
                            <td class="py-4 px-4 border-r border-slate-100">
                                <textarea
                                    x-model="row.indikator"
                                    rows="2"
                                    class="w-full text-sm text-slate-800 border-0 focus:outline-none focus:ring-0 resize-none bg-transparent"></textarea>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <input
                                        type="number"
                                        x-model="row.target_angka"
                                        class="w-28 px-3 py-2.5 rounded-lg border border-slate-300 text-sm text-center text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400">
                                    <select
                                        x-model="row.target_satuan"
                                        class="w-full px-3 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400">
                                        <option value="">Satuan...</option>
                                        <template x-for="satuan in satuanOptions" :key="satuan">
                                            <option :value="satuan" x-text="satuan"></option>
                                        </template>
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function jakinForm() {
        return {
            // dummy data — nanti diganti data asli dari backend
            // (Pihak 1 dari Master Pegawai, Pihak 2 dari relasi atasan di Master Jabatan)
            pihak1: {
                nama: 'Dita Ratna Sari, S.Kom',
                nip: '199007272025212020',
                jabatan: 'Pranata Komputer Ahli Pertama',
            },

            pihak2: {
                nama: 'Linden Suryawan, S.T., M.Eng',
                nip: '197901012006041045',
                jabatan: 'Kepala Bidang Persandian dan Keamanan Informasi',
            },

            satuanOptions: ['Laporan', 'Dokumen', 'Kegiatan', 'Persen', 'Satuan'],

            // sasaran strategis ini idealnya narik dari data IKI yang sudah diisi sebelumnya
            sasaranStrategis: [
                {
                    sasaran: 'Menyediakan Layanan Keamanan Informasi dan Persandian Pemerintah Daerah',
                    indikator: 'Jumlah laporan rekapitulasi data administrasi layanan keamanan',
                    target_angka: 4,
                    target_satuan: 'Laporan',
                },
                {
                    sasaran: 'Melaksanakan tugas administrasi kepegawaian (tugas agile)',
                    indikator: 'Jumlah laporan rekapitulasi data administrasi kepegawaian',
                    target_angka: '',
                    target_satuan: '',
                },
            ],

            autoFill() {
                // sementara dummy — nanti backend dev ganti jadi request
                // yang narik data Pihak 1 & 2 dari Master Pegawai/Jabatan, serta sasaran dari IKI
                alert('Data Para Pihak & Sasaran Strategis ditarik otomatis (dummy) - belum terhubung ke backend.');
            },

            simpanData() {
                alert('Data JAKIN disimpan (dummy) - belum terhubung ke backend.');
            },
        }
    }
</script>
@endpush