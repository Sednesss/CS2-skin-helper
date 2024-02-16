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
                        <input type="checkbox" class="custom-control-input" id="status" name="status">
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
                            <button class="btn btn-secondary" tabindex="0" type="button">
                                <i class="fas fa-plus"></i>
                                <span>Добавить</span>
                            </button>
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
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
                            <thead>
                                <tr>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">#</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Паттерн</th>
                                    <th class="sorting sorting_desc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" aria-sort="descending" style="">Флоат</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd">
                                    <td class="dtr-control" tabindex="0">123</td>
                                    <td class="">123</td>
                                    <td class="" style="">---</td>
                                </tr>
                                <tr class="odd">
                                    <td class="dtr-control" tabindex="0">123</td>
                                    <td class="">123</td>
                                    <td class="" style="">---</td>
                                </tr>
                                <tr class="odd">
                                    <td class="dtr-control" tabindex="0">123</td>
                                    <td class="">123</td>
                                    <td class="" style="">---</td>
                                </tr>
                                <tr class="odd">
                                    <td class="dtr-control" tabindex="0">123</td>
                                    <td class="">123</td>
                                    <td class="" style="">---</td>
                                </tr>
                                <tr class="odd">
                                    <td class="dtr-control" tabindex="0">123</td>
                                    <td class="">123</td>
                                    <td class="" style="">---</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                            <ul class="pagination">
                                <li class="paginate_button page-item previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
                                <li class="paginate_button page-item active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                                <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0" class="page-link">2</a></li>
                                <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0" class="page-link">3</a></li>
                                <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0" class="page-link">4</a></li>
                                <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0" class="page-link">5</a></li>
                                <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0" class="page-link">6</a></li>
                                <li class="paginate_button page-item next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop