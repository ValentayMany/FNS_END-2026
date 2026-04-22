<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-0.5">
            <p class="text-xs font-medium text-indigo-400 uppercase tracking-widest">ບັນຊີຜູ້ໃຊ້</p>
            <h2 class="text-lg sm:text-xl font-bold text-gray-800">ໂປຣໄຟລ໌</h2>
        </div>
    </x-slot>

    <style>
        .profile-page .fns-card-body input[type='text'],
        .profile-page .fns-card-body input[type='email'],
        .profile-page .fns-card-body input[type='password'] {
            border-radius: 12px !important;
            border-color: #e2e8f0 !important;
            padding: 0.6rem 0.9rem !important;
            font-size: 0.875rem !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
            width: 100% !important;
        }

        .profile-page .fns-card-body input:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15) !important;
            outline: none !important;
            --tw-ring-color: transparent !important;
        }

        .profile-page .fns-card-body label {
            font-size: 0.8rem !important;
            font-weight: 600 !important;
            color: #4b5563 !important;
            margin-bottom: 0.25rem !important;
            display: block !important;
        }
        
        .profile-page button.inline-flex.items-center {
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
            padding: 0.6rem 1.2rem !important;
            background: #6366f1 !important;
            color: white !important;
            font-weight: 600 !important;
            font-size: 0.875rem !important;
            border-radius: 0.5rem !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            transition: all 0.2s !important;
            border: none !important;
        }
        
        .profile-page button.inline-flex.items-center:hover {
            background: #4f46e5 !important;
        }
    </style>

    <div class="py-6 sm:py-8 profile-page w-full min-w-0 flex-1">
        <div class="max-w-3xl mx-auto w-full min-w-0 px-3 sm:px-4 space-y-5 sm:space-y-6">

            <div class="fns-card fns-animate">
                <div class="fns-card-header">
                    <div class="flex items-center gap-3">
                        <div class="fns-card-header-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                        </div>
                        <div>
                            <h3 class="fns-card-title">ຂໍ້ມູນໂປຣໄຟລ໌</h3>
                            <p class="fns-card-subtitle">ແກ້ໄຂຊື່-ນາມສະກຸນ ແລະ ຊື່ຜູ້ໃຊ້ຂອງທ່ານ</p>
                        </div>
                    </div>
                </div>
                <div class="fns-card-body p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="fns-card fns-animate fns-animate-delay-1">
                <div class="fns-card-header">
                    <div class="flex items-center gap-3">
                        <div class="fns-card-header-icon" style="background:#f5f3ff; color:#7c3aed;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 10.5V6.75a4.5 4.5 0 00-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                        </div>
                        <div>
                            <h3 class="fns-card-title">ປ່ຽນລະຫັດຜ່ານ</h3>
                            <p class="fns-card-subtitle">ໃຊ້ລະຫັດຜ່ານທີ່ຍາວ ແລະ ຄາດເດົາຍາກ ເພື່ອຄວາມປອດໄພຂອງບັນຊີ</p>
                        </div>
                    </div>
                </div>
                <div class="fns-card-body p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="fns-card fns-animate fns-animate-delay-2">
                <div class="fns-card-header">
                    <div class="flex items-center gap-3">
                        <div class="fns-card-header-icon" style="background:#fef2f2; color:#dc2626;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                        </div>
                        <div>
                            <h3 class="fns-card-title">ລຶບບັນຊີ</h3>
                            <p class="fns-card-subtitle">
                                ເມື່ອລຶບບັນຊີແລ້ວ ຂໍ້ມູນ ແລະ ຊັບພະຍາກອນທັງໝົດຈະຖືກລຶບຖາວອນ
                            </p>
                        </div>
                    </div>
                </div>
                <div class="fns-card-body p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
