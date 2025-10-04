@extends('layout')

@section('content')
    <div class="user-create">
		<h2 class="title">Новый пользователь</h2>

		<form method="POST" action="{{ route('admin.users.store') }}">
			@csrf

			<input type="text" name="name" placeholder="Name" required>
			<input type="text" name="surname" placeholder="Surname" required>
			<input type="text" name="email" placeholder="Email" required>
			<input type="text" name="password" placeholder="Password" required>

			<select name="role" required>
				<option value="user">User</option>
				<option value="tech">Tech</option>
				<option value="admin">Admin</option>
			</select>
			<button type="submit">Создать</button>
		</form>
	</div>
@endsection

