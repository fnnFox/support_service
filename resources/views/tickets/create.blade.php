@extends('layout')

@section('content')
	<div class="ticket-create">
		<h2 class="title">Новая заявка</h2>

		<form method="POST" action="{{ route('tickets.store') }}">
			@csrf

			{{-- Заголовок --}}
			<div class="form-group">
				<label for="title"><strong>Заголовок:</strong></label>
				<input type="text" id="title" name="title" placeholder="Введите заголовок" required>
			</div>

			{{-- Описание --}}
			<div class="form-group">
				<label for="description"><strong>Описание:</strong></label>
				<textarea id="description" name="description" placeholder="Опишите проблему" required></textarea>
			</div>

			{{-- Категория --}}
			<div class="form-group">
				<label for="category"><strong>Категория:</strong></label>
				<select id="category" name="category" required>
					<option value="">-- Выберите категорию --</option>
					<option value="hardware">Оборудование</option>
					<option value="software">Программное обеспечение</option>
					<option value="network">Сетевые системы</option>
					<option value="other">Другое</option>
				</select>
			</div>

			{{-- Приоритет --}}
			<div class="form-group">
				<label for="priority"><strong>Приоритет:</strong></label>
				<select id="priority" name="priority" required>
					<option value="">-- Выберите приоритет --</option>
					<option value="low">Низкий</option>
					<option value="medium">Средний</option>
					<option value="high">Высокий</option>
				</select>
			</div>

			{{-- Кнопка --}}
			<div class="form-actions">
				<button type="submit">Создать</button>
			</div>
		</form>
	</div>
@endsection

