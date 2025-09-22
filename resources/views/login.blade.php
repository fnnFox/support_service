@extends('layout')

@section('content')
	<div class="login-container">
		<h2>Вход</h2>

		@if ($errors->any())
			<div class="error">
				{{ $errors->first() }}
			</div>
		@endif

		<form method="POST" action="/login">
			@csrf

			<label for="email">Email</label>
			<input type="email" name="email" id="email" required value="{{ old('email') }}">

			<label for="password">Пароль</label>
			<input type="password" name="password" id="password" required>

			<button type="submit">Войти</button>
		</form>
	</div>
@endsection
