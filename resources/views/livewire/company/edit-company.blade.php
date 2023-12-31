<div x-data="{editCompany:false}" class="container mx-auto p-4 space-y-4">
    @if ($success)
        <div x-data="{ showSuccessMessage: @entangle('success') }">
            <p x-init="setTimeout(() => showSuccessMessage = false, 4000)" x-show="showSuccessMessage" x-transition.duration.2000ms
                class="bg-green-50 text-green-500 border border-green-500 p-2 font-medium text-center">
                Company Data Updated Successfully!
            </p>
        </div>
    @endif

    <div class="text-center border border-gray-50 bg-gray-300 font-medium py-1">{{ $company->name }}</div>

    @if ($errors->any())
        <div class="text-red-500">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex w-full justify-between gap-x-2">
        <div class="flex flex-col w-full">
            <label class="" for="coName">Company Name</label>
            <input class="w-full" id="coName" name="name" wire:model="name" type="text"
                placeholder="Company Name">
        </div>

        <div class="flex flex-col w-full">
            <label class="" for="coEmail">Company Email</label>
            <input id="coEmail" name="email" wire:model="email" type="text" placeholder="Company Email">
        </div>

        <div class="flex flex-col w-full">
            <label class="" for="coPhone">Phone</label>
            <input id="coPhone" name="phone" wire:model="phone" type="tel" placeholder="Company Phone Number">
        </div>
    </div>

    <div class="flex w-full justify-between gap-x-2">
        <div class="flex flex-col w-full">
            <label for="dayRate">Day Rate</label>
            <input type="number" name="dayRate" wire:model="dayRate" placeholder="Day Rate" />
        </div>

        <div class="flex flex-col w-full">
            <label for="nightRate">Night Rate</label>
            <input type="number" name="nightRate" wire:model="nightRate" placeholder="Night Rate" />
        </div>

        <div class="flex flex-col w-full">
            <label for="weekendRate">Weekend Rate</label>
            <input type="number" name="weekendRate" wire:model="weekendRate" placeholder="Weekend Rate" />
        </div>
    </div>

    <div class="flex gap-x-2">
        <p wire:click="updateCompany({{ $company->company_id }})"
            class="bg-green-500 text-white py-2 px-3 w-fit my-3 cursor-pointer">Save</p>
        <p @click="$dispatch('closeEditBox')" class="bg-red-500 text-white py-2 px-3 w-fit my-3 cursor-pointer">Cancel</p>
    </div>
</div>
