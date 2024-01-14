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

    <div>
        @if ($company)
            <div @click.outside="$wire.clearCompanyId" class="bg-gray-200 shadow-sm p-4">
                <livewire:company.edit-company :company="$company" />
            </div>
        @endif
    </div>

    <div class="flex flex-col w-full">
        <div class="hidden md:flex bg-blue-500 text-white text-sm items-center font-semibold w-full p-1">
            <p class="w-3/12">Name</p>
            <p class="w-3/12">Email</p>
            <p class="w-3/12">Phone</p>
            <p class="w-1/12">Day</p>
            <p class="w-1/12">Night</p>
            <p class="w-1/12">Weekend</p>
        </div>

        <div class="flex flex-col w-full">
            @foreach ($companies as $company)
                <div class="flex flex-col md:flex-row space-y-1 md:space-y-0 w-full bg-blue-200 py-2 px-1 mb-2 rounded">
                    <div wire:click="setCompanyId({{ $company->company_id }})" class="flex gap-x-2 md:w-3/12 font-semibold cursor-pointer">
                        <div class="md:hidden">Name: </div>
                        <span class="text-indigo-500">{{ $company->name }}</span>
                    </div>

                    <div class="flex gap-x-2 md:w-3/12">
                        <div class="md:hidden font-semibold">Email:</div>
                        {{ $company->email }}
                    </div>

                    <div class="flex gap-x-2 md:w-3/12">
                        <div class="font-semibold md:hidden">Phone:</div>
                        {{ $company->phone }}
                    </div>
                    {{-- <div class="w-2/12">{{ $company->rate }}</div> --}}

                    <div class="flex gap-x-2 md:w-1/12">
                        <div class="font-semibold md:hidden">Day:</div>
                        {{ $company->dayRate }}
                    </div>

                    <div class="flex gap-x-2 md:w-1/12">
                        <div class="font-semibold md:hidden">Night:</div>
                        {{ $company->nightRate }}
                    </div>

                    <div class="flex gap-x-2 md:w-1/12">
                        <div class="font-semibold md:hidden">Weekend:</div>
                        {{ $company->weekendRate }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
