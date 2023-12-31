<x-app-layout>
    <div class="">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Company Hours') }}
            </h2>
        </x-slot>

        <livewire:company.company-hours />
    </div>
</x-app-layout>
