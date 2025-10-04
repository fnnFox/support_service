@extends('layout')

@section('content')
<div class="ticket-create">
	<h2 class="title">Редактирование заявки #{{ $ticket->id }}</h2>

	<form method="POST" action="{{ route('tickets.update', $ticket) }}">
		@csrf
		@method('PUT')

		{{-- Заголовок --}}
		<div class="form-group">
			<label for="title"><strong>Заголовок:</strong></label>
			@if (auth()->user()->isAdmin() || auth()->user()->id === $ticket->created_by)
				<input type="text" id="title" name="title" value="{{ $ticket->title }}" required>
			@else
				<p>{{ $ticket->title }}</p>
				<input type="hidden" name="title" value="{{ $ticket->title }}">
			@endif
		</div>

		{{-- Описание --}}
		<div class="form-group">
			<label for="description"><strong>Описание:</strong></label>
			@if (auth()->user()->isAdmin() || auth()->user()->id === $ticket->created_by)
				<textarea id="description" name="description" required>{{ $ticket->description }}</textarea>
			@else
				<p>{{ $ticket->description }}</p>
				<input type="hidden" name="description" value="{{ $ticket->description }}">
			@endif
		</div>

		{{-- Категория --}}
		<div class="form-group">
			<label for="category"><strong>Категория:</strong></label>
			@if (auth()->user()->isAdmin() || auth()->user()->id === $ticket->created_by)
				<select id="category" name="category" required>
					<option value="hardware" {{ $ticket->category === 'hardware' ? 'selected' : '' }}>Железо</option>
					<option value="software" {{ $ticket->category === 'software' ? 'selected' : '' }}>Софт</option>
				</select>
			@else
				<p>{{ $ticket->category }}</p>
				<input type="hidden" name="category" value="{{ $ticket->category }}">
			@endif
		</div>

		{{-- Приоритет --}}
		<div class="form-group">
			<label for="priority"><strong>Приоритет:</strong></label>
			@if (auth()->user()->isAdmin() || auth()->user()->id === $ticket->created_by)
				<select id="priority" name="priority" required>
					<option value="low" {{ $ticket->priority === 'low' ? 'selected' : '' }}>Низкий</option>
					<option value="medium" {{ $ticket->priority === 'medium' ? 'selected' : '' }}>Средний</option>
					<option value="high" {{ $ticket->priority === 'high' ? 'selected' : '' }}>Высокий</option>
				</select>
			@else
				<p>{{ $ticket->priority }}</p>
				<input type="hidden" name="priority" value="{{ $ticket->priority }}">
			@endif
		</div>

		{{-- Статус --}}
		<div class="form-group">
			<label for="status"><strong>Статус:</strong></label>
			@if (auth()->user()->isAdmin())
				<select id="status" name="status" required>
					<option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Открыта</option>
					<option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>В работе</option>
					<option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Закрыта</option>
				</select>
			@else
				<p>{{ $ticket->status }}</p>
				<input type="hidden" name="status" value="{{ $ticket->status }}">
			@endif
		</div>

		{{-- Ответственный --}}
		<div class="form-group">
			<label for="assigned_to"><strong>Ответственный:</strong></label>
			@if (auth()->user()->isAdmin())
				<select id="assigned_to" name="assigned_to">
					<option value="">-- Назначить ответственного --</option>
					@foreach ($techs as $tech)
						<option value="{{ $tech->id }}" {{ $ticket->assigned_to === $tech->id ? 'selected' : '' }}>
							{{ $tech->full_name }}
						</option>
					@endforeach
				</select>
			@else
				<p>{{ $ticket->assignedTo->full_name ?? 'Не назначен' }}</p>
				<input type="hidden" name="assigned_to" value="{{ $ticket->assigned_to }}">
			@endif
		</div>

		{{-- Кнопка сохранить --}}
		<div class="form-actions">
			<button type="submit">Применить</button>
		</div>
	</form>
</div>
@endsection
