<div class="space-y-5">
    <x-danger-button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="!rounded-xl !py-2.5 !px-5 !font-bold !normal-case !tracking-normal !shadow-md hover:!brightness-95">
        ລຶບບັນຊີ
    </x-danger-button>

    <x-modal name="confirm-user-deletion" maxWidth="md" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 sm:p-8">
            @csrf
            @method('delete')

            <div
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-red-600 border border-red-100 mb-4">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <h2 class="text-lg font-bold text-gray-900">
                ທ່ານແນ່ໃຈບໍ່ວ່າຕ້ອງການລຶບບັນຊີ?
            </h2>

            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                ເມື່ອກົດລົບແລ້ວ ຂໍ້ມູນທັງໝົດຈະຖືກລຶບຖາວອນ ກະລຸນາປ້ອນລະຫັດຜ່ານເພື່ອຢືນຢັນການລຶບບັນຊີ
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="ລະຫັດຜ່ານ" class="sr-only" />

                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full sm:max-w-md"
                    placeholder="ລະຫັດຜ່ານ" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex flex-wrap justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')"
                    class="!rounded-xl !border-slate-200 !text-slate-700">
                    ຍົກເລີກ
                </x-secondary-button>

                <x-danger-button class="!rounded-xl !ms-0">
                    ລຶບບັນຊີ
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</div>
