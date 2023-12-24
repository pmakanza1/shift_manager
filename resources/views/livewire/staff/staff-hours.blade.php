<div class="px-3">
    <div class="flex items-center justify-between gap-x-2 py-3">
        <div class="w-full">
            <input
                wire:model.live="searchTerm" name="searchTerm"
                class="border border-gray-300 rounded w-full" type="search"
                placeholder="Search by Email, Company Name ..." />
        </div>
        {{--<div class="bg-blue-500 rounded-full py-1 px-3 text-white">
            <button class="py-1">Add</button>
        </div>--}}
    </div>

    <div class="py-2 flex gap-x-4 items-end">
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
    </div>

    <div class="flex flex-col overflow-auto w-full">
        <div class="flex bg-blue-500 text-white text-sm items-center font-semibold w-full p-1">
            <p class="w-3/12">Name</p>
            <p class="w-3/12">Email</p>
            <p class="w-3/12">Phone</p>
            <p class="w-1/12">Completed Hours</p>
            <p class="w-1/12">Cancelled Hours</p>
            <p class="w-1/12">Gross Earnings</p>
        </div>

        <div class="flex flex-col overflow-auto w-full">
            @foreach ($staffHours as $stf)
            {{-- @dd($stf) --}}
                <div wire:key="'staff-'{{ $stf->staff_id }}" class="flex w-full bg-blue-200 py-2 px-1 mb-2 rounded">
                    <div class="w-3/12 font-semibold">
                        <a href="{{route('staff.show', $stf->staff_id)}}">{{ $stf->name }}</a>
                    </div>
                    <div class="w-3/12">{{ $stf->email }}</div>
                    <div class="w-3/12">{{ $stf->phone }}</div>
                    <div class="w-1/12">{{ $stf->total_hours?? '--' }}</div>
                    <div class="w-1/12">{{ $stf->cancelled_hours ?? '--' }}</div>
                    <div class="w-1/12">{{ $stf->total_earnings ?? '--' }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
