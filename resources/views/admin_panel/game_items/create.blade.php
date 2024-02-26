@extends('adminlte::page')

@section('title', 'AdminPanel')

@section('content_header')
<h1 class="m-0 text-dark">Новый игровой предмет</h1>
@stop

@section('js')
<script src="/js/admin_panel/game_items/create.js"></script>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_panel/game_items/create.css" />
@stop

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Игровой предмет</h3>
            </div>
            <form method="POST" action="{{ route('admin_panel::game_items::store') }}" id="new_game_item-form">
                @csrf
                <div class="card-body">
                    <div class="form-group" id="new_game_item-title">
                        <label for="title">Название</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Введите название" value="{{ old('title') }}">
                    </div>

                    <div class="form-group" id="new_game_item-description">
                        <label for="description">Описание</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Введите описание" rows="4" no-resize>{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="card-footer">
                    <a class="btn btn-secondary" href="{{ redirect()->back()->getTargetUrl() }}">Отменить</a>
                    <button type="submit" class="btn btn-primary">Продолжить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="page_alerts" class="toasts-top-right fixed">
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <div class="toast bg-danger fade show alert-error">
        <div class="toast-header">
            <strong class="mr-auto">Save error</strong>
            <small class="ml-2">Incorrect input</small>
            <button type="button" class="ml-2 mb-1 close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="toast-body">{{ $error }}</div>
    </div>
    @endforeach
    @endif
</div>

@stop