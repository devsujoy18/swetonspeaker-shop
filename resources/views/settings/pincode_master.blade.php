<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Site Settings
        </h2>
    </x-slot>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{ openRow: null }">
        <livewire:admin.pincode-component />
    </div>
</x-app-layout>