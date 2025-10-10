<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pelajaran Lab</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <div class="header">JADWAL PELAJARAN</div>
        
        <div class="main-content">
            <div class="left-section">
                @if($jadwal_hari_ini)
                <div class="teacher-info">
                    <div class="teacher-photo">
                        @if($jadwal_hari_ini->foto_guru)
                            <img src="{{ asset('storage/' . $jadwal_hari_ini->foto_guru) }}" alt="Foto Guru">
                        @else
                            <img src="{{ asset('images/i.png') }}" alt="Foto Guru">
                        @endif
                    </div>
                    <div class="teacher-details">
                        <div class="teacher-name">{{ strtoupper($jadwal_hari_ini->nama_guru) }}</div>
                        <div class="subject">{{ strtoupper($jadwal_hari_ini->pelajaran) }}</div>
                        <div class="schedule-time">
                            <span class="time-box">Masuk: {{ $jadwal_hari_ini->jam_masuk }}</span>
                            <span class="time-box">Keluar: {{ $jadwal_hari_ini->jam_keluar }}</span>
                        </div>
                    </div>
                </div>
                @else
                <div class="teacher-info">
                    <div class="teacher-photo">
                        <!-- <img src="{{ asset('images/i.png') }}" alt="Foto Guru"> -->
                    </div>
                    <div class="teacher-details">
                        <div class="teacher-name">Belum ada jadwal</div>
                        <div class="subject">-</div>
                    </div>
                </div>
                @endif
                
                <div class="current-time">
                    <div class="time-display" id="time">--:--:--</div>
                    <div class="date-display" id="date"></div>
                    <div class="greeting">"have a nice day."</div>
                </div>
            </div>
            
            <div class="right-section">
                @forelse($jadwal_semua as $jadwal)
                <div class="schedule-item">
                    <div class="schedule-item-content">
                        <div class="subject-name">{{ $jadwal->pelajaran }}</div>
                        <div class="time-range">({{ $jadwal->jam_masuk }} - {{ $jadwal->jam_keluar }})</div>
                    </div>
                </div>
                @empty
                <div class="schedule-item">Belum ada jadwal untuk hari ini.</div>
                @endforelse
            </div>
        </div>
        
        <div class="footer">
            <div class="footer-left">
                <div class="footer-text">
                    Pelajaran: {{ $jadwal_hari_ini ? $jadwal_hari_ini->pelajaran : '-' }}
                </div>
            </div>
            <div class="footer-right">
                <div class="school-logo">
                    <img src="https://placehold.co/100x100/0d47a1/ffffff?text=SMK" alt="Logo SMK">
                </div>
                <div class="school-logo">
                    <img src="https://placehold.co/100x100/1a6dff/ffffff?text=LAB" alt="Logo Lab">
                </div>
            </div>
        </div>
    </div>

    <script>
        // Update time and date
        function updateTime() {
            const now = new Date();
            
            // Format time
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('time').textContent = `${hours}:${minutes}:${seconds}`;
            
            // Format date
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            const dayName = days[now.getDay()];
            const day = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();
            
            document.getElementById('date').textContent = `${dayName}, ${day} ${month} ${year}`;
        }
        
        setInterval(updateTime, 1000);
        updateTime();
    </script>
</body>
</html>
