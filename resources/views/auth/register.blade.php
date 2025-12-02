<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- admin_firstName -->
        <div>
            <x-input-label for="admin_firstName" :value="__('Имя')" />
            <x-text-input id="admin_firstName" class="block mt-1 w-full" type="text" name="admin_firstName" :value="old('admin_firstName')" required autofocus autocomplete="admin_firstName" />
            <x-input-error :messages="$errors->get('admin_firstName')" class="mt-2" />
        </div>

        <!-- admin_lastName -->
        <div>
            <x-input-label for="admin_lastName" :value="__('Фамилия')" />
            <x-text-input id="admin_lastName" class="block mt-1 w-full" type="text" name="admin_lastName" :value="old('admin_lastName')" required autofocus autocomplete="admin_lastName" />
            <x-input-error :messages="$errors->get('admin_lastName')" class="mt-2" />
        </div>

        <!-- admin_middleName -->
        <div>
            <x-input-label for="admin_middleName" :value="__('Отчество (необязательно)')" />
            <x-text-input id="admin_middleName" class="block mt-1 w-full" type="text" name="admin_middleName" :value="old('admin_middleName')" autofocus autocomplete="admin_middleName" />
            <x-input-error :messages="$errors->get('admin_middleName')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="admin_email" :value="__('Email')" />
            <x-text-input id="admin_email" class="block mt-1 w-full" type="email" name="admin_email" :value="old('admin_email')" required autocomplete="admin_email" />
            <x-input-error :messages="$errors->get('admin_email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="admin_password" :value="__('Password')" />

            <x-text-input id="admin_password" class="block mt-1 w-full"
                            type="password"
                            name="admin_password"
                            required autocomplete="new-admin_password" />

            <x-input-error :messages="$errors->get('admin_password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="admin_password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="admin_password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="admin_password_confirmation" required autocomplete="new-admin_password" />

            <x-input-error :messages="$errors->get('admin_password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
