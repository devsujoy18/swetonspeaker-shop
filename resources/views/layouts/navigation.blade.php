<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" target="_blank">
                        {{--<x-application-logo class="block h-9 w-auto fill-current text-gray-800" />--}}
                        <img src="{{ asset('image/logonew1.png') }}" alt="Sweton Logo" class="w-[212px]">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:ms-10 sm:space-x-0">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- My order section only for users --}}
                    @can('isUser')
                    <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                        {{ __('My Orders') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('old.orders')" :active="request()->routeIs('old.orders')">
                        {{ __('Old Orders') }}
                    </x-nav-link>
                    @endcan


                    {{-- NEW: Product & Category Dropdown (Desktop) --}}
                    {{-- Using Alpine.js x-data for dropdown state --}}
                    {{-- NEW: Product & Category Dropdown (Desktop) - ONLY FOR ADMINS --}}
                    @can('isAdmin')
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition">
                                    {{ __('Product & Category') }}
                                    <svg class="ms-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('categories.manage')" :active="request()->routeIs('categories.*')">
                                    {{ __('Categories') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('products.manage')" :active="request()->routeIs('subcategories.*')">
                                    {{ __('Products') }}
                                </x-dropdown-link>
                                
                            </x-slot>
                        </x-dropdown>

                        {{-- NEW: Orders Dropdown (Admin only) --}}
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition">
                                    {{ __('Orders') }}
                                    <svg class="ms-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414L10 13.414 5.293 8.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.index')">
                                    {{ __('All Orders') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.orders.ledger')" :active="request()->routeIs('admin.orders.ledger*')">
                                    {{ __('Account & Ledger') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.orders.product-analytics')" :active="request()->routeIs('admin.orders.product-analytics')">
                                    {{ __('Product Analytics') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.orders.report.success')" :active="request()->routeIs('admin.orders.report.success')">
                                    {{ __('Order success report') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                        
                        <x-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')">
                            {{ __('Reports') }}
                        </x-nav-link>
                        
                        <x-nav-link :href="route('admin.settings.edit')" :active="request()->routeIs('admin.settings.edit')">
                            {{ __('Settings') }}
                        </x-nav-link>
                        
                        <x-nav-link :href="route('admin.pincodemaster')" :active="request()->routeIs('admin.pincodemaster')">
                            {{ __('Pincodes') }}
                        </x-nav-link>
                        
                        {{-- <x-nav-link :href="route('admin.tagmaster')" :active="request()->routeIs('admin.tagmaster')">
                            {{ __('Tag Master') }}
                        </x-nav-link> --}}

                        <x-nav-link :href="route('admin.reviews.index')" :active="request()->routeIs('admin.reviews.index')">
                            {{ __('Reviews') }}
                        </x-nav-link>

                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition">
                                    {{ __('User Management') }}
                                    <svg class="ms-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414L10 13.414 5.293 8.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                                    {{ __('All Users') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.users.create')" :active="request()->routeIs('admin.users.create')">
                                    {{ __('Create Users') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    @endcan
                    
                    @can('isSubadmin')
                        {{-- NEW: Orders Dropdown (Admin only) --}}
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition">
                                    {{ __('Orders') }}
                                    <svg class="ms-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414L10 13.414 5.293 8.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.index')">
                                    {{ __('All Orders') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.orders.ledger')" :active="request()->routeIs('admin.orders.ledger*')">
                                    {{ __('Account & Ledger') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.orders.product-analytics')" :active="request()->routeIs('admin.orders.product-analytics')">
                                    {{ __('Product Analytics') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.orders.report.success')" :active="request()->routeIs('admin.orders.report.success')">
                                    {{ __('Order success report') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                        
                        <x-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')">
                            {{ __('Reports') }}
                        </x-nav-link>
                    @endcan


                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @canany(['isAdmin', 'isSubadmin'])
                @php
                    $unreadCount = \App\Models\Notification::unread()->count();
                @endphp
                <a href="{{ route('admin.notifications.index') }}" class="relative inline-flex items-center px-3 py-2 mr-3 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    @if ($unreadCount > 0)
                        <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                        </span>
                    @endif
                </a>
                @endcanany
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            {{-- My order section only for users --}}
            @can('isUser')
            <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                {{ __('My Orders') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('old.orders')" :active="request()->routeIs('old.orders')">
                {{ __('Old Orders') }}
            </x-responsive-nav-link>
            @endcan


            {{-- NEW: Product & Category Dropdown (Responsive) --}}
            {{-- Using Alpine.js x-data for dropdown state --}}
            @can('isAdmin')
            <!-- Product & Category Management -->
            <div class="px-4 pt-2">
                <div class="font-medium text-gray-500">{{ __('Product & Category') }}</div>
            </div>
            <x-responsive-nav-link :href="route('categories.manage')" :active="request()->routeIs('categories.*')" class="pl-8">
                {{ __('Categories') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.manage')" :active="request()->routeIs('products.*')" class="pl-8">
                {{ __('Products') }}
            </x-responsive-nav-link>

            {{-- NEW: Orders Dropdown (Admin only) --}}
            <div class="px-4 pt-2">
                <div class="font-medium text-gray-500">{{ __('Orders') }}</div>
            </div>
            <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.index')" class="pl-8">
                {{ __('All Orders') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.orders.ledger')" :active="request()->routeIs('admin.orders.ledger*')" class="pl-8">
                {{ __('Account & Ledger') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.orders.product-analytics')" :active="request()->routeIs('admin.orders.product-analytics')" class="pl-8">
                {{ __('Product Analytics') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.orders.report.success')" :active="request()->routeIs('admin.orders.report.success')" class="pl-8">
                {{ __('Order success report') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')">
                {{ __('Report') }}
            </x-responsive-nav-link>

            <div class="px-4 pt-2">
                <div class="font-medium text-gray-500">{{ __('User Management') }}</div>
            </div>
            <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')" class="pl-8">
                {{ __('All Users') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.users.create')" :active="request()->routeIs('admin.users.create')" class="pl-8">
                {{ __('Create Users') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('admin.settings.edit')" :active="request()->routeIs('admin.settings.edit')">
                {{ __('Settings') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('admin.pincodemaster')" :active="request()->routeIs('admin.pincodemaster')">
                {{ __('Pincodes') }}
            </x-responsive-nav-link>

            {{-- <x-responsive-nav-link :href="route('admin.tagmaster')" :active="request()->routeIs('admin.tagmaster')">
                {{ __('Tag Master') }}
            </x-responsive-nav-link> --}}
             <x-responsive-nav-link :href="route('admin.reviews.index')" :active="request()->routeIs('admin.reviews.index')">
                {{ __('Reviews') }}
            </x-responsive-nav-link>
            
            @php
                $unreadCountMobile = \App\Models\Notification::unread()->count();
            @endphp
            <x-responsive-nav-link :href="route('admin.notifications.index')" :active="request()->routeIs('admin.notifications.*')" class="flex items-center justify-between">
                <span>{{ __('Notifications') }}</span>
                @if ($unreadCountMobile > 0)
                    <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                        {{ $unreadCountMobile > 99 ? '99+' : $unreadCountMobile }}
                    </span>
                @endif
            </x-responsive-nav-link>
            @endcan
            
            @can('isSubadmin')
            
            {{-- NEW: Orders Dropdown (Admin only) --}}
            <div class="px-4 pt-2">
                <div class="font-medium text-gray-500">{{ __('Orders') }}</div>
            </div>
            <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.index')" class="pl-8">
                {{ __('All Orders') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.orders.ledger')" :active="request()->routeIs('admin.orders.ledger*')" class="pl-8">
                {{ __('Account & Ledger') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.orders.product-analytics')" :active="request()->routeIs('admin.orders.product-analytics')" class="pl-8">
                {{ __('Product Analytics') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.orders.report.success')" :active="request()->routeIs('admin.orders.report.success')" class="pl-8">
                {{ __('Order success report') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')">
                {{ __('Report') }}
            </x-responsive-nav-link>
            
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
