# StudyQuest 🎯

Aplikasi Quiz Edukasi berbasis Laravel dengan sistem gamifikasi untuk meningkatkan engagement belajar siswa.

## 🚀 Fitur Utama

### 👨‍🎓 Untuk Siswa
- **Quiz Interaktif** - Sistem pengerjaan quiz dengan interface modern
- **Daily Challenges** - Challenge harian yang berganti otomatis (3 random per hari)
- **Sistem XP & Level** - Progression system dengan experience points
- **Riwayat Quiz** - Melihat hasil dan history pengerjaan quiz
- **Player Profile** - Profil dengan avatar, level, dan statistik
- **Progress Tracking** - Memantau perkembangan belajar

### 👨‍🏫 Untuk Guru
- **Dashboard Guru** - Panel khusus untuk management quiz
- **Buat & Kelola Quiz** - Membuat quiz baru dengan mudah
- **Bank Soal** - Management questions dan pilihan jawaban
- **Tracking Siswa** - Memantau hasil pengerjaan siswa
- **Analytics** - Statistik performa siswa

## 🗂️ Entitas Database

### Model Utama
- **User** - Users dengan role (siswa/guru)
- **Quiz** - Data quiz dengan XP reward
- **Question** - Soal-soal dalam quiz
- **Choice** - Pilihan jawaban (benar/salah)
- **DailyChallenge** - Challenge harian otomatis
- **UserChallenge** - Progress challenge user
- **PlayerProfile** - Data level & XP user

### Relasi Penting
- **User → Quizzes** (Many to Many via quiz_user)
- **Quiz → Questions** (One to Many)
- **Question → Choices** (One to Many)
- **User → DailyChallenges** (Many to Many via user_challenges)
- **User → PlayerProfile** (One to One)


## 🛠️ Teknologi

- **Backend:** Laravel 11
- **Frontend:** Tailwind CSS
- **Database:** MySQL
- **Storage:** Laravel Filesystem

## 📥 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/PeterCleon/StudiQuest.git
cd StudiQuest
composer install
npm install
cp .env.example .env
php artisan key:generate

# Ubah isi .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=studyquest
DB_USERNAME=root
DB_PASSWORD=

php artisan migrate
php artisan storage:link 
```

## 📄 Lisensi
Distributed under the MIT License.

## 👨‍💻 Developer
Peter Cleon - GitHub