@extends('layout.app')

@section('title', 'Verify Email')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Verify Your Email</h2>
            <p class="text-gray-600 mt-2">We've sent a verification link to your email address</p>
        </div>

        <div class="text-center mb-6">
            <p class="text-lg text-gray-600 mb-4">
                Please check your email and click the verification link to activate your account.
            </p>
            <p class="text-sm text-gray-500">
                Didn't receive the email? Check your spam folder or request a new one below.
            </p>
        </div>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full py-3 px-4 text-xl font-semibold text-white rounded-lg hover:opacity-90 transition duration-150 ease-in-out" style="background-color: #B9375D;">
                Resend Verification Email
            </button>
        </form>

        <div class="mt-6 text-center">
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-lg text-gray-600 hover:underline">
                    Sign out
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
