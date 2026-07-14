<div class="navbar bg-base-100 shadow-sm px-4">
    <div class="navbar-start">
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                </svg>
            </div>
        </div>
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/images/logo_bengkod.svg') }}" alt="Logo" class="h-8" />
        </a>
    </div>

    <div class="navbar-center hidden lg:flex">
        <input class="input input-bordered w-80 rounded-full bg-gray-55 text-sm pl-4 h-10 focus:outline-none focus:ring-2 focus:ring-blue-900/20" placeholder="Cari Event seru di sini..." />
    </div>

    <div class="navbar-end gap-3">
        @guest
            <a href="{{ route('login') }}" class="btn bg-blue-900 hover:bg-blue-950 text-white border-none rounded-lg px-5 btn-sm h-10">Login</a>
            <a href="{{ route('register') }}" class="btn btn-outline text-blue-900 border-blue-900 hover:bg-blue-50 rounded-lg px-5 btn-sm h-10">Register</a>
        @endguest 
        
        @auth
            <span class="text-xs text-gray-600 hidden sm:inline">
                Halo, <strong class="text-gray-800">{{ Auth::user()->name }}</strong> 
                <span class="badge badge-sm uppercase font-bold text-[9px] px-2 {{ Auth::user()->role === 'admin' ? 'badge-primary' : 'badge-ghost' }}">
                    {{ Auth::user()->role ?? 'User' }}
                </span>
            </span>

            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar border border-gray-200 shadow-sm">
                    <div class="w-10 rounded-full flex items-center justify-center bg-blue-50 text-blue-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mx-auto mt-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
                
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[50] p-2 shadow-xl bg-base-100 rounded-xl w-56 border border-gray-100">
                    @if(Auth::user()->role === 'admin')
                        <li>
                            <a href="{{ route('dashboard') }}" class="font-semibold text-blue-900 bg-blue-50 py-2 mb-1">
                                Masuk Admin Panel
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('home') }}" class="py-2 mb-1">
                                Halaman Depan
                            </a>
                        </li>
                    @endif
                    
                    <li>
                        <a href="{{ route('profile.edit') }}" class="justify-between py-2">
                            Pengaturan Profil
                        </a>
                    </li>
                    
                    <div class="border-t border-gray-100 my-1"></div>
                    
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf 
                            <button type="submit" class="w-full text-left text-red-600 font-medium py-2 hover:bg-red-50 rounded-lg">
                                Keluar / Log Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @endauth
    </div>
</div>