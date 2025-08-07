@extends('layout.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Welcome Back!</h2>
            <p class="text-gray-600 mt-2">Sign in to your Bunny Bakes account</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-6">
                <label for="email" class="block text-lg font-medium text-gray-700 mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent text-lg @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="block text-lg font-medium text-gray-700 mb-2">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent text-lg @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between mb-6">
                <label for="remember" class="flex items-center">
                    <input id="remember" type="checkbox" name="remember" class="rounded border-gray-300 text-pink-600 shadow-sm focus:ring-pink-500">
                    <span class="ml-2 text-lg text-gray-600">Remember me</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3 px-4 text-xl font-semibold text-white rounded-lg hover:opacity-90 transition duration-150 ease-in-out" style="background-color: #B9375D;">
                Sign In
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-lg text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-semibold hover:underline" style="color: #B9375D;">
                    Sign up here
                </a>
            </p>
        </div>
    </div>
</div>
@endsection