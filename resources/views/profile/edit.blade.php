<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-0.5">
            <p class="text-xs font-semibold text-[#1e3a5f] uppercase tracking-widest">ບັນຊີຜູ້ໃຊ້</p>
            <h2 class="text-xl font-bold text-gray-800">ໂປຣໄຟລ໌</h2>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@400;500;600;700&display=swap');

        .profile-page {
            font-family: 'Noto Sans Lao', 'Figtree', ui-sans-serif, system-ui, sans-serif;
        }

        /* ບໍ່ໃຊ້ transform ທີ່ນີ້ — ມັນຈະກັ່ນ position:fixed ຂອງໂມດັນໃຫ້ຢູ່ໃນກາດແທນທົ່ວໜ້າຈໍ */
        @keyframes profileFade {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .profile-outer {
            min-height: calc(100vh - 80px);
            min-height: calc(100dvh - 80px);
            background: #f0f4f8;
            padding: 2rem 1rem;
        }

        @media (max-width: 640px) {
            .profile-outer {
                padding: 1rem 0.75rem;
            }

            .profile-card-body {
                padding: 18px 16px 22px;
            }

            .profile-card-head {
                padding: 16px 18px;
            }
        }

        .profile-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06), 0 8px 28px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
            animation: profileFade 0.45s ease both;
        }

        .profile-card:nth-child(2) {
            animation-delay: 0.06s;
        }

        .profile-card:nth-child(3) {
            animation-delay: 0.12s;
        }

        .profile-card-head {
            background: linear-gradient(135deg, #0f2744 0%, #1e3a5f 60%, #1a4a7a 100%);
            padding: 18px 22px;
            position: relative;
            overflow: hidden;
        }

        .profile-card-head::before {
            content: '';
            position: absolute;
            top: -32px;
            right: -32px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(240, 180, 41, 0.08);
        }

        .profile-card-head-inner {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .profile-card-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(240, 180, 41, 0.14);
            border: 1px solid rgba(240, 180, 41, 0.22);
            color: #f0b429;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .profile-card-icon svg {
            width: 18px;
            height: 18px;
            stroke-width: 2.2;
        }

        .profile-card-head h3 {
            margin: 0;
            color: #fff;
            font-size: 1rem;
            font-weight: 800;
            letter-spacing: -0.01em;
        }

        .profile-card-head .sub {
            margin: 6px 0 0;
            color: rgba(255, 255, 255, 0.68);
            font-size: 0.8rem;
            line-height: 1.45;
        }

        .profile-card-body {
            padding: 22px 24px 26px;
        }

        .profile-page .profile-card-body input[type='text'],
        .profile-page .profile-card-body input[type='email'],
        .profile-page .profile-card-body input[type='password'] {
            border-radius: 12px !important;
            border-color: #e2e8f0 !important;
            padding: 0.6rem 0.9rem !important;
            font-size: 0.9rem;
        }

        .profile-page .profile-card-body input:focus {
            border-color: #1e3a5f !important;
            box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.12) !important;
            outline: none !important;
            --tw-ring-color: transparent !important;
        }

        .profile-page .profile-card-body label {
            font-size: 0.68rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .profile-btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #1e3a5f, #0f2744);
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(30, 58, 95, 0.25);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .profile-btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(30, 58, 95, 0.3);
        }
    </style>

    <div class="py-6 sm:py-8 profile-page w-full min-w-0">
        <div class="profile-outer max-w-3xl mx-auto w-full min-w-0 px-3 sm:px-6 space-y-5 sm:space-y-6">

            <div class="profile-card">
                <div class="profile-card-head">
                    <div class="profile-card-head-inner">
                        <div class="profile-card-icon" aria-hidden="true">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                        <div>
                            <h3>ຂໍ້ມູນໂປຣໄຟລ໌</h3>
                            <p class="sub">ແກ້ໄຂຊື່-ນາມສະກຸນ ແລະ ຊື່ຜູ້ໃຊ້ຂອງທ່ານ</p>
                        </div>
                    </div>
                </div>
                <div class="profile-card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="profile-card">
                <div class="profile-card-head">
                    <div class="profile-card-head-inner">
                        <div class="profile-card-icon" aria-hidden="true">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 10.5V6.75a4.5 4.5 0 00-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        <div>
                            <h3>ປ່ຽນລະຫັດຜ່ານ</h3>
                            <p class="sub">ໃຊ້ລະຫັດຜ່ານທີ່ຍາວ ແລະ ຄາດເດົາຍາກ ເພື່ອຄວາມປອດໄພຂອງບັນຊີ</p>
                        </div>
                    </div>
                </div>
                <div class="profile-card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="profile-card">
                <div class="profile-card-head">
                    <div class="profile-card-head-inner">
                        <div class="profile-card-icon" aria-hidden="true">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </div>
                        <div>
                            <h3>ລຶບບັນຊີ</h3>
                            <p class="sub">
                                ເມື່ອລຶບບັນຊີແລ້ວ ຂໍ້ມູນ ແລະ ຊັບພະຍາກອນທັງໝົດຈະຖືກລຶບຖາວອນ ກະລຸນາດາວໂຫຼດຂໍ້ມູນທີ່ຕ້ອງການເກັບໄວ້ກ່ອນລຶບ
                            </p>
                        </div>
                    </div>
                </div>
                <div class="profile-card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
