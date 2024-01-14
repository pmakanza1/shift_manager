<div x-data="{ addCompany: false }" class="px-3">
    <div class="flex items-center justify-between gap-x-2 py-3">
        <div class="w-full">
            <input wire:model.live="searchTerm" name="searchTerm" class="border border-gray-300 rounded w-full"
                type="search" placeholder="Search by Email, Company Name ..." />
        </div>
        <div class="bg-blue-500 rounded-full py-1 px-3 text-white cursor-pointer">
            <p @click="addCompany=true" class="py-1">Add</p>
        </div>
    </div>

    <div x-cloak x-show="addCompany" @click.outside="addCompany=false">
        <livewire:company.add-company />
    </div>

    <div class="py-2 flex flex-col md:flex-row gap-x-4 gap-y-2">
        <div class="flex gap-x-2">
            <div class="flex flex-col">
                <p class="">From</p>
                <input type="date" id="bobo" name="filterStartDate" wire:model="filterStartDate" />
            </div>
            <div class="flex flex-col">
                <p>To</p>
                <input type="date" name="filterEndDate" wire:model="filterEndDate" />
            </div>
        </div>

        <div class="flex gap-x-2 items-end">
            <div class="bg-blue-500 text-white py-2 px-3 cursor-pointer">
                <p wire:click="filter" class="py-1 text-sm">Filter</p>
            </div>
            <div class="bg-orange-500 text-white py-2 px-3 cursor-pointer">
                <p wire:click="clearFilters" class="py-1 text-sm">Clear Filter</p>
            </div>
            <div class="bg-green-500 text-white py-2 px-3 cursor-pointer">
                <p wire:click="showAllCompanies" class="py-1 text-sm">Show All</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col overflow-auto w-full">
        <div class="hidden md:flex bg-blue-500 text-white text-sm items-center font-semibold w-full p-1">
            <p class="w-4/12">Name</p>
            <p class="w-4/12">Email</p>
            {{-- <p class="w-2/12">Rate</p> --}}
            <p class="w-2/12">Total Hours</p>
            <p class="w-2/12">Total Billable</p>
        </div>

        <div class="flex flex-col overflow-auto w-full">
            @foreach ($companyHours as $company)
                <div class="flex flex-col md:flex-row space-y-1 md:space-y-0 w-full bg-blue-200 py-2 px-1 mb-2 rounded">
                    <div class="flex md:w-4/12 gap-x-2 font-semibold">
                        <div class="md:hidden">Name:</div>
                        {{ $company->name }}
                    </div>
                    <div class="flex md:w-4/12 gap-x-2">
                        <div class="md:hidden font-semibold">Email:</div>
                        {{ $company->email }}
                    </div>
                    {{-- <div class="w-2/12">{{ $company->rate }}</div> --}}
                    <div class="flex md:w-2/12 gap-x-2">
                        <div class="md:hidden font-semibold">Total Hours:</div>
                        {{ $company->totalHours ?? '--' }}
                    </div>
                    <div class="flex md:w-2/12 gap-x-2">
                        <div class="md:hidden font-semibold">Total Billable</div>
                        {{ $company->totalBillable ?? '--' }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
