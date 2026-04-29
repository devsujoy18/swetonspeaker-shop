<x-app-layout>
    <x-slot name="header">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Review Details
                </h2>
                <a href="{{ route('admin.reviews.index') }}" 
                   class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 text-sm">
                    ← Back to Reviews
                </a>
            </div>
    </x-slot>
    <livewire:admin.review-detail-component :reviewId="$reviewId" />
</x-app-layout>