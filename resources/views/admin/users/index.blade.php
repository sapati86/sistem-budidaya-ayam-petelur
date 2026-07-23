@extends('layouts.admin')

@section('title', 'Manajemen User')
@section('header', 'Manajemen User')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Daftar User</h3>
        <span class="text-sm text-gray-500">Total: {{ $users->total() }} user</span>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-2 text-left">No</th>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Role Saat Ini</th>
                    <th class="px-4 py-2 text-left">Status Verifikasi</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $users->firstItem() + $index }}</td>
                    <td class="px-4 py-2 font-medium">{{ $user->name }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 text-xs rounded 
                            @if($user->role == 'admin') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($user->role) }}
                        </span>
                        @if($user->id === Auth::id())
                            <span class="text-xs text-yellow-500 ml-1">(Anda)</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        @if($user->email_verified_at)
                            <span class="text-green-500 text-sm"><i class="fas fa-check-circle"></i> Terverifikasi</span>
                        @else
                            <span class="text-red-500 text-sm"><i class="fas fa-times-circle"></i> Belum</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        @if($user->id !== Auth::id())
                            <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PUT')
                                <select name="role" class="border rounded px-2 py-1 text-sm">
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                </select>
                                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                                    <i class="fas fa-save mr-1"></i> Ubah
                                </button>
                            </form>
                        @else
                            <span class="text-gray-400 text-sm">Tidak dapat mengubah role sendiri</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">Belum ada user terdaftar</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection