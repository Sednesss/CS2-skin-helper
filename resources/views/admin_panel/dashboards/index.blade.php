@extends('adminlte::page')

@section('title', 'AdminPanel')

@section('content_header')
<h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Количество предметов</span>
                <span class="info-box-number">{{ $gameItemsCount }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-book"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Добавлено скинов</span>
                <span class="info-box-number">{{ $skinsCount }}</span>
            </div>
        </div>
    </div>
    <div class="clearfix hidden-md-up"></div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-shopping-cart"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">---</span>
                <span class="info-box-number">999</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">---</span>
                <span class="info-box-number">1999</span>
            </div>
        </div>
    </div>
</div>
@stop