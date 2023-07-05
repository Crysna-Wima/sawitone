@extends('partial.app')
@section('title','Notifications')
@php
use App\Helpers\App;
use Carbon\Carbon;

$notifList = \App\Models\NotificationMaster::with('notifdtl')
->whereHas('notifdtl', function ($query) {
$query->where('fc_userid', auth()->user()->fc_userid);
// ->whereNull('fd_watchingdate');
})
->orderBy('fd_notifdate', 'DESC')
->limit(3)
->get();

@endphp

@section('css')
<style>
    .card.card-statistic-1 .card-icon {
        width: 100px;
        height: 100px;
    }

    .card.card-statistic-1 .card-header {
        padding-top: 20px;
    }

    .left-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .d-flex {
        gap: 20px;
    }

    .notif-content:hover {
        text-decoration: none;
    }
</style>
@endsection

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            @foreach ($notifList as $notif)
            @php
            $status = $icon = $notif->notifdtl->where('fc_userid', auth()->user()->fc_userid)->first()->fd_watchingdate === null ? 'Belum dibaca' : 'Telah dibaca';
            $icon = $notif->notifdtl->where('fc_userid', auth()->user()->fc_userid)->first()->fd_watchingdate === null ? 'fa-book-open' : 'fa-check';
            $bgColorClass = $notif->notifdtl->where('fc_userid', auth()->user()->fc_userid)->first()->fd_watchingdate === null ? 'bg-warning text-white' : 'bg-success text-white';
            @endphp
            <a href="{{ $notif->fv_link }}" class="notif-content" data-notificationCode="{{ $notif->fc_notificationcode }}">
                <div class="card">
                    <div class="card-body d-flex flex-wrap align-items-center">
                        <div class="left-icon {{ $bgColorClass }}">
                            <i class="fas {{ $icon }}" style="font-size: 18px;"></i>
                        </div>
                        <div class="right-info">
                            <b style="font-size: 16px; color:black;">{{ $notif->fc_tittle }}</b>
                            <div class="notification" style="font-size: 14px; font-weight:500; color:black">{{ $notif->fc_message }}</div>
                            <div class="text-muted" style="font-size: 12px; margin-top: 5px; font-weight:500">{{ Carbon::parse($notif->fd_notifdate)->diffForHumans() }}
                                <div class="bullet"></div> <i>{{ $status }}</i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('modal')

@endsection

@section('js')
<script>
</script>
@endsection