<x-guest-layout>
    <form id="registrationForm" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autofocus
                autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4 form-group">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4 form-group">
            <label for="role_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
            <select id="role_id" class="custom-input-text" name="role_id">
                <option selected value="">Select role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
            {{-- <div class="col-span-2">
            </div> --}}
        </div>

        <div class="mt-4 form-group">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4 form-group">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <x-primary-button class="mt-1 w-full flex justify-center items-center">
                {{ __('Register') }}
            </x-primary-button>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="custom-redirection-link" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>
    </form>
</x-guest-layout>
