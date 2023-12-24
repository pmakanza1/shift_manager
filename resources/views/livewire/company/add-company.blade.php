<div class="container mx-auto bg-blue-200 p-4 space-y-4">
    <div class="text-center bg-blue-500 text-white py-1">Add Company</div>

    @if ($success)
        <div x-data="{ showSuccessMessage: @entangle('success') }">
            <p x-init="setTimeout(() => showSuccessMessage = false, 4000)" x-show="showSuccessMessage" x-transition.duration.2000ms
                class="bg-green-50 text-green-500 border border-green-500 p-2 font-medium text-center">
                Company Added Successfully!
            </p>
        </div>
    @endif

    <div>
        <input id="coName" name="name" wire:model="name" type="text" placeholder="Company Name">
        <input id="coEmail" name="email" wire:model="email" type="text" placeholder="Company Email">
        <input id="coPhone" name="phone" wire:model="phone" type="tel" placeholder="Company Phone Number">
    </div>

    <div>
        <input type="number" name="dayRate" wire:model="dayRate" placeholder="Day Rate" />
        <input type="number" name="nightRate" wire:model="nightRate" placeholder="Night Rate" />
        <input type="number" name="weekendRate" wire:model="weekendRate" placeholder="Weekend Rate" />
    </div>

    <div class="flex gap-x-2">
        <p wire:click="save" class="bg-green-500 text-white py-2 px-3 w-fit my-3 cursor-pointer">Save</p>
        <p @click="addCompany=false" class="bg-red-500 text-white py-2 px-3 w-fit my-3 cursor-pointer">Cancel</p>
    </div>
</div>
