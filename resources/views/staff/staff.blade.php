<x-app-layout>
    <div class="">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Staff') }}
            </h2>
        </x-slot>

        <div class="px-3">
            <div class="flex items-center justify-between gap-x-2 py-3">
                <div class="w-full">
                    <input class="border border-gray-300 rounded w-full" type="search"
                        placeholder="Search by Email, Company Name ..." />
                </div>
                <div class="bg-blue-500 rounded-full py-1 px-3 text-white">
                    <button class="py-1">Add</button>
                </div>
            </div>

            <div class="flex flex-col overflow-scroll w-full">
                <div class="flex bg-blue-500 p-1 text-white font-semibold w-full">
                    <p class="w-1/6">Name</p>
                    <p class="w-1/6">Email</p>
                    <p class="w-1/6">Phone</p>
                    <p class="w-1/6">Planned Hours</p>
                    <p class="w-1/6">Completed Hours</p>
                    <p class="w-1/6">Gross Earnings</p>
                </div>

                <div class="flex flex-col">
                    @foreach ($staff as $stf)
                        <div class="flex bg-blue-200 px-1 py-2 mb-2 rounded">
                            <div class="w-1/6 font-semibold">
                                <a href="{{route('staff.show', $stf)}}">{{ $stf->name }}</a>
                            </div>
                            <div class="w-1/6">{{ $stf->email }}</div>
                            <div class="w-1/6">{{ $stf->phone }}</div>
                            <div class="w-1/6">10</div>
                            <div class="w-1/6">45</div>
                            <div class="w-1/6">4500</div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div>bob</div>
            <div>bob</div>
            <div>bob</div>
            <div>bob</div>
            <div>bob</div>
        </div>
    </div>
</x-app-layout>
