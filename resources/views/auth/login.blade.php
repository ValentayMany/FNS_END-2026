<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
        @endif

        <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('ຊື່ຜູ້ໃຊ້')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text"
                name="username" :value="old('username')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('ລະຫັດຜ່ານ')" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password" name="password"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <span class="ms-2 text-sm text-gray-600">{{ __('ຈົດຈຳການເຂົ້າສູ່ລະບົບ') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900"
               href="{{ route('register') }}">
                {{ __('ຍັງບໍ່ມີບັນຊີ?') }}
            </a>
            <x-primary-button class="ms-4">
                {{ __('ເຂົ້າສູ່ລະບົບ') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
