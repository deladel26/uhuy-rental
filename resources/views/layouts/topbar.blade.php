@php
    $user = Auth::user();
    $greeting = '';
    $hour = date('H');

    if ($hour < 12) {
        $greeting = 'Selamat Pagi';
    } elseif ($hour < 17) {
        $greeting = 'Selamat Siang';
    } elseif ($hour < 19) {
        $greeting = 'Selamat Sore';
    } else {
        $greeting = 'Selamat Malam';
    }
@endphp

<div class="topbar">
    <div>
        <h2 class="topbar-title">{{ $greeting }}, {{ $user->name }}! 👋</h2>
        <p class="topbar-subtitle">
            <i class="fas fa-calendar-day me-2"></i>{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}
        </p>
    </div>

    <div class="topbar-actions">
        <div class="topbar-btn" title="Profile">
            <i class="fas fa-user"></i>
        </div>
    </div>
</div>
