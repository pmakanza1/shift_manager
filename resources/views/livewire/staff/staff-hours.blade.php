<div class="px-3">
    <div class="flex items-center justify-between gap-x-2 py-3">
        <div class="w-full">
            <input wire:model.live="searchTerm" name="searchTerm" class="border border-gray-300 rounded w-full"
                type="search" placeholder="Search by Email, Name ..." />
        </div>
    </div>

    {{--  <div class="py-2 flex gap-x-4 items-end">

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

        <div wire:click="promptHours" class="bg-green-500 text-white py-2 px-3 cursor-pointer">
            <p class="py-1 text-sm">Prompt For Hours</p>
        </div>
    </div> --}}


    <div class="py-2 flex flex-col md:flex-row gap-x-4 md:items-end border-b">
        <div class="flex flex-col md:flex-row gap-x-4">
            <div class="flex flex-col w-full">
                <p class="">From</p>
                <input type="date" id="bobo" name="filterStartDate" wire:model="filterStartDate" />
            </div>

            <div class="flex flex-col">
                <p>To</p>
                <input type="date" name="filterEndDate" wire:model="filterEndDate" />
            </div>
        </div>

        <div class="flex gap-x-1 py-3 md:py-0">
            <div class="bg-blue-500 text-white py-2 px-3 cursor-pointer">
                <p wire:click="filter" class="py-1 text-sm">Filter</p>
            </div>

            @if (!$allStaff)
                <div wire:click="showAllStaff" class="bg-purple-500 text-white py-2 px-3 cursor-pointer">
                    <p class="py-1 text-sm">Show All Staff</p>
                </div>
            @endif

            @if ($allStaff)
                <div wire:click="showHours" class="bg-purple-500 text-white py-2 px-3 cursor-pointer">
                    <p class="py-1 text-sm">Show Hours</p>
                </div>
            @endif

            <div class="bg-orange-500 text-white py-2 px-3 cursor-pointer">
                <p wire:click="clearFilters" class="py-1 text-sm">Clear Filter</p>
            </div>

            <div wire:click="promptHours" class="bg-green-500 text-white py-2 px-3 cursor-pointer">
                <p class="py-1 text-sm">Prompt For Hours</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col w-full">
        <div class="hidden md:flex bg-blue-500 text-white text-sm items-center font-semibold w-full p-1">
            <p class="w-3/12">Name</p>
            <p class="w-3/12">Email</p>
            <p class="w-3/12">Phone</p>
            <p class="w-1/12">Completed Hours</p>
            <p class="w-1/12">Cancelled Hours</p>
            <p class="w-1/12">Gross Earnings</p>
        </div>

        <div class="flex flex-col w-full">
            @foreach ($staffHours as $stf)
                {{-- @dump($stf) --}}
                <div wire:key="'staff-'{{ $stf->staff_id }}"
                    class="flex flex-col space-y-2 md:space-y-0 overflow-auto md:flex-row w-full {{ $this->getBackground($stf->confirmed) }} py-2 px-1 mb-2 rounded">
                    <div class="md:w-3/12 flex font-semibold gap-x-2">
                        <div class="md:hidden">Name:</div>
                        <a href="{{ route('staff.show', $stf->staff_id) }}">{{ $stf->name }}</a>
                    </div>
                    <div class="md:w-3/12 flex gap-x-2">
                        <div class="font-semibold md:hidden">Email:</div>
                        {{ $stf->email }}
                    </div>
                    <div class="md:w-3/12 flex gap-x-2">
                        <div class="font-semibold md:hidden">Phone:</div>
                        {{ $stf->phone }}
                    </div>
                    <div class="md:w-1/12 flex gap-x-2">
                        <div class="font-semibold md:hidden">Completed Hours:</div>
                        {{ $stf->hours_worked ?? '--' }}
                    </div>
                    <div class="md:w-1/12 flex gap-x-2">
                        <div class="font-semibold md:hidden">Cancelled Hours:</div>
                        {{ $stf->cancelled_hours ?? '--' }}
                    </div>
                    <div class="md:w-1/12 flex gap-x-2">
                        <div class="font-semibold md:hidden">Gross Earnings:</div>
                        {{ $stf->total_earnings ?? '--' }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
