<x-guest-layout>
    <div class="fixed inset-0 min-h-screen w-full bg-gradient-to-br from-slate-950 via-blue-950 to-slate-950 flex items-center justify-center p-4">
        
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 border border-gray-100">
            
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-black text-gray-800 tracking-tight">BengTix</h2>
                <p class="text-xs text-gray-400 mt-1">Masuk untuk mulai memesan tiket event pilihanmu</p>
            </div>

            <x-auth-session-status class="mb-4 text-sm" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5 block" />
                    <x-text-input id="email" class="block w-full rounded-xl border-gray-300 focus:border-blue-900 focus:ring-blue-900/20 text-sm py-2.5 px-4 text-gray-800 shadow-sm" 
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="masukan email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-red-600 font-medium" />
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <x-input-label for="password" :value="__('Password')" class="text-xs font-semibold text-gray-500 uppercase tracking-wider block" />
                        @if (Route::has('password.request'))
                            <a class="text-xs text-blue-900 hover:underline font-bold" href="{{ route('password.request') }}">
                                Lupa password?
                            </a>
                        @endif
                    </div>
                    <x-text-input id="password" class="block w-full rounded-xl border-gray-300 focus:border-blue-900 focus:ring-blue-900/20 text-sm py-2.5 px-4 text-gray-800 shadow-sm"
                        type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-600 font-medium" />
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-900 focus:ring-blue-900/20 shadow-sm w-4 h-4" name="remember">
                        <span class="ms-2 text-xs text-gray-500 font-medium">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-blue-900 hover:bg-blue-950 text-white font-bold rounded-xl py-3 text-sm transition duration-200 shadow-lg shadow-blue-900/10 active:scale-[0.98]">
                        {{ __('Log in') }}
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-500">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-blue-900 font-extrabold hover:underline">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>