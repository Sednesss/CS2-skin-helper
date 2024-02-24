@extends('adminlte::page')

@section('title', 'AdminPanel')

@section('content_header')
<h1 class="m-0 text-dark">Игровой предмет: <strong>{{ $gameItem->title }} (ID:{{ $gameItem->id }})</strong></h1>
@stop

@section('js')
<script src="/js/admin_panel/game_items/show.js"></script>
<script>
    var gameItem = {!! $gameItem->toJson() !!};
</script>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_panel/game_items/show.css" />
<meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary" id="game_item-form">
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Название</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $gameItem->title }}" disabled>
                </div>

                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea class="form-control" id="description" name="description" rows="4" disabled>{{ $gameItem->description }}</textarea>
                </div>

                <div class="form-group" id="game_item-status">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="status" name="status" @if($gameItem->status == 1) checked @endif>
                        <label class="custom-control-label" for="status">Статус активности</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-primary" id="game_item-actions">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <a class="btn btn-block btn-secondary" href="{{ route('admin_panel::game_items::edit', $gameItem->id) }}">Редактировать</a>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <form action="{{ route('admin_panel::game_items::destroy', $gameItem->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-block btn-danger">Удалить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card col-md-8">
        <div class="card-header">
            <h3 class="card-title">Список скинов</h3>
        </div>

        <div class="card-body" id="game_item_skins">
            <div class="dataTables_wrapper dt-bootstrap4">
                <div class="row mb-2" id="game_item_skins-actions">
                    <div class="col-sm-12 col-md-12">
                        <div class="dt-buttons btn-group flex-wrap">
                            <a class="btn btn-secondary" href="{{ route('admin_panel::skins::create', ['game_item' => $gameItem->id]) }}">
                                <i class="fas fa-plus"></i>
                                <span>Добавить</span>
                            </a>
                            <button class="btn btn-secondary" tabindex="0" type="button">
                                <i class="fas fa-arrow-down"></i>
                                <span>Экспорт в Excel</span>
                            </button>
                            <div class="btn-group" id="game_item_skins-import">
                                <button class="btn btn-secondary dropdown-toggle" id="game_item_skins-button_import_menu" tabindex="0" type="button">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>Импорт из Excel</span>
                                </button>
                                <div class="dropdown-menu" id="game_item_skins-import_menu">
                                    <a class="dropdown-item" href="#">Полное обновление</a>
                                    <a class="dropdown-item" href="#">Добавление новых</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($skinsTotalPages != 0)
                <div class="row" id="game_item_skins-data">
                    <div class="col-sm-12 col-md-12">
                        <table class="table table-bordered table-hover dataTable dtr-inline border-0" id="game_item_skins-table">
                            <thead>
                                <tr>
                                    <th class="col-1 align-middle py-1">№</th>
                                    <th class="col-1 align-middle py-1">ID</th>
                                    <th class="col-4 align-middle py-1">Паттерн</th>
                                    <th class="col-4 align-middle py-1">Флоат</th>
                                    <th class="col-2 align-middle py-1 border-0"></th>
                                </tr>
                            </thead>
                            <tbody id="game_item_skins-table_body">
                                @foreach($gameItem->skins->take($skinsItemsPerPage) as $skinIndex => $skin)
                                <tr class="odd">
                                    <td class="col-1 align-middle py-1 skin_element-index">{{ $skinIndex + 1 }}</td>
                                    <td class="col-1 align-middle py-1 skin_element-id">{{ $skin->id }}</td>
                                    <td class="col-4 align-middle py-1 text-nowrap skin_element-pattern">{{ $skin->pattern }}</td>
                                    <td class="col-4 align-middle py-1 text-nowrap skin_element-float">{{ $skin->float }}</td>
                                    <td class="col-2 align-middle py-1 text-center skin_element-actions">
                                        <button class="btn btn-transparent btn-icon game_item_skins-button_edit" data-skin-id="{{ $skin->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-transparent btn-icon game_item_skins-button_delete" data-skin-id="{{ $skin->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <button class="btn btn-transparent btn-icon disabled d-none game_item_skins-button_save" data-skin-id="{{ $skin->id }}">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-transparent btn-icon disabled d-none game_item_skins-button_cancel" data-skin-id="{{ $skin->id }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row" id="game_item_skins-page_map">
                    <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info">Showing {{ $skinsStartItemNumber }} to {{ $skinsEndItemNumber }} of {{ $skinsTotalItems }} entries</div>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate paging_simple_numbers">
                            <ul class="pagination">
                                <li class="paginate_button page-item previous disabled">
                                    <button class="page-link" type="button" data-page-number="1">Previous</button>
                                </li>
                                @foreach(range(1, $skinsTotalPages) as $i)
                                <li class="paginate_button page-item @if($i == $skinsCurrentPage) active @endif">
                                    <button class="page-link" type="button" data-page-number="{{ $i }}">{{ $i }}</button>
                                </li>
                                @endforeach
                                <li class="paginate_button page-item next @if($skinsCurrentPage >= $skinsTotalPages) disabled @endif">
                                    <button class="page-link" type="button" data-page-number="2">Next</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @else
                <div class="row">
                    <div class="col-sm-12 col-md-12 text-center">
                        <div class="bg-light p-3 rounded p-3 border border-secondary">
                            <span class="text-muted text-lg">Нет добавленных скинов</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop