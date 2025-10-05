@extends('layout')

@section('content')
<div class="ticket-entry">
	<div class="ticket-header">
		<h2 class="title">{{ $ticket->title }}</h2>
		<div class="ticket-status {{ $ticket->status }}">
			{{ $ticket->status_text }}
		</div>
	</div>

	<div class="ticket-info">
		<p><strong>Описание:</strong> {{ $ticket->description }}</p>
		<p><strong>Категория:</strong> {{ $ticket->category_text }}</p>
		<p><strong>Приоритет:</strong> {{ $ticket->priority_text }}</p>
		<p><strong>Создал:</strong> {{ $ticket->createdBy->full_name ?? 'Неизвестно' }}</p>
		<p><strong>Ответственный:</strong> {{ $ticket->assignedTo->full_name ?? 'Не назначен' }}</p>

		<p><strong>Создано:</strong> {{ $ticket->created_at->format('d.m.Y H:i') }}</p>
	</div>

	{{-- Кнопка "Изменить" видна только техникам и администраторам --}}
	@if (auth()->check() && (auth()->user()->isUser() || auth()->user()->isAdmin()))
		<div class="ticket-actions">
			<a href="{{ route('tickets.edit', $ticket) }}" class="button button-edit">Изменить</a>
		</div>
	@endif

	{{-- Кнопка "Взять заявку" для техника --}}
	@if (auth()->check() && auth()->user()->isTech() && !$ticket->assigned_by)
		<form method="POST" action="{{ route('tickets.assign', $ticket) }}">
			@csrf
			@method('PUT')
			<button type="submit" class="button button-assign">Взять заявку</button>
		</form>
	@endif

	{{-- Кнопка "Закрыть заявку" для техника --}}
	@if (auth()->check() && auth()->user()->isTech() && $ticket->assigned_by === auth()->user()->id)
		<form method="POST" action="{{ route('tickets.close', $ticket) }}">
			@csrf
			@method('PUT')
			<button type="submit" class="button button-close" onclick="return confirm('Закрыть заявку?')">Закрыть заявку</button>
		</form>
	@endif

	{{-- Форма удаления (только для создателя и админа) --}}
	@if (auth()->user()->id === $ticket->created_by || auth()->user()->isAdmin())
		<form method="POST" action="{{ route('tickets.destroy', $ticket) }}">
			@csrf
			@method('DELETE')
			<button type="submit" class="button button-delete" onclick="return confirm('Вы уверены, что хотите удалить эту заявку?')">Удалить</button>
		</form>
	@endif

	<hr>
</div>
@endsection

