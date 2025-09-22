@extends('layout')

@section('content')
	<div class="ticket-create">
		<h2 class="title">Новая заявка</h2>

		<form method="POST" action="{{ route('tickets.store') }}">
			@csrf

			<input type="text" name="title" placeholder="Заголовок" required>

			<textarea name="description" placeholder="Описание" required></textarea>

			<select name="category" required>
				<option value="">-- Категория --</option>
				<option value="hardware">Железо</option>
				<option value="software">Софт</option>
			</select>

			<select name="priority" required>
				<option value="">-- Приоритет --</option>
				<option value="low">Низкий</option>
				<option value="medium">Средний</option>
				<option value="high">Высокий</option>
			</select>

			<button type="submit">Создать</button>
		</form>
	</div>
@endsection

