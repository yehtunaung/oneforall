<div class="md:grid">
    <div class="md:mt-0 md:col-span-2">
        <div class="px-4 sm:p-6 sm:rounded-lg bg-white dark:bg-gray-800">
            <div class="text-gray-900 dark:text-white text-lg font-bold mb-3">
                {{ __('Two Factor Authentication') }}
            </div>
            <div class="text-gray-900 dark:text-white">
                {{ __('Add additional security to your account using two factor authentication.') }}
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                @if ($this->enabled)
                    @if ($showingConfirmation)
                        {{ __('Finish enabling two factor authentication.') }}
                    @else
                        {{ __('You have enabled two factor authentication.') }}
                    @endif
                @else
                    {{ __('You have not enabled two factor authentication.') }}
                @endif
            </h3>

            <div class="mt-3 max-w-xl text-sm text-gray-600 dark:text-gray-400">
                <p>
                    {{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}
                </p>
            </div>

            @if ($this->enabled)
                @if ($showingQrCode)
                    <div class="mt-4 max-w-xl text-sm text-gray-600 dark:text-gray-400">
                        <p class="font-semibold">
                            @if ($showingConfirmation)
                                {{ __('To finish enabling two factor authentication, scan the following QR code using your phone\'s authenticator application or enter the setup key and provide the generated OTP code.') }}
                            @else
                                {{ __('Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application or enter the setup key.') }}
                            @endif
                        </p>
                    </div>

                    <div class="mt-4 p-2 inline-block bg-white dark:bg-gray-700">
                        {!! $this->user->twoFactorQrCodeSvg() !!}
                    </div>

                    <div class="mt-4 max-w-xl text-sm text-gray-600 dark:text-gray-400">
                        <p class="font-semibold">
                            {{ __('Setup Key') }}: {{ decrypt($this->user->two_factor_secret) }}
                        </p>
                    </div>

                    @if ($showingConfirmation)
                        <div class="mt-4">
                            <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Code') }}</label>
                            <input id="code" type="text" name="code" class="block mt-1 w-1/2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" inputmode="numeric" autofocus autocomplete="one-time-code" wire:model="code" wire:keydown.enter="confirmTwoFactorAuthentication" />
                            @error('code')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                @endif

                @if ($showingRecoveryCodes)
                    <div class="mt-4 max-w-xl text-sm text-gray-600 dark:text-gray-400">
                        <p class="font-semibold">
                            {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}
                        </p>
                    </div>

                    <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 dark:bg-gray-700 rounded-lg">
                        @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                            <div class="text-gray-900 dark:text-gray-200">{{ $code }}</div>
                        @endforeach
                    </div>
                @endif
            @endif

            <div class="mt-5">
                @if (!$this->enabled)
                    <button type="button" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 disabled:opacity-25 transition dark:bg-indigo-500 dark:hover:bg-indigo-400 dark:focus:ring-indigo-300" wire:loading.attr="disabled" wire:click="enableTwoFactorAuthentication">
                        {{ __('Enable') }}
                    </button>
                @else
                    @if ($showingRecoveryCodes)
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-500" wire:loading.attr="disabled" wire:click="regenerateRecoveryCodes">
                            {{ __('Regenerate Recovery Codes') }}
                        </button>
                    @elseif ($showingConfirmation)
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 disabled:opacity-25 transition dark:bg-indigo-500 dark:hover:bg-indigo-400 dark:focus:ring-indigo-300" wire:loading.attr="disabled" wire:click="confirmTwoFactorAuthentication">
                            {{ __('Confirm') }}
                        </button>
                    @else
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-500" wire:loading.attr="disabled" wire:click="showRecoveryCodes">
                            {{ __('Show Recovery Codes') }}
                        </button>
                    @endif

                    @if ($showingConfirmation)
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-500" wire:loading.attr="disabled" wire:click="disableTwoFactorAuthentication">
                            {{ __('Cancel') }}
                        </button>
                    @else
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 disabled:opacity-25 transition dark:bg-red-500 dark:hover:bg-red-400 dark:focus:ring-red-300" wire:loading.attr="disabled" wire:click="disableTwoFactorAuthentication">
                            {{ __('Disable') }}
                        </button>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>