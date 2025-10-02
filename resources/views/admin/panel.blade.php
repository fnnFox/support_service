@extends('layout')

@section('content')
<div class="container">

    <h1 class="title">Админская панель</h1>

    {{-- Быстрые действия --}}
    <div class="actions">
        <a href="{{ route('admin.users.create') }}" class="btn-add">Добавить нового пользователя</a>
        <a href="{{ route('admin.users.index') }}" class="btn-list">Список пользователей</a>
        <a href="{{ route('tickets.index') }}" class="btn-tickets">Список тикетов</a>
    </div>

    <div class="grid">

        {{-- Блок: Пользователи --}}
        <div class="block">
            <h2 class="block-title">Пользователи</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ФИО</th>
                        <th>Email</th>
                        <th>Роль</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentUsers ?? [] as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->fullName }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('admin.users.index') }}" class="link">Все пользователи →</a>
        </div>

        {{-- Блок: Тикеты --}}
        <div class="block">
            <h2 class="block-title">Тикеты</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Статус</th>
                        <th>Создатель</th>
                        <th>Исполнитель</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTickets ?? [] as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->title }}</td>
                            <td>{{ $ticket->status }}</td>
                            <td>{{ $ticket->created_by_user->fullName ?? '-' }}</td>
                            <td>{{ $ticket->assigned_by_user->fullName ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('tickets.index') }}" class="link">Все тикеты →</a>
        </div>

    </div>
</div>
@endsection
