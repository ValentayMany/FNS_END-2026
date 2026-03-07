<x-guest-layout>

    {{-- แสดง success message หลัง register --}}
    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Full Name -->
        <div>
            <x-input-label for="full_name" :value="__('ຊື່-ນາມສະກຸນ')" />
            <x-text-input id="full_name" class="block mt-1 w-full" type="text"
                name="full_name" :value="old('full_name')" required autofocus />
            <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
        </div>

        <!-- Username -->
        <div class="mt-4">
            <x-input-label for="username" :value="__('ຊື່ຜູ້ໃຊ້ (Username)')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text"
                name="username" :value="old('username')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('ລະຫັດຜ່ານ')" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password" name="password"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('ຢືນຢັນລະຫັດຜ່ານ')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password" name="password_confirmation"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900"
               href="{{ route('login') }}">
                {{ __('ມີບັນຊີຢູ່ແລ້ວ?') }}
            </a>
            <x-primary-button class="ms-4">
                {{ __('ລົງທະບຽນ') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
