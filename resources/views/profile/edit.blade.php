@extends('layouts.app')

@section('title', 'Edit Profile')
@section('header-title', 'Edit Profile')
@section('header-subtitle', 'Perbarui informasi profile Anda')

@section('content')
<div class="max-w-2xl mx-auto mt-8">
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Avatar Upload -->
                <div class="text-center">
                    <div class="relative w-32 h-32 mx-auto mb-4 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden border-2 border-gray-300">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" id="avatar-preview" class="w-full h-full object-cover">
                        @else
                            <span class="text-4xl text-gray-400" id="avatar-placeholder">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                            <img src="" alt="Avatar" id="avatar-preview" class="w-full h-full object-cover hidden">
                        @endif
                    </div>
                    
                    <div class="flex justify-center gap-2">
                        <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden">
                        <button type="button" onclick="document.getElementById('avatar').click()" 
                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition-colors text-sm">
                            📁 Pilih Foto
                        </button>
                        
                        @if($user->avatar)
                        <button type="button" onclick="removeAvatar()" 
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-500 transition-colors text-sm">
                            🗑️ Hapus
                        </button>
                        @endif
                    </div>
                    
                    <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, GIF (Maks. 2MB)</p>
                    
                    <!-- Hidden input untuk hapus avatar -->
                    <input type="hidden" name="remove_avatar" id="remove_avatar" value="0">
                </div>

                <!-- Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                               class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                               class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <!-- Student Info - Hanya untuk Siswa -->
                @if($user->role === 'siswa')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
                        <select name="kelas" id="kelas" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Pilih Kelas</option>
                            <option value="X" {{ old('kelas', $user->kelas) == 'X' ? 'selected' : '' }}>X</option>
                            <option value="XI" {{ old('kelas', $user->kelas) == 'XI' ? 'selected' : '' }}>XI</option>
                            <option value="XII" {{ old('kelas', $user->kelas) == 'XII' ? 'selected' : '' }}>XII</option>
                        </select>
                    </div>

                    <div>
                        <label for="jurusan" class="block text-sm font-medium text-gray-700">Jurusan</label>
                        <select name="jurusan" id="jurusan" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Pilih Jurusan</option>
                            <option value="AKL" {{ old('jurusan', $user->jurusan) == 'AKL' ? 'selected' : '' }}>AKL</option>
                            <option value="TKJ" {{ old('jurusan', $user->jurusan) == 'TKJ' ? 'selected' : '' }}>TKJ</option>
                            <option value="BiD" {{ old('jurusan', $user->jurusan) == 'BiD' ? 'selected' : '' }}>BiD</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nisn" class="block text-sm font-medium text-gray-700">NISN</label>
                        <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $user->nisn) }}" 
                               class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" 
                               class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                @else
                <!-- Teacher Info - Hanya untuk Guru -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" 
                               class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <p class="mt-1 px-3 py-2 bg-blue-100 text-blue-800 rounded-lg font-semibold">
                            👨‍🏫 Guru
                        </p>
                    </div>
                </div>
                @endif

                <!-- Bio - Untuk Semua -->
                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                    <textarea name="bio" id="bio" rows="3" 
                              class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('bio', $user->bio) }}</textarea>
                </div>

                <!-- Actions -->
                <div class="flex gap-4 pt-6">
                    <a href="{{ route('profile.index') }}" 
                       class="flex-1 px-4 py-2 bg-gray-500 text-white text-center rounded-lg hover:bg-gray-600 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Preview avatar image
    document.getElementById('avatar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validasi ukuran file (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB');
                this.value = '';
                return;
            }
            
            // Validasi tipe file
            const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                alert('Format file harus JPG, PNG, atau GIF');
                this.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
                document.getElementById('avatar-placeholder').style.display = 'none';
                document.getElementById('avatar-preview').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    // Remove avatar
    function removeAvatar() {
        document.getElementById('avatar-preview').classList.add('hidden');
        document.getElementById('avatar-placeholder').style.display = 'flex';
        document.getElementById('avatar').value = '';
        document.getElementById('remove_avatar').value = '1';
    }
</script>
@endsection