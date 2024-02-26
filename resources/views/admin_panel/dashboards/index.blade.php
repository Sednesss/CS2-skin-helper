@extends('adminlte::page')

@section('title', 'AdminPanel')

@section('content_header')
<h1 class="m-0 text-dark">Общая статистика</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-cube"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Игровые предметы</span>
                <span class="info-box-number">{{ $gameItemsCount }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-cubes"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Добавлено скинов</span>
                <span class="info-box-number">{{ $skinsCount }}</span>
            </div>
        </div>
    </div>
    <div class="clearfix hidden-md-up"></div>
</div>
@stop