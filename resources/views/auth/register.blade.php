<x-guest-layout>
    <div class="fixed inset-0 min-h-screen w-full bg-gradient-to-br from-slate-950 via-blue-950 to-slate-950 flex items-center justify-center p-4 overflow-y-auto">
        
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 border border-gray-100 my-auto">
            
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-black text-gray-800 tracking-tight">Daftar BengTix</h2>
                <p class="text-xs text-gray-400 mt-1">Buat akun baru untuk mulai menjelajahi event seru</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Name')" class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block" />
                    <x-text-input id="name" class="block w-full rounded-xl border-gray-300 focus:border-blue-900 focus:ring-blue-900/20 text-sm py-2.5 px-4 text-gray-800 shadow-sm" 
                        type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Lengkap" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-red-600 font-medium" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block" />
                    <x-text-input id="email" class="block w-full rounded-xl border-gray-300 focus:border-blue-900 focus:ring-blue-900/20 text-sm py-2.5 px-4 text-gray-800 shadow-sm" 
                        type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="masukan email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-600 font-medium" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block" />
                    <x-text-input id="password" class="block w-full rounded-xl border-gray-300 focus:border-blue-900 focus:ring-blue-900/20 text-sm py-2.5 px-4 text-gray-800 shadow-sm"
                        type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-600 font-medium" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block" />
                    <x-text-input id="password_confirmation" class="block w-full rounded-xl border-gray-300 focus:border-blue-900 focus:ring-blue-900/20 text-sm py-2.5 px-4 text-gray-800 shadow-sm"
                        type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-red-600 font-medium" />
                </div>

                <div class="pt-3">
                    <button type="submit" class="w-full bg-blue-900 hover:bg-blue-950 text-white font-bold rounded-xl py-3 text-sm transition duration-200 shadow-lg shadow-blue-900/10 active:scale-[0.98]">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-500">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-900 font-extrabold hover:underline">Log in di sini</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>