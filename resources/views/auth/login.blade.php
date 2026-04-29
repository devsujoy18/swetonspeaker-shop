<x-front-layout>
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto px-4">
            <nav class="text-sm text-gray-700" aria-label="breadcrumb">
                <ol class="flex space-x-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Home</a>
                        <span class="mx-2">/</span>
                    </li>
                    <li class="text-gray-800">Login</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="w-full max-w-sm mx-auto mt-5">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        
        <form method="POST" action="{{ route('login') }}" 
              class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 border border-gray-200">
            @csrf

            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Login</h2>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email address
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="border border-gray-300 rounded w-full py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="Email Address">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Password -->
            <div class="mb-2">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="border border-gray-300 rounded w-full py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="Password">
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />

                @if (Route::has('password.request'))
                    <a class="text-blue-600 text-xs mt-1 inline-block hover:underline" href="{{ route('password.request') }}">
                        Forgotten Password
                    </a>
                @endif
            </div>

            <!-- Remember Me -->
            <div class="mt-3 mb-5">
                <label class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="form-checkbox text-blue-600" name="remember">
                    <span class="ml-2 text-sm text-gray-700">Remember Me</span>
                </label>
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white text-sm font-semibold py-2 px-4 rounded">
                    Login
                </button>
            </div>

            <!-- Register Link -->
            <p class="text-sm mt-4 text-gray-700">
                Not a member? 
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register Now</a>
            </p>
        </form>
    </div>
</x-front-layout>

