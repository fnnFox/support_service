@extends('layout')

@section('content')
	<div class="ticket-list">
		<div class="title">
			<h2 class="title-text">Мои заявки</h2>
			<div class="sort-options">
				<span>Сортировать по дате:</span>
				<a href="{{ route('tickets.index', ['sort' => 'asc']) }}" class="{{ $direction === 'asc' ? 'active' : '' }}">По возрастанию</a>
				<span>|</span>
				<a href="{{ route('tickets.index', ['sort' => 'desc']) }}" class="{{ $direction === 'desc' ? 'active' : '' }}">По убыванию</a>
			</div>
		</div>

		@if ($tickets->isEmpty())
			<p>Заявок нет.</p>
		@else
			@foreach ($tickets as $ticket)
				<a href="{{ route('tickets.show', $ticket) }}" class="ticket-link">
					<div class="ticket">
						<div class="ticket-info">
							<h2 class="ticket-title">{{ $ticket->title }}</h2>
							<p class="ticket-desc">{{ $ticket->description }}</p>
						</div>
						<div class="ticket-status {{ $ticket->status }}">{{ $ticket->status_text }}</div>
					</div>
				</a>
			@endforeach
		@endif
	</div>
@endsection
