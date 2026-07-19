@extends('layouts.app')

@section('title', 'Rekap Dokumen')
@section('breadcrumb-parent', 'Pelaporan')
@section('breadcrumb-current', 'Rekap Dokumen')

@section('content')
<div x-data="rekapDokumenList()">

    {{-- ============ PAGE HEADER ============ --}}
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Dokumen Kinerja Saya</h1>
            <p class="text-sm text-slate-500 mt-1">Semua dokumen SAKIP milik Anda tersimpan di sini.</p>
        </div>

        <button
            type="button"
            @click="eksporData()"
            class="flex items-center gap-2 px-4 py-2.5 rounded-lg bg-slate-900 text-sm font-semibold text-white hover:bg-slate-800 flex-shrink-0">
            <x-heroicon-o-arrow-down-tray class="w-4 h-4" />
            Ekspor Data
        </button>
    </div>

    {{-- ============ TABLE CARD ============ --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6">

        {{-- Entries selector --}}
        <div class="flex items-center gap-2 text-sm text-slate-600 mb-4">
            <span>Tampilkan</span>
            <select
                x-model="perPage"
                class="px-3 py-1.5 rounded-lg border border-slate-300 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-400">
                <template x-for="opsi in perPageOptions" :key="opsi">
                    <option :value="opsi" x-text="opsi"></option>
                </template>
            </select>
            <span>entri</span>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="text-left text-xs font-bold text-slate-500 pb-3 pr-4 w-16">NO.</th>
                        <th class="text-left text-xs font-bold text-slate-500 pb-3 pr-4">NAMA PEGAWAI / NIP</th>
                        <th class="text-left text-xs font-bold text-slate-500 pb-3 pr-4">CETAK DOKUMEN</th>
                        <th class="text-right text-xs font-bold text-slate-500 pb-3 w-32"></th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(dokumen, index) in dokumenList" :key="index">
                        <tr class="border-b border-slate-100">
                            <td class="py-4 pr-4 text-slate-500" x-text="index + 1"></td>
                            <td class="py-4 pr-4">
                                <p class="font-bold text-slate-800" x-text="dokumen.label"></p>
                            </td>
                            <td class="py-4 pr-4">
                                <div class="flex flex-nowrap items-center gap-2">
                                    <template x-for="modul in dokumen.modul" :key="modul.kode">
                                        <a
                                            :href="modul.url"
                                            class="flex items-center gap-1.5 px-3.5 py-2 rounded-full border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50 whitespace-nowrap">
                                            <span x-html="modul.icon"></span>
                                            <span x-text="modul.kode"></span>
                                        </a>
                                    </template>
                                </div>
                            </td>
                            <td class="py-4 text-right">
                                <button
                                    type="button"
                                    @click="editData(dokumen)"
                                    class="flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-300 text-sm font-semibold text-slate-700 hover:bg-slate-50 ml-auto">
                                    <x-heroicon-o-pencil class="w-4 h-4" />
                                    Edit Data
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-100">
            <p class="text-sm text-slate-500" x-text="'Menampilkan 1-' + dokumenList.length + ' dari ' + totalEntri + ' entri'"></p>

            <div class="flex items-center gap-2">
                <button
                    type="button"
                    @click="halaman = Math.max(1, halaman - 1)"
                    class="px-3.5 py-1.5 rounded-lg border border-slate-300 text-xs font-semibold text-slate-600 hover:bg-slate-50">
                    PREV
                </button>
                <template x-for="p in totalHalaman" :key="p">
                    <button
                        type="button"
                        @click="halaman = p"
                        :class="halaman === p ? 'bg-blue-600 text-white border-blue-600' : 'border-slate-300 text-slate-600 hover:bg-slate-50'"
                        class="w-8 h-8 rounded-lg border text-xs font-semibold"
                        x-text="p"></button>
                </template>
                <button
                    type="button"
                    @click="halaman = Math.min(totalHalaman, halaman + 1)"
                    class="px-3.5 py-1.5 rounded-lg border border-slate-300 text-xs font-semibold text-slate-600 hover:bg-slate-50">
                    NEXT
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function rekapDokumenList() {
        return {
            // dummy data — nanti diganti data asli dari backend (query per tahun kinerja pegawai)
            dokumenList: [
                {
                    label: 'SAKIP TAHUN 2026',
                    modul: [
                        { kode: 'IKI', url: '#', icon: '&#9678;' },
                        { kode: 'JAKIN', url: '#', icon: '&#128196;' },
                        { kode: 'RENAKSI', url: '#', icon: '&#9776;' },
                        { kode: 'LAPKIN', url: '#', icon: '&#128203;' },
                    ],
                },
            ],

            perPage: 5,
            perPageOptions: [5, 10, 25, 50],
            halaman: 1,
            totalHalaman: 2,
            totalEntri: 5,

            editData(dokumen) {
                // sementara dummy — nanti backend dev ganti jadi redirect
                // ke halaman edit dokumen kinerja tahun terkait
                alert('Edit data untuk ' + dokumen.label + ' (dummy) - belum terhubung ke backend.');
            },

            eksporData() {
                alert('Ekspor data dokumen kinerja (dummy) - belum terhubung ke backend.');
            },
        }
    }
</script>
@endpush