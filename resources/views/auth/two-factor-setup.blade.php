<x-guest-layout>
    <div class="max-w-md mx-auto mt-10">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4 text-center">Setup Two-Factor Authentication</h2>
            
            <p class="text-gray-600 mb-4 text-center">
                Scan QR code berikut dengan aplikasi Google Authenticator
            </p>
            
            <div class="flex justify-center mb-4">
                {!! $qrCode !!}
            </div>
            
            <p class="text-sm text-gray-500 text-center mb-4">
                Atau masukkan kode manual: <strong>{{ Auth::user()->two_factor_secret }}</strong>
            </p>
            
            <form action="{{ route('2fa.enable') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition">
                    Aktifkan 2FA
                </button>
            </form>
            
            <div class="mt-4 text-center">
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:underline">Lewati untuk sekarang</a>
            </div>
        </div>
    </div>
</x-guest-layout>