<div class="px-2 py-1">

    @if ($saveSuccess)
        <div x-data="{ showSuccessMessage: @entangle('saveSuccess') }">
            <p x-init="setTimeout(() => showSuccessMessage = false, 4000)" x-show="showSuccessMessage" x-transition.duration.2000ms
                class="bg-green-50 text-green-500 border border-green-500 p-2 font-medium text-center">
                Shift Successfully Assigned!
            </p>
        </div>
    @endif

    <div class="text-sm py-3 font-medium">Assign Shifts to {{ $staff->name }}</div>

    <form class="" action="">
        <div class="flex flex-col md:flex-row gap-x-5 space-y-2 md:space-y-0">
            <div class="w-full lg:w-1/3">
                <select class="w-full" name="company" id="" wire:model="company">
                    <option value="">Select Company</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>

                <div>
                    @error('company')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="w-full lg:w-1/3">
                <select class="w-full" class="flex w-1/3" name="shiftType" id="" wire:model="shiftType">
                    <option value="">Select Shift Type</option>
                    @foreach ($shiftTypes as $shiftType)
                        <option value="{{ $shiftType->id }}">{{ $shiftType->name }}</option>
                    @endforeach
                </select>

                <div>
                    @error('shiftType')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="w-1/3"></div>
        </div>

        <div class="flex flex-col lg:flex-row gap-x-5 my-6">
            <div class="flex flex-col w-full lg:w-1/3">
                <label for="startDate">Start</label>
                <div class="flex justify-between gap-x-1">
                    <input class="w-full lg:w-2/3" id="startDate" name="startDate" type="date" wire:model.live="startDate" />
                    <input class="w-full lg:w-1/3" type="time" name="startTime" wire:model.live="startTime" />
                </div>

                <div>
                    @error('startDate')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror

                    @error('times')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col w-full lg:w-1/3">
                <label for="endDate">End</label>
                <div class="flex justify-between gap-x-1">
                    <input class="w-full lg:w-2/3" id="endDate" name="endDate" type="date" wire:model.live="endDate" />
                    <input class="w-full lg:w-1/3" type="time" name="endTime" wire:model.live="endTime" />
                </div>

                <div>
                    @error('endDate')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex w-1/3"></div>
        </div>

        <div class="flex flex-row w-full lg:w-2/3 gap-x-2 lg:gap-x-14 pb-6 items-center items-stretch">
            <div class="flex flex-col w-full lg:w-1/5">
                <label for="rate">Rate</label>
                <input class="" id="rate" name="rate" type="number" wire:model="rate" />

                <div>
                    @error('rate')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col w-full lg:w-1/5">
                <label for="breakHours">Break (Hours)</label>
                <input placeholder="0.5" class="" id="breakHours" type="number" name="breakHours"
                    wire:model="breakHours" />

                <div>
                    @error('breakHours')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- <div class="flex flex-col w-1/3"></div> --}}

        <div class="px-1 border border-black">
            <p class="font-medium">Assign same shift for the following days:</p>
            <div class="flex flex-wrap justify-between py-2">
                @foreach ($weekDays as $weekDay)
                    <div class="flex items-center">
                        <input id="{{ $weekDay }}" value="{{ $weekDay }}" wire:model.live="selectedDays"
                            type="checkbox" />
                        <label class="px-1" for="{{ $weekDay }}">{{ $weekDay }}</label>
                    </div>
                @endforeach
            </div>

            <div class="py-2">
                <div class="text-gray-500">
                    <input class="text-gray-500" type="radio" id="week" name="shiftOccurence" value="weekly"
                        wire:model.live="shiftOccurence" disabled />
                    <label for="week">This Week</label>
                </div>

                <div class="text-gray-500">
                    <input class="text-gray-500" type="radio" id="month" name="shiftOccurence" value="monthly"
                        wire:model.live="shiftOccurence" disabled />
                    <label for="month">This month</label>
                </div>

                @error('shiftOccurence')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

        @if ($clashingShift)
            <div class="my-2">
                <p class="bg-red-400 text-red-700 p-1 font-semibold text-center">Clash Detected</p>
                <div class="px-1 py-2 bg-red-200">
                    <p class="text-red-700 font-semibold">
                        This person has another shift on {{ $clashingShift->start_date }}
                    </p>

                    <div class="py-1">
                        <div class="flex font-semibold">
                            <p class="w-1/4">Company</p>
                            <p class="w-1/4">Starting</p>
                            <p class="w-1/4">Ending</p>
                            <p class="w-1/4">Assigned By</p>
                        </div>

                        <div class="flex">
                            <p class="w-1/4">{{ $clashingShift->company->name }}</p>
                            <p class="w-1/4">{{ $clashingShift->start_date }}</p>
                            <p class="w-1/4">{{ $clashingShift->end_date }}</p>
                            <p class="w-1/4">{{ $clashingShift->lastUpdatedBy->email }}</p>
                        </div>
                    </div>

                    @if ($noteRequired)
                        <div>
                            <textarea class="resize-none w-full" name="note" wire:model="note" id="" cols="10" rows="5"
                                placeholder="Please enter reason for overwriting shift"></textarea>
                        </div>

                        @error('note')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    @endif

                    <div class="flex gap-x-2 py-3 font-semibold">
                        <p wire:click="clearProps" class="px-1 text-white bg-orange-500 cursor-pointer">Cancel</p>
                        <p wire:click="overwriteShift" class="bg-sky-500 text-white px-1 cursor-pointer">Overwrite</p>
                    </div>
                </div>
            </div>
        @endif


        <div class="py-4 font-medium">
            Planned Hours: {{ $plannedHours }}
        </div>

        <div class="font-medium">
            Estimated Gross Earnings: {{ $estimatedEarnings }}
        </div>

        @if($shiftTooLong)
            <div class="bg-red-200 bg-red-200 text-center font-medium py-2">
                <span class="text-red-700">Shift should not exceed 12 hours</span>
            </div>
        @endif

        <div class="bg-blue-500 p-1 mt-6 text-white w-fit" wire:click="createShift">
            <button type="button">Confirm</button>
        </div>
    </form>
</div>
