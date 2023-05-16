@extends('partial.app')
@section('title','Dashboard')
@section('content')

<div class="section-body">
  <!-- <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
      <div class="card">
        <div class="card-body ">
          <div class="text-center mb-2 mt-2">
            <h3 class="text-primary">Welcome Back, {{ auth()->user()->fc_userid }}!</h3>
          </div>
        </div>
      </div>
    </div>
  </div> -->
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
          <h4>3</h4>
          <div class="card-description">Notifications</div>
        </div>
        <div class="card-body p-0">
          <div class="tickets-list">
            <a href="#" class="ticket-item">
              <div class="ticket-title">
                <h4>Jangan lupa SO0001 Dikirim</h4>
              </div>
              <div class="ticket-info">
                <div>Sales Order</div>
                <div class="bullet"></div>
                <div class="text-primary">1 min ago</div>
              </div>
            </a>
            <a href="#" class="ticket-item">
              <div class="ticket-title">
                <h4>Cancel PO0002</h4>
              </div>
              <div class="ticket-info">
                <div>Purchase Order</div>
                <div class="bullet"></div>
                <div>2 hours ago</div>
              </div>
            </a>
            <a href="#" class="ticket-item">
              <div class="ticket-title">
                <h4>Stok sisa 5, jangan lupa belanja !</h4>
              </div>
              <div class="ticket-info">
                <div>Master Stock</div>
                <div class="bullet"></div>
                <div>6 hours ago</div>
              </div>
            </a>
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