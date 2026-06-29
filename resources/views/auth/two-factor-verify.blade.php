<x-guest-layout>
    <div class="max-w-md mx-auto mt-10">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4 text-center">Verifikasi 2FA</h2>
            
            <p class="text-gray-600 mb-4 text-center">
                Masukkan kode dari Google Authenticator
            </p>
            
            <form action="{{ route('2fa.verify') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <input type="text" name="code" placeholder="Masukkan 6 digit kode" 
                           class="w-full px-4 py-2 border rounded-md text-center text-2xl tracking-widest"
                           maxlength="6" required>
                    @error('code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition">
                    Verifikasi
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>