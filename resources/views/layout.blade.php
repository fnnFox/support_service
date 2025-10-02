<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<title>Поддержка</title>
		<link rel="stylesheet" href="{{ asset('css/base.css') }}">
		<link rel="stylesheet" href="{{ asset('css/layout.css') }}">
		<link rel="stylesheet" href="{{ asset('css/ticket-list.css') }}">
		<link rel="stylesheet" href="{{ asset('css/ticket-entry.css') }}">
		<link rel="stylesheet" href="{{ asset('css/ticket-add.css') }}">
		<link rel="stylesheet" href="{{ asset('css/login.css') }}">
	</head>
	<body>
		<header>
			<div class="logo">
				<a href="/">
					<h1>Служба поддержки</h1>
				</a>
			</div>

			<div class="user-info">
				@auth
				<span>{{ auth()->user()->role }}{{ auth()->user()->id }}</span>
				@if (auth()->user()->isUser())
				<a href="{{ route('tickets.create') }}" class="btn new-ticket">Новая заявка</a>
				@endif
				<span class="name">{{ auth()->user()->name }} {{ auth()->user()->surname }}</span>
				<form method="POST" action="{{ route('logout') }}">
					@csrf
					<button class="btn logout" type="submit">Выйти</button>
				</form>
				@endauth
			</div>
		</header>
		<main>
			@yield('content')
		</main>
	</body>
</html>

