@extends('adminlte::page')

@section('title', 'AdminPanel')

@section('content_header')
<h1 class="m-0 text-dark">Игровые предметы</h1>
@stop

@section('content')
<div class="row">
    <div class="card col-md-9">
        <div class="card-header">
            <h3 class="card-title">Список игровых предметов</h3>
        </div>

        <div class="card-body">
            <div class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-hover dataTable dtr-inline">
                            <thead>
                                <tr>
                                    <th class="col-1">№</th>
                                    <th class="col-1">ID</th>
                                    <th class="col-7">Название</th>
                                    <th class="col-3">Количество скинов</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($gameItems as $gameItemIndex => $gameItem)
                                <tr class="odd">
                                    <td class="col-1">{{ $startItemNumber + $gameItemIndex }}</td>
                                    <td class="col-1">{{ $gameItem->id }}</td>
                                    <td class="col-7">
                                        <a href="{{ route('admin_panel::game_items::show', $gameItem->id) }}">{{ $gameItem->title }}</a>
                                    </td>
                                    <td class="col-3">{{ $gameItem->skins_count }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info">Showing {{ $startItemNumber }} to {{ $endItemNumber }} of {{ $totalItems }} entries</div>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate paging_simple_numbers">
                            <ul class="pagination">
                                <li class="paginate_button page-item previous @if($currentPage == 1) disabled @endif">
                                    <a href="{{route('admin_panel::game_items::index', ['page' => $currentPage - 1]) }}" tabindex="0" class="page-link">Previous</a>
                                </li>
                                @foreach(range(1, $totalPages) as $i)
                                <li class="paginate_button page-item @if($i == $currentPage) active @endif">
                                    <a href="{{route('admin_panel::game_items::index', ['page' => $i]) }}" tabindex="0" class="page-link">{{ $i }}</a>
                                </li>
                                @endforeach
                                <li class="paginate_button page-item next @if($currentPage >= $totalPages) disabled @endif">
                                    <a href="{{route('admin_panel::game_items::index', ['page' => $currentPage + 1]) }}" tabindex="0" class="page-link">Next</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3 pt-0">
            <div class="col">
                <div class="card-header mb-3">
                    <h3 class="card-title">Действия</h3>
                </div>
                <button type="button" class="btn btn-block btn-secondary">Добавить</button>
                <button type="button" class="btn btn-block btn-secondary">Отменить выделение</button>
                <button type="button" class="btn btn-block btn-secondary">Удалить выделенные</button>
            </div>
        </div>
    </div>
</div>
@stop