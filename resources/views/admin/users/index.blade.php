@extends('layout')

@section('content')
<div class="users-index">
    <h2 class="title">Пользователи</h2>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Email</th>
                <th>Роль</th>
                <th>Создан</th>
                <th>Изменён</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->surname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                    <td>{{ $user->updated_at->format('d.m.Y H:i') }}</td>
                    <td>
                        {{-- Редактировать --}}
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn-edit">Изменить</a>

                        {{-- Удалить --}}
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Удалить пользователя?')">
                                Удалить
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('admin.users.create') }}" class="btn-add">Добавить пользователя</a>
</div>
@endsection
