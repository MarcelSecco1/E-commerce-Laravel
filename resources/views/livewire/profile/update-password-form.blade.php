<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

use function Livewire\Volt\rules;
use function Livewire\Volt\state;

state([
    'current_password' => '',
    'password' => '',
    'password_confirmation' => '',
]);

rules([
    'current_password' => ['required', 'string', 'current_password'],
    'password' => ['required', 'string', Password::defaults(), 'confirmed'],
]);

$updatePassword = function () {
    try {
        $validated = $this->validate();
    } catch (ValidationException $e) {
        $this->reset('current_password', 'password', 'password_confirmation');

        throw $e;
    }

    Auth::user()->update([
        'password' => Hash::make($validated['password']),
    ]);

    $this->reset('current_password', 'password', 'password_confirmation');

    $this->dispatch('password-updated');
};

?>

<section class="container">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Atualizar senha') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Certifique-se de que sua conta esteja usando uma senha longa e aleatória para permanecer segura.') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-6">
        <div>
            <x-input-label for="update_password_current_password" :value="__('Senha atual')" />
            <x-text-input wire:model.live="current_password" id="update_password_current_password" name="current_password"
                type="password" class="form-control" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2 text-danger" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Nova senha')" class="mt-2" />
            <x-text-input wire:model.live="password" id="update_password_password" name="password" type="password"
                class="form-control" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confime sua senha')" class="mt-2" />
            <x-text-input wire:model.live="password_confirmation" id="update_password_password_confirmation"
                name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger" />
        </div>

        <div class="flex items-center gap-4">
            <button class="btn btn-primary w-25 my-3" type="submit">{{ __('Salvar') }}</button>

            <x-action-message class="alert alert-success text-center" on="password-updated">
                {{ __('Senha atualizada com sucesso.') }}
            </x-action-message>
        </div>
    </form>
</section>
