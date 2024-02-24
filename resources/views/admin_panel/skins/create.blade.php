@extends('adminlte::page')

@section('title', 'AdminPanel')

@section('content_header')
<h1 class="m-0 text-dark">Новый скин @if($isForGameItem) для <strong>{{ $gameItem->title }} (ID:{{ $gameItem->id }})</strong> @endif</h1>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_panel/skins/create.css" />
@stop

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Скин</h3>
            </div>
            <form method="POST" action="{{ route('admin_panel::skins::store') }}" id="new_skin-form">
                @csrf
                <div class="card-body">
                    @if($isForGameItem)
                    <input type="hidden" id="game_item_id" name="game_item_id" value="{{ $gameItem->id }}">
                    @else
                    <div class="form-group" id="game_item_id">
                        <label for="title">Название</label>
                        <select class="form-control" id="game_item_id" name="game_item_id">
                            @foreach($gameItems as $gameItemElement)
                                <option value="{{ $gameItemElement->id }}">{{ $gameItemElement->title }} (ID:{{ $gameItemElement->id }})</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="form-group" id="newSkin_description">
                        <label for="description">Описание</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Введите описание" rows="4" no-resize></textarea>
                    </div>

                    <div class="form-group" id="newSkin_pattern">
                        <label for="pattern">Паттерн</label>
                        <input type="number" class="form-control" id="pattern" name="pattern" placeholder="Введите число от 1 до 999" min="1" max="999">
                    </div>

                    <div class="form-group" id="newSkin_float">
                        <label for="float">Флоат</label>
                        <input type="number" class="form-control" id="float" name="float" placeholder="Введите число с плавающей запятой от 0 до 1" min="0" max="1" step="0.001">
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