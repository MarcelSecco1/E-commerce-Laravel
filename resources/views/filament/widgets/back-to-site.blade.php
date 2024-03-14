@php
    $user = filament()->auth()->user();
@endphp

<x-filament-widgets::widget class="fi-account-widget">
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            {{-- <x-filament-panels::avatar.user size="lg" :user="$user" /> --}}

            <div class="flex-1">
                <h2 class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white">
                    {{ filament()->getUserName($user) }}
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Clique aqui caso deseja sair do painel de administração.') }}
                </p>
            </div>

            <form action="{{ filament()->getLogoutUrl() }}" method="post" class="my-auto">
                @csrf

                <x-filament::link color="gray" icon="heroicon-m-arrow-top-right-on-square" labeled-from="sm"
                    href="{{ url('/') }}">
                    {{ __('Voltar para o site') }}
                </x-filament::link>
            </form>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
