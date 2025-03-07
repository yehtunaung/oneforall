<div>
    <x-admin.pages-header title="Users" :breadcrumbs="[['label' => 'Users', 'url' => route('admin.user')], ['label' => 'Create']]" :permission="false" />

    <x-admin.create-card>
        <form wire:submit.prevent="store">
            <div class="py-3">
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full sm:w-1/2 lg:w-1/3 px-2 mb-4">
                        <x-admin.label for="name" label="User Name" required="true" />
                        <x-admin.inputs.input id="name" label="Name" type="text" wire:model="name"
                            class="additional-classes" error="{{ $errors->has('name') }}" />
                        @error('name')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="w-full sm:w-1/2 lg:w-1/3 px-2 mb-4">
                        <x-admin.label for="email" label="Email" required="true" />
                        <x-admin.inputs.input id="email" label="Email" type="email" wire:model="email"
                            class="additional-classes" error="{{ $errors->has('email') }}" />
                        @error('email')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="w-full lg:w-1/3 px-2 mb-4">
                        <x-admin.label for="password" label="Password" required="true" />
                        <x-admin.inputs.input id="password" label="Password" type="password" wire:model="password"
                            class="additional-classes" error="{{ $errors->has('password') }}" />
                        @error('password')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <x-admin.save-button function="store">
                    {{ __('Save') }}
                    </x-save-button>
                    <x-admin.inputs.button-secondary type="button" href="{{ route('admin.user') }}" wire:navigate>
                        {{ __('Cancel') }}
                    </x-admin.inputs.button-secondary>
            </div>
        </form>
    </x-admin.create-card>
</div>
