<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'StudyQuest')</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'study-primary': '#6d28d9',
                        'study-secondary': '#8b5cf6',
                        'quiz-card': '#f3e8ff'
                    },
                    fontFamily: {
                        heading: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body { font-family: 'Inter', sans-serif; }

        @keyframes pop {
            0% { transform: scale(0.6); opacity: 0; }
            70% { transform: scale(1.05); opacity: 1; }
            100% { transform: scale(1); }
        }

		/* small custom theme tweak */
		:root{
		--purple-600: #6B46C1;
		--purple-500: #7C3AED;
		--purple-400: #9F7AEA;
		--muted: #6B7280;
		}

		/* gentle card shadow for premium look */
		.soft-card {
		box-shadow: 0 6px 20px rgba(50,50,70,0.06);
		}

		/* small pop animation for level-up message (if used) */
		@keyframes pop {
		from { transform: translateY(6px) scale(.98); opacity: 0; }
		to { transform: translateY(0) scale(1); opacity: 1; }
		}

		.avatar-loading {
			opacity: 0.6;
			filter: blur(2px);
		}
		
		.avatar-preview {
			transition: all 0.3s ease;
		}
    </style>
</head>

<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen relative">

	<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">

    <!-- HEADER -->
	<header class="w-full bg-white border-b h-[80px] px-6 flex items-center justify-between sticky top-0 z-30">

		<!-- LEFT: TITLE -->
		<div>
			<h1 class="text-2xl font-bold text-gray-800">
				@yield('header-title', 'Dashboard')
			</h1>

			<p class="text-gray-500 text-sm">
				@yield('header-subtitle', 'Selamat datang kembali, ' . ($user->name ?? 'User') . ' 👋')
			</p>
		</div>

		<!-- RIGHT: PROFILE DROPDOWN -->
		<div class="relative">

			<input type="checkbox" id="profileToggle" class="peer hidden">

			<label for="profileToggle" class="flex items-center gap-3 cursor-pointer space-x-2 text-gray-700 hover:text-indigo-600 transition-colors">
				@if(Auth::user()->avatar)
					<img src="{{ asset('storage/' . Auth::user()->avatar) }}" 
						alt="Avatar" 
						class="w-8 h-8 rounded-full object-cover">
				@else
					<div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
						<span class="text-sm font-semibold text-indigo-600">
							{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
						</span>
					</div>
				@endif
				<span>{{ Auth::user()->name }}</span>
				<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
				</svg>
			</label>

			<!-- DROPDOWN BOX -->
			<div class="absolute right-0 mt-3 w-44 bg-white border rounded-lg shadow-lg
						opacity-0 scale-95 pointer-events-none
						peer-checked:opacity-100 peer-checked:scale-100 peer-checked:pointer-events-auto
						transition-all duration-150">

				<a href="{{ route('profile.index') }}" 
				class="block px-4 py-2 hover:bg-gray-100 text-gray-700 text-sm">
					👤 Profile Settings
				</a>
				@auth
					@if(Auth::user()->role === 'guru')
						<a href="{{ route('teacher.dashboard') }}" 
						class="block px-4 py-2 hover:bg-gray-100 text-gray-700 text-sm">
							👨‍🏫 Guru
						</a>
					@endif
					@if(Auth::user()->role === 'siswa')
						<a href="{{ route('quiz.history') }}" 
						class="block px-4 py-2 hover:bg-gray-100 text-gray-700 text-sm">
							📊 History
						</a>
					@endif
				@endauth
				<form method="POST" action="{{ route('logout') }}">
					@csrf
					<button
						class="w-full text-left px-4 py-2 hover:bg-gray-100 text-gray-700 text-sm">
							🚪 Logout
					</button>
				</form>

			</div>
		</div>

	</header>



    <!-- MAIN CONTENT -->
    <main class="p-4 sm:p-8 relative">
        @yield('content')
    </main>

</body>
</html>
