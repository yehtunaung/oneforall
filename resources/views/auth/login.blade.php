<x-guest-layout>
    <x-admin.auth.authentication-card>
        <x-slot name="logo">
            <x-admin.auth.authentication-card-logo />
        </x-slot>

        <x-admin.auth.validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-admin.label for="email" value="{{ __('Email') }}" />
                <x-admin.inputs.input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"  autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-admin.label for="password" value="{{ __('Password') }}" />
                <x-admin.inputs.input id="password" class="block mt-1 w-full" type="password" name="password"  autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-admin.inputs.checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-admin.inputs.button-primary class="ms-4">
                    {{ __('Log in') }}
                </x-admin.inputs.button-primary>
            </div>
        </form>
    </x-admin.auth.authentication-card>
</x-guest-layout>
