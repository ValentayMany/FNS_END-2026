<x-guest-layout>

    <style>
        input:focus {
            outline: none !important;
            box-shadow: none !important;
            border-color: #e5e7eb !important;
        }
    </style>

    <div class="w-full max-w-md mx-auto rounded-xl overflow-hidden shadow-2xl">

        {{-- Header --}}
        <div class=" text-center relative bg-white">
            <img src="{{ asset('image/Logo.jpg') }}" alt="Logo" class="mx-auto mb-3"
                style="height: 160px; width: 160px;">
            <h1 class="text-yellow-600 text-xl font-bold tracking-widest uppercase">
                ລະບົບລາຍຮັບ ແລະ ລາຍຈ່າຍຂອງຄະນະ
            </h1>
        </div>

        {{-- Body --}}
        <div class="bg-white px-8 py-6 pb-2">

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Full Name --}}
                <div class="mb-4">
                    <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-1">
                        ຊື່-ນາມສະກຸນ
                    </label>
                    <input id="full_name" type="text" name="full_name" value="{{ old('full_name') }}" required
                        autofocus placeholder="ກະລຸນາໃສ່ຊື່-ນາມສະກຸນ"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50
                               text-gray-800 text-sm focus:outline-none focus:ring-0
                               focus:border-gray-200 focus:bg-white transition-all">
                    <x-input-error :messages="$errors->get('full_name')" class="mt-1" />
                </div>

                {{-- Username --}}
                <div class="mb-4">
                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-1">
                        ຊື່ຜູ້ໃຊ້
                    </label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required
                        autocomplete="username" placeholder="ກະລຸນາໃສ່ຊື່ຜູ້ໃຊ້"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50
                               text-gray-800 text-sm focus:outline-none focus:ring-0
                               focus:border-gray-200 focus:bg-white transition-all">
                    <x-input-error :messages="$errors->get('username')" class="mt-1" />
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">
                        ລະຫັດຜ່ານ
                    </label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        placeholder="ກະລຸນາໃສ່ລະຫັດຜ່ານ"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50
                               text-gray-800 text-sm focus:outline-none focus:ring-0
                               focus:border-gray-200 focus:bg-white transition-all">
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                {{-- Confirm Password --}}
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">
                        ຢືນຢັນລະຫັດຜ່ານ
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        autocomplete="new-password" placeholder="ກະລຸນາໃສ່ລະຫັດຜ່ານອີກຄັ້ງ"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50
                               text-gray-800 text-sm focus:outline-none focus:ring-0
                               focus:border-gray-200 focus:bg-white transition-all">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="btn-wave w-full py-3 text-white font-semibold text-sm rounded-xl tracking-wide shadow-lg transition-all duration-200"
                    style="background: linear-gradient(135deg, #1e3a5f, #0f2744);"
                    onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    ລົງທະບຽນ
                </button>
                {{-- Login --}}
                <div class="h-px bg-gray-100 my-5"></div>
                <p class="text-center text-sm text-gray-400 mt-2 ">
                    ມີບັນຊີຢູ່ແລ້ວ?
                    <a href="{{ route('login') }}" class="font-semibold hover:underline" style="color: #1e3a5f;">
                        ເຂົ້າສູ່ລະບົບ
                    </a>
                </p>

            </form>
        </div>
    </div>

</x-guest-layout>
