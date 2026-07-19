@extends('layouts.app')

@section('title', 'Rencana Aksi (RENAKSI)')
@section('breadcrumb-parent', 'SAKIP Individu')
@section('breadcrumb-current', 'RENAKSI')

@section('content')
<div x-data="renaksiForm()">

    {{-- ============ PAGE HEADER ============ --}}
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Rencana Aksi (RENAKSI)</h1>
            <p class="text-sm text-slate-500 mt-1 max-w-xl">
                Uraikan target kegiatan dan rencana aksi tahunan Anda kedalam capaian per-triwulan.
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
                Simpan Rencana
            </button>
        </div>
    </div>

    {{-- ============ PEGAWAI ============ --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
        <label class="block text-xs font-bold text-slate-600 mb-1.5">PEGAWAI</label>
        <input
            type="text"
            :value="pegawai.nama_lengkap + ' (NIP: ' + pegawai.nip + ' )'"
            disabled
            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-800 bg-slate-50 disabled:text-slate-500">
    </div>

    {{-- ============ SASARAN STRATEGIS DAN TARGET ============ --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
        <h2 class="font-bold text-slate-800 mb-5">Sasaran Strategis dan Target</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm border border-slate-200 rounded-lg">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th rowspan="2" class="text-left text-xs font-bold text-slate-500 p-4 w-16 border-r border-slate-200 align-middle">NO.</th>
                        <th rowspan="2" class="text-left text-xs font-bold text-slate-500 p-4 w-64 border-r border-slate-200 align-middle">SASARAN STRATEGIS</th>
                        <th rowspan="2" class="text-left text-xs font-bold text-slate-500 p-4 w-64 border-r border-slate-200 align-middle">INDIKATOR KINERJA UTAMA</th>
                        <th colspan="4" class="text-center text-xs font-bold text-slate-500 p-4">TARGET LAPORAN TIAP TRIWULAN</th>
                    </tr>
                    <tr class="border-b border-slate-200">
                        <template x-for="(label, i) in ['I', 'II', 'III', 'IV']" :key="i">
                            <th class="text-center text-xs font-bold text-slate-500 p-3 border-l-2 border-slate-200" x-text="label"></th>
                        </template>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(row, index) in sasaranStrategis" :key="index">
                        <tr class="border-b border-slate-100 align-top">
                            <td class="p-4 text-slate-500 border-r border-slate-100" x-text="index + 1"></td>
                            <td class="p-4 border-r border-slate-100" x-text="row.sasaran"></td>
                            <td class="p-4 border-r border-slate-100" x-text="row.indikator"></td>
                            <template x-for="(triwulan, ti) in row.target_triwulan" :key="ti">
                                <td class="p-4 border-l-2 border-slate-200">
                                    <div class="flex items-center gap-2">
                                        <input
                                            type="number"
                                            x-model="triwulan.angka"
                                            style="width:64px; flex:0 0 64px;"
                                            class="px-2 py-2.5 rounded-md border border-slate-300 text-xs text-center text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400">
                                        <select
                                            x-model="triwulan.satuan"
                                            style="flex:1 1 0%; min-width:0;"
                                            class="px-2 py-2.5 rounded-md border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400">
                                            <option value="">Satuan...</option>
                                            <template x-for="satuan in satuanOptions" :key="satuan">
                                                <option :value="satuan" x-text="satuan"></option>
                                            </template>
                                        </select>
                                    </div>
                                </td>
                            </template>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ============ INPUT RENCANA AKSI KEGIATAN ============ --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6">
        <h2 class="font-bold text-slate-800 mb-5">Input Rencana Aksi Kegiatan</h2>

        <template x-for="(kegiatan, kIndex) in rencanaAksiKegiatan" :key="kIndex">
            <div class="bg-slate-50 rounded-xl p-6 mb-4">
                <p class="text-xs font-bold text-slate-700 mb-4" x-text="'RENCANA AKSI KEGIATAN #' + (kIndex + 1)"></p>

                <div class="mb-5">
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">AKSI KEGIATAN</label>
                    <textarea
                        x-model="kegiatan.aksi"
                        rows="3"
                        placeholder="Uraikan rencana aksi kegiatan individu..."
                        class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400"></textarea>
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-bold text-slate-600 mb-2">JADWAL PELAKSAAN</label>
                    <div class="flex flex-nowrap gap-3">
                        <template x-for="(label, tIndex) in ['Triwulan I', 'Triwulan II', 'Triwulan III', 'Triwulan IV']" :key="tIndex">
                            <label class="flex-1 flex items-center justify-between px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-sm text-slate-700 cursor-pointer">
                                <span x-text="label"></span>
                                <input type="checkbox" x-model="kegiatan.jadwal[tIndex]" class="w-4 h-4 rounded border-slate-400">
                            </label>
                        </template>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Output / Keluaran</label>
                    <input
                        type="text"
                        x-model="kegiatan.output"
                        placeholder="Uraikan output / keluaran dari kegiatan..."
                        class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400">
                </div>

                <div class="flex flex-nowrap gap-5 mb-5">
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Rencana</label>
                        <input
                            type="text"
                            x-model="kegiatan.rencana"
                            placeholder="Uraikan rencana program..."
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400">
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Kegiatan</label>
                        <input
                            type="text"
                            x-model="kegiatan.kegiatan"
                            placeholder="Uraikan rencana kegiatan..."
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Anggaran Kegiatan</label>
                    <div class="flex items-center gap-2 max-w-xs">
                        <span class="text-sm text-slate-500">Rp.</span>
                        <input
                            type="text"
                            value="0"
                            disabled
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-400 bg-slate-100">
                    </div>
                    <p class="flex items-center gap-1.5 text-xs text-rose-500 mt-2">
                        <x-heroicon-o-information-circle class="w-4 h-4" />
                        Anggaran kegiatan hanya diisi oleh kepala bidang.
                    </p>
                </div>
            </div>
        </template>

        <button
            type="button"
            @click="tambahKegiatan()"
            class="flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-700">
            <x-heroicon-o-plus class="w-4 h-4" />
            Tambah Rencana Aksi Kegiatan
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function renaksiForm() {
        return {
            // dummy data — nanti diganti data asli dari backend
            pegawai: {
                nama_lengkap: 'Dita Ratna Sari, S.Kom',
                nip: '199007272025212020',
            },

            satuanOptions: ['Laporan', 'Dokumen', 'Kegiatan', 'Persen', 'Satuan'],

            // sasaran strategis idealnya narik dari data JAKIN yang sudah diisi sebelumnya
            sasaranStrategis: [
                {
                    sasaran: 'Menyediakan Layanan Keamanan Informasi dan Persandian Pemerintah Daerah',
                    indikator: 'Jumlah laporan rekapitulasi data administrasi layanan keamanan',
                    target_triwulan: [
                        { angka: 1, satuan: 'Laporan' },
                        { angka: 1, satuan: 'Laporan' },
                        { angka: 1, satuan: 'Laporan' },
                        { angka: 1, satuan: 'Laporan' },
                    ],
                },
                {
                    sasaran: 'Melaksanakan tugas administrasi kepegawaian (tugas agile)',
                    indikator: 'Jumlah laporan rekapitulasi data administrasi kepegawaian',
                    target_triwulan: [
                        { angka: '', satuan: '' },
                        { angka: '', satuan: '' },
                        { angka: '', satuan: '' },
                        { angka: '', satuan: '' },
                    ],
                },
            ],

            rencanaAksiKegiatan: [
                {
                    aksi: '',
                    jadwal: [true, true, false, false],
                    output: '',
                    rencana: '',
                    kegiatan: '',
                },
            ],

            tambahKegiatan() {
                this.rencanaAksiKegiatan.push({
                    aksi: '',
                    jadwal: [false, false, false, false],
                    output: '',
                    rencana: '',
                    kegiatan: '',
                });
            },

            autoFill() {
                // sementara dummy — nanti backend dev ganti jadi request
                // yang narik Sasaran Strategis & Target dari data JAKIN
                alert('Sasaran Strategis & Target ditarik otomatis dari JAKIN (dummy) - belum terhubung ke backend.');
            },

            simpanData() {
                alert('Rencana Aksi disimpan (dummy) - belum terhubung ke backend.');
            },
        }
    }
</script>
@endpush