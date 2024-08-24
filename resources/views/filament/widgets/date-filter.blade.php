
<x-filament-widgets::widget>
    <x-filament::section>
        <div class="mb-4">
            <label for="from_date" class="block text-sm font-medium ">Дата, с</label>
            <input wire:model="fromDate" wire:change="fromDateChanged($event.target.value)" type="date" id="from_date" name="from_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
        </div>

        <div class="mb-4">
            <label for="to_date" class="block text-sm font-medium text-gray-700">Дата, по</label>
            <input wire:model="toDate" wire:change="toDateChanged($event.target.value)" type="date" id="to_date" name="to_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
