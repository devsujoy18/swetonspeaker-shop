<x-front-layout>
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto px-4">
            <nav class="text-sm text-gray-700" aria-label="breadcrumb">
                <ol class="flex space-x-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Home</a>
                        <span class="mx-2">/</span>
                    </li>
                    <li class="text-gray-800">Reset Password</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="w-full max-w-sm mx-auto mt-5">
        <form method="POST" action="{{ route('password.store') }}" 
              class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 border border-gray-200">
            @csrf
            
            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Reset Password</h2>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email address
                </label>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                       class="border border-gray-300 rounded w-full py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="Email Address">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Password -->
            <div class="mb-2">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       class="border border-gray-300 rounded w-full py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="New Password">
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
            </div>
            
            <!-- Password -->
            <div class="mb-2">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Confirm Password
                </label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       class="border border-gray-300 rounded w-full py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="Confirm Password">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
            </div>


            <!-- Submit -->
            <div>
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white text-sm font-semibold py-2 px-4 rounded">
                    Reset Password
                </button>
            </div>

        </form>
    </div>

</x-front-layout>