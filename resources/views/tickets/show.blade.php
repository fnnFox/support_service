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
			<p><strong>Категория:</strong> {{ $ticket->category }}</p>
			<p><strong>Приоритет:</strong> {{ $ticket->priority }}</p>

			<p><strong>Создал:</strong> {{ $ticket->createdBy->full_name ?? 'Неизвестно' }}</p>
			<p><strong>Ответственный:</strong> {{ $ticket->assignedTo->full_name ?? 'Не назначен' }}</p>

			<p><strong>Создано:</strong> {{ $ticket->created_at->format('d.m.Y H:i') }}</p>
		</div>

		{{-- Кнопка "Изменить" видна только техникам и администраторам --}}
		@if (auth()->check() && (auth()->user()->isTech() || auth()->user()->isAdmin()))
			<div class="ticket-actions">
				<a href="{{ route('tickets.edit', $ticket) }}" class="button button-edit">Изменить</a>
			</div>
		@endif

		<hr>
	</div>
@endsection
