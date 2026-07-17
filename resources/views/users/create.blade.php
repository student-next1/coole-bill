@extends('layouts.app')

@section('title','Tambah User')
@section('page-title','Tambah User')

@section('content')

<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h3 class="text-2xl font-semibold text-gray-900">Tambah User Baru</h3>
        <p class="text-sm text-gray-600 mt-2">Isi form di bawah untuk menambahkan user baru ke sistem</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 md:p-8">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <!-- Nama Lengkap -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" 
                       name="name" 
                       placeholder="Misal: John Doe"
                       value="{{ old('name') }}"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Email <span class="text-red-500">*</span></label>
                <input type="email" 
                       name="email" 
                       placeholder="user@email.com"
                       value="{{ old('email') }}"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Username -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Username <span class="text-red-500">*</span></label>
                <input type="text" 
                       name="username" 
                       placeholder="username"
                       value="{{ old('username') }}"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm @error('username') border-red-500 @enderror">
                @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Password <span class="text-red-500">*</span></label>
                    <input type="password" 
                           name="password" 
                           placeholder="••••••••"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" 
                           name="password_confirmation" 
                           placeholder="••••••••"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm @error('password_confirmation') border-red-500 @enderror">
                    @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Role -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Role <span class="text-red-500">*</span></label>
                <select name="role" 
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm @error('role') border-red-500 @enderror">
                    <option value="">-- Pilih Role --</option>
                    <option value="kasir" @selected(old('role') == 'kasir')>Kasir</option>
                    <option value="admin" @selected(old('role') == 'admin')>Admin</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4 border-t border-slate-200">
                <a href="{{ route('users.index') }}" 
                   class="flex-1 px-4 py-2 border border-slate-300 text-gray-900 font-medium rounded-lg hover:bg-slate-50 transition-colors text-center text-sm">
                    Batal
                </a>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200 text-sm">
                    Simpan User
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
