<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
        
        <div class="mt-6 p-4 bg-white rounded-lg shadow">
            <h3 class="text-lg font-medium text-gray-900">Two-Factor Authentication</h3>
            
            @if(auth()->user()->two_factor_enabled)
                <p class="text-green-600 mt-2">✅ 2FA sudah aktif</p>
            @else
                <p class="text-yellow-600 mt-2">⚠️ 2FA belum aktif</p>
                <a href="{{ route('2fa.setup') }}" class="mt-2 inline-block bg-blue-500 text-white px-4 py-2 rounded">
                    Setup 2FA
                </a>
            @endif
        </div>
    </div>
</x-app-layout>
