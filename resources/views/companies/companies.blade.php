<x-app-layout>
    <div class="">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Companies') }}
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

            <div class="">
                <div class="flex bg-blue-500 p-1 text-white font-semibold w-full">
                    <p class="w-1/3">Name</p>
                    <p class="w-1/3">Email</p>
                    <p class="w-1/3">Phone</p>
                </div>

                <div class="flex flex-col">
                    @foreach ($companies as $company)
                        <div class="flex bg-blue-200 px-1 py-2 mb-2 rounded">
                            <div class="w-1/3 font-semibold">{{ $company->name }}</div>
                            <div class="w-1/3">{{ $company->email }}</div>
                            <div class="w-1/3">{{ $company->phone }}</div>
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
