<x-app-layout>
    <div class="">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{$staff->name}}
            </h2>
        </x-slot>

        {{-- $staff --}}

        <livewire:staff.assign-shifts :staff="$staff" />

    </div>
</x-app-layout>
