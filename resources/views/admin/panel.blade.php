@extends('layout')

@section('content')
<div class="container">

	<h2 class="title">Админская панель</h2>

	<div class="actions">
		<a href="{{ route('admin.users.create') }}" class="btn-add">Добавить нового пользователя</a>
		<a href="{{ route('admin.users.index') }}" class="btn-list">Список пользователей</a>
		<a href="{{ route('tickets.index') }}" class="btn-tickets">Список заявок</a>
	</div>
</div>
@endsection
