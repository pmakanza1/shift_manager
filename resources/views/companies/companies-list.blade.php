<x-app-layout>
    <div class="">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Companies') }}
            </h2>
        </x-slot>

        <livewire:company.companies-list />
    </div>
</x-app-layout>
