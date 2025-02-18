<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <h2 class="mb-4">
            松陰塾飯田殿岡校
        </h2>
        <div>
            <x-input-label for="user_id" :value="__('ユーザーID')" />
            <x-text-input id="user_id" class="block mt-1 w-full" name="user_id" :value="old('user_id')" required autofocus autocomplete="user_id" />
            <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <!-- <p class="mb-4 text-xs">(※)ID・パスワードが違う場合や、退塾した生徒はログインできません。</p> -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
