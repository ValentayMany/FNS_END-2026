<x-guest-layout>

    <style>
        input:focus {
            outline: none !important;
            box-shadow: none !important;
            border-color: #e5e7eb !important;
        }
    </style>

    <div lang="lo" class="w-full max-w-md mx-auto min-w-0 rounded-xl overflow-hidden shadow-2xl">

        {{-- Header --}}
        <div class="px-5 sm:px-8 py-5 sm:py-6 text-center relative bg-white">
            <img src="{{ asset('image/Logo.jpg') }}" alt="Logo"
                class="mx-auto mb-3 w-[min(140px,40vw)] h-[min(140px,40vw)] sm:w-40 sm:h-40 object-contain">
            <h1 class="text-lg sm:text-xl font-bold tracking-widest lowercase break-words px-1" style="color: #eab308;">
                ລະບົບລາຍຮັບ ແລະ ລາຍຈ່າຍຂອງຄະນະ
            </h1>
        </div>

        {{-- Body --}}
        <div class="bg-white px-5 sm:px-8 py-2 pb-4 sm:pb-2">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                        ✓ {{ session('success') }}
                    </div>
                @endif

                {{-- Username --}}
                <div class="mb-4">
                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-1">
                        ຊື່ຜູ້ໃຊ້
                    </label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required
                        autofocus autocomplete="username" placeholder="ກະລຸນາໃສ່ຊື່ຜູ້ໃຊ້"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50
                                  text-gray-800 text-sm focus:outline-none focus:ring-0
                                  focus:border-gray-200 focus:bg-white transition-all">
                    <x-input-error :messages="$errors->get('username')" class="mt-1" />
                </div>

                {{-- Password --}}
                <div class="mb-5">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">
                        ລະຫັດຜ່ານ
                    </label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            placeholder="ກະລຸນາໃສ່ລະຫັດຜ່ານ"
                            class="w-full px-4 py-2.5 pr-10 border border-gray-200 rounded-xl bg-gray-50
                      text-gray-800 text-sm focus:outline-none focus:ring-0
                      focus:border-gray-200 focus:bg-white transition-all">

                        <button type="button" id="toggle-password" onclick="togglePassword()"
                            style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #9ca3af;">

                            {{-- Eye Open --}}
                            <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" style="width:20px; height:20px;"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                         -1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>

                            {{-- Eye Closed --}}
                            <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg"
                                style="width:20px; height:20px; display:none;" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7
                         a9.97 9.97 0 012.163-3.592M6.53 6.533A9.956 9.956 0 0112 5
                         c4.477 0 8.268 2.943 9.542 7a9.966 9.966 0 01-4.293 5.411
                         M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <script>
                    function togglePassword() {
                        var input = document.getElementById('password');
                        var eyeOpen = document.getElementById('eye-open');
                        var eyeClosed = document.getElementById('eye-closed');

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

                {{-- Remember Me --}}
                <div class="flex items-center mb-6">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="w-4 h-4 rounded border-gray-300 cursor-pointer mt-2">
                    <label for="remember_me" class="ms-2 text-sm text-gray-500 cursor-pointer mt-2">
                        ຈົດຈຳການເຂົ້າສູ່ລະບົບ
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="btn-wave w-full py-3 text-white font-semibold text-sm rounded-xl tracking-wide shadow-lg transition-all duration-200"
                    style="background: linear-gradient(135deg, #1e3a5f, #0f2744);"
                    onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    ເຂົ້າສູ່ລະບົບ
                </button>

                {{-- Divider --}}
                <div class="h-px bg-gray-100 my-5"></div>

                @if (config('fns.allow_registration'))
                    <p class="text-center text-sm text-gray-400 mt-2">
                        ຍັງບໍ່ມີບັນຊີ?
                        <a href="{{ route('register') }}" class="font-semibold hover:underline" style="color: #1e3a5f;">
                            ສະໝັກໃຊ້ງານ
                        </a>
                    </p>
                @endif

            </form>
        </div>
    </div>
</x-guest-layout>
