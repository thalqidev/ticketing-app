<x-app-layout>
    <div class="relative bg-gradient-to-br from-blue-950 via-blue-900 to-indigo-950 text-white py-20 px-6 text-center overflow-hidden rounded-b-[2.5rem] shadow-xl">
        
        <div class="absolute -top-12 -left-12 w-48 h-48 bg-blue-600 rounded-full blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-16 -right-16 w-64 h-64 bg-indigo-500 rounded-full blur-3xl opacity-25"></div>

        <div class="relative max-w-3xl mx-auto z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight drop-shadow-md bg-clip-text bg-gradient-to-r from-white via-slate-100 to-blue-200">
                Hi, Amankan Tiketmu yuk.
            </h1>
            <p class="text-blue-200/90 text-base md:text-lg font-light mt-4 max-w-md mx-auto tracking-wide">
                BengTix: Beli tiket, auto asik.
            </p>
        </div>
    </div>

    <section class="max-w-7xl mx-auto py-16 px-6">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-10 border-b border-gray-100 pb-5">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight flex items-center gap-2">
                    Jelajahi Event Terbaru
                </h2>
                <p class="text-xs text-gray-400 mt-1">Temukan berbagai event seru pilihan untuk harimu</p>
            </div>
            
            <div class="flex flex-wrap gap-2 bg-gray-100/80 p-1 rounded-xl border border-gray-200/40 shadow-inner">
                <a href="{{ route('home') }}" class="transition-all duration-200 hover:scale-105">
                    <x-ui.category-pill :label="'Semua'" :active="!request('kategori')" />
                </a>
                @foreach($categories as $kategori)
                <a href="{{ route('home', ['kategori' => $kategori->id]) }}" class="transition-all duration-200 hover:scale-105">
                    <x-ui.category-pill :label="$kategori->nama" :active="request('kategori') == $kategori->id" />
                </a>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach($events as $event)
                <div class="hover:-translate-y-2 transition-all duration-300">
                    <x-event-card 
                        :title="$event->judul" 
                        :date="$event->tanggal_waktu" 
                        :location="$event->lokasi" 
                        :price="$event->tikets_min_harga" 
                        :image="$event->gambar" 
                        :href="route('events.show', $event)" 
                    />
                </div>
            @endforeach
        </div>
        
    </section>
</x-app-layout>