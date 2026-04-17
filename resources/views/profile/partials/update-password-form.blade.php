<div>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" value="ລະຫັດຜ່ານປັດຈຸບັນ" />
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="mt-2 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" value="ລະຫັດຜ່ານໃໝ່" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-2 block w-full"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" value="ຢືນຢັນລະຫັດຜ່ານ" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-2 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-wrap items-center gap-4 pt-1">
            <button type="submit" class="profile-btn-primary">ບັນທຶກ</button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)" class="text-sm font-medium text-green-700">
                    ບັນທຶກແລ້ວ
                </p>
            @endif
        </div>
    </form>
</div>
