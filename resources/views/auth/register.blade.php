<x-guest-layout>

    <style>
        input:focus {
            outline: none !important;
            box-shadow: none !important;
            border-color: #e5e7eb !important;
        }
    </style>

    <div class="w-full max-w-md mx-auto min-w-0 rounded-xl overflow-hidden shadow-2xl">

        {{-- Header --}}
        <div class="text-center relative bg-white px-5 sm:px-8 pt-5 sm:pt-6">
            <img src="{{ asset('image/Logo.jpg') }}" alt="Logo"
                class="mx-auto mb-3 w-[min(140px,40vw)] h-[min(140px,40vw)] sm:w-40 sm:h-40 object-contain">
            <h1 class="text-yellow-600 text-lg sm:text-xl font-bold tracking-widest uppercase break-words px-1">
                ລະບົບບັນທືກລາຍຮັບ ແລະ ລາຍຈ່າຍຂອງຄະນະ ວິທະຍາສາດ ທຳມະຊາດ ຄວທ
            </h1>
        </div>

        {{-- Body --}}
        <div class="bg-white px-5 sm:px-8 py-5 sm:py-6 pb-4 sm:pb-2">

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
                    <div class="relative">
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            placeholder="ກະລຸນາໃສ່ລະຫັດຜ່ານ"
                            class="w-full px-4 py-2.5 pr-10 border border-gray-200 rounded-xl bg-gray-50
                                   text-gray-800 text-sm focus:outline-none focus:ring-0
                                   focus:border-gray-200 focus:bg-white transition-all">
                        <button type="button" onclick="togglePasswordField('password', 'eye-open-1', 'eye-closed-1')"
                            style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #9ca3af;">
                            <svg id="eye-open-1" xmlns="http://www.w3.org/2000/svg" style="width:20px; height:20px;"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eye-closed-1" xmlns="http://www.w3.org/2000/svg"
                                style="width:20px; height:20px; display:none;" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.163-3.592M6.53 6.533A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.966 9.966 0 01-4.293 5.411M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                {{-- Confirm Password --}}
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">
                        ຢືນຢັນລະຫັດຜ່ານ
                    </label>
                    <div class="relative">
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            autocomplete="new-password" placeholder="ກະລຸນາໃສ່ລະຫັດຜ່ານອີກຄັ້ງ"
                            class="w-full px-4 py-2.5 pr-10 border border-gray-200 rounded-xl bg-gray-50
                                   text-gray-800 text-sm focus:outline-none focus:ring-0
                                   focus:border-gray-200 focus:bg-white transition-all">
                        <button type="button"
                            onclick="togglePasswordField('password_confirmation', 'eye-open-2', 'eye-closed-2')"
                            style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #9ca3af;">
                            <svg id="eye-open-2" xmlns="http://www.w3.org/2000/svg" style="width:20px; height:20px;"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eye-closed-2" xmlns="http://www.w3.org/2000/svg"
                                style="width:20px; height:20px; display:none;" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.163-3.592M6.53 6.533A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.966 9.966 0 01-4.293 5.411M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
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

    <script>
        function togglePasswordField(inputId, eyeOpenId, eyeClosedId) {
            var input = document.getElementById(inputId);
            var eyeOpen = document.getElementById(eyeOpenId);
            var eyeClosed = document.getElementById(eyeClosedId);

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'block';
            } else {
                input.type = 'password';
                eyeOpen.style.display = 'block';
                eyeClosed.style.display = 'none';
            }
        }
    </script>

</x-guest-layout>
