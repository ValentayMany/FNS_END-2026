<div>
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="full_name" value="ຊື່-ນາມສະກຸນ" />
            <x-text-input id="full_name" name="full_name" type="text" class="mt-2 block w-full"
                :value="old('full_name', $user->full_name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
        </div>

        <div>
            <x-input-label for="username" value="ຊື່ຜູ້ໃຊ້" />
            <x-text-input id="username" name="username" type="text" class="mt-2 block w-full"
                :value="old('username', $user->username)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div class="flex flex-wrap items-center gap-4 pt-1">
            <button type="submit" class="profile-btn-primary">ບັນທຶກ</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)" class="text-sm font-medium text-green-700">
                    ບັນທຶກແລ້ວ
                </p>
            @endif
        </div>
    </form>
</div>
