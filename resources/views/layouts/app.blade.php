<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-SAKIP') | Diskominfo Kab. Malang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-50 antialiased">
    <div class="flex h-screen overflow-hidden">

        {{-- ============ SIDEBAR ============ --}}
        <aside class="w-64 flex-shrink-0 flex flex-col text-white"
               style="background: linear-gradient(160deg, #0f2942 0%, #0a1f33 55%, #142d47 100%);">

            {{-- Logo --}}
            <div class="flex items-center gap-3 px-5 py-5 border-b border-white/10">
                <div class="w-9 h-9 rounded-md bg-white/10 flex items-center justify-center">
                    <img src="{{ asset('images/logo-malang.png') }}" alt="Logo" class="w-6 h-6 object-contain">
                </div>
                <div>
                    <p class="font-bold text-sm leading-tight tracking-wide">E-SAKIP</p>
                    <p class="text-[10px] text-emerald-400 leading-tight">DISKOMINFO KAB. MALANG</p>
                </div>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-6 text-sm">

                <div>
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        <x-heroicon-o-squares-2x2 class="w-4 h-4" />
                        Dashboard
                    </x-nav-link>
                </div>

                <div>
                    <p class="px-3 mb-2 text-[11px] font-semibold tracking-wider text-white/40">MASTER</p>
                    <x-nav-link href="{{ route('master-pegawai') }}" :active="request()->routeIs('master-pegawai')">
                        <x-heroicon-o-user class="w-4 h-4" />
                        Master Pegawai
                    </x-nav-link>
                </div>

                <div>
                    <p class="px-3 mb-2 text-[11px] font-semibold tracking-wider text-white/40">SAKIP INDIVIDU</p>
                    <div class="space-y-1">
                        <x-nav-link href="{{ route('iki') }}" :active="request()->routeIs('iki')">
                            <x-heroicon-o-chart-bar class="w-4 h-4" />
                            Indikator Kinerja (IKI)
                        </x-nav-link>
                        <x-nav-link href="{{ route('jakin') }}" :active="request()->routeIs('jakin')">
                            <x-heroicon-o-document-text class="w-4 h-4" />
                            Perjanjian Kinerja (JAKIN)
                        </x-nav-link>
                        <x-nav-link href="{{ route('renaksi') }}" :active="request()->routeIs('renaksi')">
                            <x-heroicon-o-list-bullet class="w-4 h-4" />
                            Rencana Aksi (RENAKSI)
                        </x-nav-link>
                        <x-nav-link href="{{ route('lapkin') }}" :active="request()->routeIs('lapkin')">
                            <x-heroicon-o-clipboard-document-check class="w-4 h-4" />
                            Laporan Kinerja (LAPKIN)
                        </x-nav-link>
                    </div>
                </div>

                <div>
                    <p class="px-3 mb-2 text-[11px] font-semibold tracking-wider text-white/40">PELAPORAN</p>
                    <x-nav-link href="{{ route('rekap-dokumen') }}" :active="request()->routeIs('rekap-dokumen')">
                        <x-heroicon-o-folder class="w-4 h-4" />
                        Rekap Dokumen
                    </x-nav-link>
                </div>
            </nav>

            {{-- Logout --}}
            <div class="px-3 py-4 border-t border-white/10">
                <a href="#" class="flex items-center gap-2 px-3 py-2 rounded-md text-rose-400 hover:bg-white/5 text-sm font-medium">
                    <x-heroicon-o-arrow-right-start-on-rectangle class="w-4 h-4" />
                    Keluar
                </a>
            </div>
        </aside>

        {{-- ============ MAIN AREA ============ --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Header --}}
            <header class="flex items-center justify-between bg-white border-b border-slate-200 px-6 py-4">
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-slate-400">@yield('breadcrumb-parent', 'Master Data')</span>
                    <span class="text-slate-300">|</span>
                    <span class="font-semibold text-slate-800">@yield('breadcrumb-current', 'Halaman')</span>
                </div>

                <div class="flex items-center gap-5">
                    <button class="relative text-slate-400 hover:text-slate-600">
                        <x-heroicon-o-bell class="w-5 h-5" />
                        <span class="absolute -top-0.5 -right-0.5 w-2 h-2 rounded-full bg-rose-500"></span>
                    </button>
                    <button class="text-slate-400 hover:text-slate-600">
                        <x-heroicon-o-information-circle class="w-5 h-5" />
                    </button>
                    <div class="w-px h-8 bg-slate-200"></div>
                    <div class="text-right leading-tight">
                        <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name ?? 'Nama Pengguna' }}</p>
                        <p class="text-xs text-slate-400">{{ auth()->user()->jabatan ?? 'Jabatan Pengguna' }}</p>
                    </div>
                </div>
            </header>

            {{-- Page content --}}
            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>