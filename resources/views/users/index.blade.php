@extends('layouts.app')

@section('title','Kelola User')
@section('page-title','Kelola User')

@section('content')

<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
    <div>
        <h3 class="text-lg md:text-xl font-semibold text-gray-900">Daftar User</h3>
        <p class="text-sm text-gray-600 mt-1">Kelola akses dan pengguna sistem</p>
    </div>
    <a href="{{ route('users.create') }}" 
       class="inline-block px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200 text-center text-sm md:text-base">
        + Tambah User
    </a>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total User</p>
        <h3 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $users->total() }}</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Admin</p>
        <h3 class="text-3xl md:text-4xl font-bold text-purple-600">{{ $users->where('role', 'admin')->count() }}</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Kasir</p>
        <h3 class="text-3xl md:text-4xl font-bold text-blue-600">{{ $users->where('role', 'kasir')->count() }}</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">User Aktif</p>
        <h3 class="text-3xl md:text-4xl font-bold text-green-600">{{ $users->count() }}</h3>
    </div>
</div>

<!-- Table Section -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden sm:table-cell">Email</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">Terdaftar</th>
                    <th class="px-4 md:px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 md:px-6 py-4 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-4 md:px-6 py-4 text-sm text-gray-600 hidden sm:table-cell">{{ $user->email }}</td>
                        <td class="px-4 md:px-6 py-4 text-sm">
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-sm text-gray-600 hidden md:table-cell">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 md:px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('users.edit', $user->id) }}" 
                                   class="text-blue-600 hover:text-blue-700 text-xs md:text-sm font-medium">Edit</a>
                                @if($user->id !== auth()->id() && !($user->role === 'admin' && \App\Models\User::where('role', 'admin')->count() <= 1))
                                    <button type="button" 
                                            onclick="confirmDelete('{{ route('users.destroy', $user->id) }}')"
                                            class="text-red-600 hover:text-red-700 text-xs md:text-sm font-medium">Hapus</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 md:px-6 py-12 text-center text-gray-500">
                            <p class="text-sm">Belum ada user. <a href="{{ route('users.create') }}" class="text-orange-600 font-medium hover:text-orange-700">Tambah user baru</a></p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<!-- Pagination -->
@if($users->hasPages())
    <div class="mt-6 flex justify-center">
        {{ $users->links() }}
    </div>
@endif

<script>
    function confirmDelete(url) {
        if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>

@endsection
