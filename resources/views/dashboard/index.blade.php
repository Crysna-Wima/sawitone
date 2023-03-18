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
  </div>
</div>
@endsection