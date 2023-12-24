<div class="px-2 py-1">

    @if ($hoursConfirmed)
        <div x-data="{ showSuccessMessage: @entangle('hoursConfirmed') }">
            <p x-init="setTimeout(() => showSuccessMessage = false, 4000)" x-show="showSuccessMessage" x-transition.duration.2000ms
                class="bg-green-50 text-green-500 border border-green-500 p-2 font-medium text-center">
                Hours Confirmed, Thank you!
            </p>
        </div>
    @endif

    <div class="shadow-lg border-2">
        <div class="flex justify-between items-center px-1">
            <div class="text-sm py-3 font-medium">Rota for {{ $staff->name }}</div>
            <div>Gross Earnings This Week: £{{ $weeklyHours->total_earnings ?? 0.0 }}</div>
        </div>

        <div class="flex justify-between items-center bg-blue-100 px-1 py-2">
            <p class="">
                <span class="font-semibold">Hours This Week:</span>
                <span class="border py-1 px-2 bg-white font-semibold">{{ $weeklyHours->total_hours ?? 0 }}</span>
            </p>

            @if (is_null($staff->confirmed_hours))
                <div class="flex gap-x-2">
                    <div class="bg-green-500 p-1 text-white cursor-pointer">
                        <p wire:click="confirmHours(1)">Confirm</p>
                    </div>

                    <div class="bg-red-500 p-1 text-white cursor-pointer">
                        <p wire:click="confirmHours(0)">Dispute</p>
                    </div>
                </div>
            @endif

            @if ($staff->confirmed_hours)
                <div class="bg-green-400 p-1 text-white">Confirmed</div>
            @endif

            @if ($staff->confirmed_hours === 0)
                <div class="bg-red-400 p-1 text-white">Disputed</div>
            @endif
        </div>
    </div>

    <div class="shadow-lg border-2 my-4 px-2 py-4">
        <div class="py-2 flex gap-x-4 items-end border-b">
            <div class="flex flex-col">
                <p class="">From</p>
                <input type="date" id="bobo" name="filterStartDate" wire:model="filterStartDate" />
            </div>
            <div class="flex flex-col">
                <p>To</p>
                <input type="date" name="filterEndDate" wire:model="filterEndDate" />
            </div>
            <div class="bg-blue-500 text-white py-2 px-3 cursor-pointer">
                <p wire:click="filter" class="py-1 text-sm">Filter</p>
            </div>
            <div class="bg-orange-500 text-white py-2 px-3 cursor-pointer">
                <p wire:click="clearFilters" class="py-1 text-sm">Clear Filter</p>
            </div>
        </div>

        {{-- dd($staffHours) --}}

        @foreach ($staffHours as $staffShift)
            {{-- {{ dd($staffShift) }} --}}
            <div class="p-1 border-b even:bg-blue-50 flex items-center w-full">
                <div class="w-full py-2">
                    <div class="flex font-semibold">
                        <p class="w-1/3">Company</p>
                        <p class="w-1/3">Starting</p>
                        <p class="w-1/3">Ending</p>
                    </div>

                    <div class="flex items-center">
                        <p class="w-1/3">{{ $staffShift->company }}</p>
                        <p class="w-1/3">{{ $staffShift->start_date }}</p>
                        <p class="w-1/3">{{ $staffShift->end_date }}</p>
                        {{-- <p class="w-1/4 h-full">Cancel Shift</p> --}}
                    </div>
                </div>

                @if ($staffShift->as_planned && auth()->user()->is_admin)
                    <div wire:click="cancelShift({{ $staffShift->shiftId }})"
                        class="hover:bg-red-600 cursor-pointer bg-red-500 text-white p-1 text-xs rounded whitespace-nowrap">
                        Cancel Shift
                    </div>
                @endif

                @if (!$staffShift->as_planned)
                    <div class="cursor-not-allowed bg-red-300 text-white p-1 text-xs rounded whitespace-nowrap">
                        Cancelled
                    </div>
                @endif
            </div>
        @endforeach
    </div>

</div>
