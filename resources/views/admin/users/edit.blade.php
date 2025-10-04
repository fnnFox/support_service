@extends('layout')

@section('content')
<div class="user-edit">
	<h2 class="title">Редактировать пользователя</h2>

	<form method="POST" action="{{ route('admin.users.update', $user) }}">
		@csrf
		@method('PUT')

		<input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Имя" required>
		<input type="text" name="surname" value="{{ old('surname', $user->surname) }}" placeholder="Фамилия" required>
		<input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Email" required>

		<input type="password" name="password" placeholder="Новый пароль (опционально)">

		<button type="submit" class="btn-save">Сохранить</button>
	</form>

	<form method="POST" action="{{ route('admin.users.destroy', $user) }}">
		@csrf
		@method('DELETE')
		<button type="submit" onclick="return confirm('Удалить пользователя?')">Удалить</button>
	</form>
</div>
@endsection
