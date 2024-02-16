@extends('adminlte::page')

@section('title', 'AdminPanel')

@section('content_header')
<h1 class="m-0 text-dark">Новый игровой предмет</h1>
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
                    <div class="form-group" id="newGameItem_title">
                        <label for="title">Название</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Введите название">
                    </div>

                    <div class="form-group" id="newGameItem_description">
                        <label for="description">Описание</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Введите описание" rows="4" no-resize></textarea>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Продолжить</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop