<x-app-layout>
    <div x-data="{ tab: 'showRota' }" class="">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $staff->name }}
            </h2>
        </x-slot>

        @if (auth()->user()->is_admin)
            <div class="flex items-center gap-x-4 py-2 border-b bg-blue-100 font-semibold">
                <p @click="tab = 'assignShifts'" :class="tab === 'assignShifts' ? 'border-indigo-500' : 'border-indigo-200'"
                    class="cursor-pointer border-2 shadow-sm px-2 py-1 bg-blue-200">
                    Assign Shifts
                </p>
                <p @click="tab = 'showRota'" :class="tab === 'showRota' ? 'border-indigo-500' : 'border-indigo-200'"
                    class="cursor-pointer border-2 border-indigo-200 shadow-sm px-2 py-1 bg-blue-200">
                    View Rota
                </p>
            </div>

            <div x-show="tab === 'assignShifts'" class="">
                <livewire:staff.assign-shifts :staff="$staff" />
            </div>
        @endif

        <div class="px-2 py-1" x-show="tab === 'showRota'">
            <livewire:staff.staff-shifts :staff="$staff" />
        </div>
    </div>
</x-app-layout>
