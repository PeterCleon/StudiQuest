<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <title>StudyQuest - Login</title>
  
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'study-primary': '#5E35B1',
            'study-secondary': '#8A2BE2',
          },
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
            heading: ['Montserrat', 'sans-serif'],
          },
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Montserrat:wght@700&display=swap" rel="stylesheet">
</head>

<body class="min-h-screen flex antialiased h-[750px]">

  <!-- BAGIAN KIRI DENGAN BACKGROUND VIDEO -->
  <div class="hidden lg:flex lg:w-3/5 min-h-screen relative overflow-hidden justify-center items-center">

      <!-- Video Background -->
      <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
          <source src="{{ asset('videos/bg.mp4') }}" type="video/mp4">
      </video>

      <!-- Overlay warna (biar tetap nuansa StudyQuest) -->
      <div class="absolute inset-0 bg-gradient-to-br from-study-secondary/20 to-study-primary/70"></div>

      <!-- Konten -->
      <div class="relative z-10 text-white text-center p-12 flex flex-col items-center">
          <h1 class="font-heading text-6xl font-extrabold mb-4">StudyQuest</h1>
          <p class="text-2xl opacity-80">Mulai petualangan belajarmu, taklukkan setiap misi!</p>
          
          <div class="mt-12 w-full max-w-lg mx-auto">
              <div class="bg-purple-800/30 h-64 rounded-2xl flex items-center justify-center border border-white/20">
                  <span class="text-white/80 italic text-lg">Area Animasi Gamifikasi/Ilustrasi (60% layar)</span>
              </div>
          </div>
      </div>

  </div>

  <!-- BAGIAN KANAN (FORM LOGIN) -->
  <div class="w-full lg:w-2/5 min-h-screen bg-white flex flex-col justify-center items-center p-8 sm:p-12">
    <div class="absolute top-6 right-6">
      <img src="{{ asset('images/logo.png') }}" alt="StudyQuest Logo" class="h-10 w-auto">
    </div>
    <div class="w-full max-w-md">
      <h2 class="font-heading text-4xl font-extrabold text-study-primary mb-8 text-center">Login</h2>
      <hr class="border-gray-300 my-6">       

      <form class="space-y-6" method="post" action="{{ route('login') }}">
        @csrf
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
            <input
                type="email"
                name="email"
                id="email"
                class="w-full mt-2 px-4 py-3 border border-gray-300 rounded-xl focus:border-study-primary focus:ring-1 focus:ring-study-primary transition duration-150"
                placeholder="email@example.com"
                required
            />
            @error('email')
								<p class="text-sm text-red-500 mt-1">{{ $message }}</p>
						@enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
            <input
                type="password"
                name="password"
                id="password"
                class="w-full mt-2 px-4 py-3 border border-gray-300 rounded-xl focus:border-study-primary focus:ring-1 focus:ring-study-primary transition duration-150"
                placeholder="••••••••"
                required
            />
            @error('password')
								<p class="text-sm text-red-500 mt-1">{{ $message }}</p>
						@enderror
        </div>

        <button type="submit" class="w-full py-3 rounded-xl bg-study-primary text-white font-bold text-lg hover:bg-study-secondary transition duration-300 shadow-md">
            Login
        </button>
      </form>

      <p class="mt-8 text-center text-base text-gray-600">
          Belum punya akun?
          <a href="/register" class="text-study-primary font-bold hover:text-study-secondary hover:underline transition duration-150">Register</a>
      </p>
    </div>
  </div>
</body>
</html>
