@extends('partial.app')
@section('title','Dashboard')
@section('content')
@php
    use Carbon\Carbon;
    $notifList = \App\Models\NotificationMaster::with('notifdtl')
    ->whereHas('notifdtl', function ($query) {
        $query->where('fc_userid', auth()->user()->fc_userid)
            ->whereNull('fd_watchingdate');
    })
    ->orderBy('fd_notifdate', 'DESC')
    ->limit(3)
    ->get();

    $notifCount = \App\Models\NotificationMaster::where('fc_status', 'R')->count();

        // @dd($notifList)
@endphp

<div class="section-body">
 <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
      <div class="card">
        <div class="card-body ">
          <div class="text-center mb-2 mt-2">
            <h3 class="text-primary">Welcome Back, {{ auth()->user()->fc_userid }}!</h3>
          </div>
        </div>
      </div>
    </div>
  </div> 
  <div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
          <i class="far fa-user"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Total User</h4>
          </div>
          <div class="card-body">
            {{ $userCount }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-info">
          <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Sales Order</h4>
          </div>
          <div class="card-body">
            {{ $soCount }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-warning">
          <i class="fas fa-people-carry"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Purchase Order</h4>
          </div>
          <div class="card-body">
            {{ $poCount }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-success">
          <i class="fas fa-credit-card"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Invoice</h4>
          </div>
          <div class="card-body">
            {{ $invCount }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
      <div class="card card-hero">
        <div class="card-header">
          <div class="card-icon">
            <i class="far fa-bell"></i>
          </div>
          <h4>{{ $notifCount }}</h4>
          <div class="card-description">Notifications</div>
        </div>
        <div class="card-body p-0">
          <div class="tickets-list">
            @foreach ($notifList as $notif)
            <a href="{{ $notif->fv_link }}"  class="ticket-item handle-notification" data-notificationCode="{{ $notif->fc_notificationcode }}">
              <div class="ticket-title">
                <h4>{{ $notif->fc_tittle }}</h4>
                <div class="col-lg-8 col-md-12 col-sm-12 col-12 text-dark">
                <p>{{ $notif->fc_message }}</p>
                </div>
              </div>
              <div class="ticket-info">
                <div>{{ $notif->fc_notiftype }}</div>
                <div class="bullet"></div>
                <div class="text-primary">{{ Carbon::parse($notif->fd_notifdate)->diffForHumans() }}</div>
              </div>
            </a>
            @endforeach
            <a href="/dashboard" class="ticket-item ticket-more">
              View All <i class="fas fa-chevron-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
  $(document).ready(function() {
  $('.handle-notification').click(function(event) {
    event.preventDefault(); 
    
    var notificationCode = $(this).data('notificationcode');
    var url = $(this).attr('href');
   
    $.ajax({
      url: '/reading-notification-click',
      type: 'POST',
      data: { 
        fc_notificationcode: notificationCode,
        fv_url : url
      },
      success: function(response) {
        if(response.status == 200){
          // arahkan ke response.link
          window.location= response.link;
        }else{
          swal(response.message, { icon: 'error', });
        }
      },
      error: function(xhr) {
        swal(response.message, { icon: 'error', });
        console.log('Terjadi kesalahan saat mengirim data');
      }
    });
  });
});

  
</script>
@endsection