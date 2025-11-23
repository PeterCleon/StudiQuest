@extends('layouts.app')

@section('title', 'Profile')
@section('header-title', 'Profile Saya')
@section('header-subtitle', 'Kelola informasi profile Anda')

@section('content')
<div class="max-w-4xl mx-auto mt-8">
    @if($user->role === 'siswa')
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" 
            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    @endif
    @if($user->role === 'guru')
        <div class="mb-6">
            <a href="{{ route('teacher.dashboard') }}" 
            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    @endif
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Data Profile</h2>
            <a href="{{ route('profile.edit') }}" 
               class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition-colors">
                Edit Profile
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Avatar & Basic Info -->
            <div class="md:col-span-1">
                <div class="text-center">
                    <div class="w-32 h-32 mx-auto mb-4 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                            <span class="text-4xl text-gray-400">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    <span class="inline-block mt-2 px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                        {{ $user->role === 'guru' ? '👨‍🏫 Guru' : '👨‍🎓 Siswa' }}
                    </span>
                </div>
            </div>

            <!-- Detail Information -->
            <div class="md:col-span-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-4">
                        @if($user->role === 'siswa')
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Kelas</label>
                            <p class="mt-1 text-gray-900 font-semibold">
                                {{ $user->kelas ?? '-' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Jurusan</label>
                            <p class="mt-1 text-gray-900 font-semibold">
                                {{ $user->jurusan ?? '-' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-600">NISN</label>
                            <p class="mt-1 text-gray-900">
                                {{ $user->nisn ?? '-' }}
                            </p>
                        </div>
                        @else
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Role</label>
                            <p class="mt-1 text-gray-900 font-semibold">
                                👨‍🏫 Guru
                            </p>
                        </div>
                        @endif
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Nomor Telepon</label>
                            <p class="mt-1 text-gray-900">
                                {{ $user->phone ?? '-' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Jenis Kelamin</label>
                            <p class="mt-1 text-gray-900">
                                {{ $user->gender == 'L' ? 'Laki-laki' : ($user->gender == 'P' ? 'Perempuan' : '-') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Bio -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-600">Bio</label>
                    <p class="mt-2 text-gray-700 bg-gray-50 p-4 rounded-lg">
                        {{ $user->bio ?? 'Belum ada bio...' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Card -->
    @if($user->playerProfile)
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-xl shadow-sm border text-center">
            <div class="text-2xl font-bold text-indigo-600">{{ $user->playerProfile->level }}</div>
            <div class="text-sm text-gray-600">Level</div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border text-center">
            <div class="text-2xl font-bold text-green-600">{{ $user->playerProfile->xp }}</div>
            <div class="text-sm text-gray-600">Total XP</div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $user->quizzes->count() }}</div>
            <div class="text-sm text-gray-600">Quiz Diselesaikan</div>
        </div>
    </div>
    @endif

    <!-- Teacher Stats (Hanya untuk Guru) -->
    @if($user->role === 'guru')
    <div class="mt-6 bg-white rounded-xl shadow-sm border p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">📊 Statistik Guru</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-4 bg-indigo-50 rounded-lg">
                <div class="text-2xl font-bold text-indigo-600">
                    {{ $user->quizzes()->where('created_by', $user->id)->count() }}
                </div>
                <div class="text-sm text-gray-600">Quiz Dibuat</div>
            </div>
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <div class="text-2xl font-bold text-green-600">
                    {{ \App\Models\Question::where('created_by', $user->id)->count() }}
                </div>
                <div class="text-sm text-gray-600">Soal Dibuat</div>
            </div>
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <div class="text-2xl font-bold text-blue-600">0</div>
                <div class="text-sm text-gray-600">Siswa Mengikuti</div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection