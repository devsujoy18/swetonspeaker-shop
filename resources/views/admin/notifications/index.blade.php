<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Notifications') }}
            </h2>
            @if ($notifications->whereNull('read_at')->count() > 0)
                <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <x-secondary-button type="submit">
                        {{ __('Mark All as Read') }}
                    </x-secondary-button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($notifications->count() > 0)
                        <div class="space-y-4">
                            @foreach ($notifications as $notification)
                                <div class="flex items-start justify-between p-4 border rounded-lg {{ $notification->isUnread() ? 'bg-blue-50 border-blue-200' : 'bg-white border-gray-200' }}">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <h3 class="font-semibold text-gray-900">{{ $notification->title }}</h3>
                                            @if ($notification->isUnread())
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                    New
                                                </span>
                                            @endif
                                        </div>
                                        <p class="mt-1 text-sm text-gray-600">{{ $notification->message }}</p>
                                        <p class="mt-1 text-xs text-gray-400">{{ $notification->created_at->format('d F, Y h:i A') }}</p>
                                    </div>
                                    <div class="flex items-center gap-2 ms-4">
                                        @if ($notification->isUnread())
                                            <form action="{{ route('admin.notifications.mark-as-read', $notification) }}" method="POST">
                                                @csrf
                                                <x-secondary-button type="submit" class="text-xs">
                                                    {{ __('Mark Read') }}
                                                </x-secondary-button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this notification?');">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button type="submit" class="text-xs">
                                                {{ __('Delete') }}
                                            </x-danger-button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
                            <p class="mt-1 text-sm text-gray-500">You don't have any notifications yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
