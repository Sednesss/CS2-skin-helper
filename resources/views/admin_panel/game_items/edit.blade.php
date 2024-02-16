@extends('adminlte::page')

@section('title', 'AdminPanel')

@section('content_header')
<h1 class="m-0 text-dark">Игровой предмет: <strong>{{ $gameItem->title }} (ID:{{ $gameItem->id }})</strong></h1>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_panel/game_items/edit.css" />
@stop

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Редактирование</h3>
            </div>
            <form method="POST" action="{{ route('admin_panel::game_items::update', $gameItem->id) }}" id="new_game_item-form">
                @csrf
                <div class="card-body">
                    <div class="form-group" id="newGameItem_title">
                        <label for="title">Название</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Введите название" value="{{ $gameItem->title }}">
                    </div>

                    <div class="form-group" id="newGameItem_description">
                        <label for="description">Описание</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Введите описание" rows="4" no-resize>{{ $gameItem->description }}</textarea>
                    </div>
                </div>

                <div class="card-footer">
                    <a class="btn btn-secondary" href="{{ route('admin_panel::game_items::show', $gameItem->id) }}">Отменить</a>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop