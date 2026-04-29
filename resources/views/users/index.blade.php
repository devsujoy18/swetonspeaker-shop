<x-app-layout>
<div x-data="changePasswordModal()">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users Management') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        <!-- Filters -->
        <form method="GET" class="mb-4 flex flex-wrap gap-4 bg-gray-50 p-4 rounded-lg shadow">
            <!-- Search -->
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by name, email or phone"
                   class="border-gray-300 rounded-md px-3 py-2 w-64">

            <!-- User Type -->
            <select name="user_type" class="border-gray-300 rounded-md">
                <option value="">All Types</option>
                <option value="user" {{ request('user_type')=='user'?'selected':'' }}>User</option>
                <option value="guest" {{ request('user_type')=='guest'?'selected':'' }}>Guest</option>
                <option value="admin" {{ request('user_type')=='admin'?'selected':'' }}>Admin</option>
            </select>

            <!-- City -->
            <input type="text" name="city" value="{{ request('city') }}"
                   placeholder="City"
                   class="border-gray-300 rounded-md px-3 py-2 w-48">

            <!-- From Date -->
            <input type="date" name="from_date"
                   value="{{ request('from_date') }}"
                   class="border-gray-300 rounded-md px-3 py-2">

            <!-- To Date -->
            <input type="date" name="to_date"
                   value="{{ request('to_date') }}"
                   class="border-gray-300 rounded-md px-3 py-2">


            <!-- Actions -->
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Filter
            </button>
            <a href="{{ route('admin.users.index') }}"
               class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                Reset
            </a>
        </form>

        <!-- Users Table -->
        <div class="bg-white shadow-sm sm:rounded-lg overflow-visible">
            <div class="p-6 text-gray-900">
                <div class="relative overflow-x-auto overflow-y-visible">
                    @if($users->count())
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2">ID</th>
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">Email</th>
                                    <th class="px-4 py-2">Phone</th>
                                    <th class="px-4 py-2">User Type</th>
                                    <th class="px-4 py-2">City</th>
                                    <th class="px-4 py-2">Orders</th>
                                    <th class="px-4 py-2">Registered</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr class="border-t">
                                        <td class="px-4 py-2 font-medium">{{ $user->id }}</td>
                                        <td class="px-4 py-2">{{ $user->name }}</td>
                                        <td class="px-4 py-2">{{ $user->email }}</td>
                                        <td class="px-4 py-2">{{ $user->phone_number ?? '-' }}</td>
                                        <td class="px-4 py-2">
                                            @php
                                                $roleClasses = match($user->user_type) {
                                                    'admin' => 'bg-purple-100 text-purple-700',
                                                    'user'  => 'bg-blue-100 text-blue-700',
                                                    'guest' => 'bg-gray-100 text-gray-700',
                                                    default => 'bg-slate-100 text-slate-700',
                                                };
                                            @endphp

                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $roleClasses }}">
                                                {{ ucfirst($user->user_type) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2">{{ $user->city_district_town ?? '-' }}</td>
                                        <!-- Orders count -->
                                        <td class="px-4 py-2">
                                            <span class="px-2 py-1 text-xs rounded bg-gray-100">
                                                {{ $user->orders_count }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2">{{ $user->created_at?->format('d M Y') }}</td>
                                        <td class="px-4 py-2">
                                            @if($user->isBlocked())
                                                <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-600">
                                                    Blocked
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-600">
                                                    Active
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 text-right" x-data="{ open:false }" x-cloak>
                                            <button @click="open = !open"
                                                    class="p-2 rounded hover:bg-gray-100 focus:outline-none">
                                                ⋮
                                            </button>

                                            <div x-show="open"
                                                 @click.away="open=false"
                                                 x-transition
                                                 class="absolute right-6 mt-2 w-40 bg-white border rounded-lg shadow-lg z-50">

                                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                                   class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-100">
                                                    ✏️ Edit
                                                </a>

                                                @if($user->user_type === 'user')
                                                    <button
                                                        @click="open=false; openModal({{ $user->id }}, '{{ $user->name }}')"
                                                        class="w-full flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-100">
                                                        🔐 Change
                                                    </button>
                                                @endif

                                                @if($user->user_type !== 'admin')
                                                <button
                                                        @click="open=false; toggleBlock({{ $user->id }})"
                                                        class="w-full flex items-center gap-2 px-4 py-2 text-sm
                                                        {{ $user->isBlocked() ? 'text-green-600' : 'text-red-600' }}
                                                        hover:bg-gray-100">
                                                        {{ $user->isBlocked() ? '✅ Unblock' : '🚫 Block' }}
                                                    </button>
                                                @endif
                                            </div>
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $users->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">No users found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{--Password Reset Modal --}}
    <div x-cloak>
        <!-- Modal Overlay -->
        <div x-show="passwordModalOpen" class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>

        <!-- Modal -->
        <div x-show="passwordModalOpen"
             class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg w-full max-w-md p-6 shadow-lg">

                <h2 class="text-lg font-semibold mb-4">
                    Change Password — <span x-text="userName"></span>
                </h2>

                <form @submit.prevent="submit">
                    @csrf

                    <input type="password"
                           x-model="password"
                           placeholder="New Password"
                           class="w-full mb-3 border rounded px-3 py-2">

                    <input type="password"
                           x-model="password_confirmation"
                           placeholder="Confirm Password"
                           class="w-full mb-3 border rounded px-3 py-2">

                    <p x-show="error" class="text-red-600 text-sm mb-2" x-text="error"></p>
                    <p x-show="success" class="text-green-600 text-sm mb-2" x-text="success"></p>

                    <div class="flex justify-end gap-2">
                        <button type="button"
                                @click="close"
                                class="px-4 py-2 bg-gray-200 rounded">
                            Cancel
                        </button>

                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function changePasswordModal() {
    return {
        passwordModalOpen: false,
        userId: null,
        userName: '',
        password: '',
        password_confirmation: '',
        error: '',
        success: '',

        openModal(id, name) {
            this.userId = id;
            this.userName = name;
            this.password = '';
            this.password_confirmation = '';
            this.error = '';
            this.success = '';
            this.passwordModalOpen = true;
        },

        close() {
            this.passwordModalOpen = false;
        },

        async submit() {
            this.error = '';
            this.success = '';

            try {
                const response = await fetch(`/admin/users/${this.userId}/change-password`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        password: this.password,
                        password_confirmation: this.password_confirmation
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    this.error = data.message || 'Validation error';
                    return;
                }

                this.success = data.message;

                setTimeout(() => {
                    this.close();
                }, 1200);

            } catch (e) {
                console.error(e.message);
                this.error = 'Something went wrong';
            }
        },

        async toggleBlock(userId) {
            if (!confirm('Are you sure?')) return;

            try {
                const response = await fetch(`/admin/users/${userId}/toggle-block`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                });

                const text = await response.text();
                const data = text ? JSON.parse(text) : {};

                if (!response.ok) {
                    alert(data.message || 'Action failed');
                    return;
                }

                alert(data.message);
                location.reload(); // optional, simplest

            } catch (e) {
                console.error(e);
                alert('Something went wrong');
            }
        }

    }
}
</script>


</x-app-layout>
