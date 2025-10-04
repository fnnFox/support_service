@extends('layout')

@section('content')
	<div class="header-container">
		<h2 class="page-title">
			@if (auth()->user()->isUser())
			Мои заявки
			@else
			Все заявки
			@endif
		</h2>
		<div class="controls-container">
			<div class="sort-options">
				<span>Сортировать:</span>
				<a href="{{ route('tickets.index', array_merge(request()->query(), ['sortBy' => 'created_at'])) }}"
				   class="{{ $sortBy === 'created_at' ? 'active' : '' }}">По дате</a>
				<span>|</span>
				<a href="{{ route('tickets.index', array_merge(request()->query(), ['sortBy' => 'priority'])) }}"
				   class="{{ $sortBy === 'priority' ? 'active' : '' }}">По приоритету</a>

				<div class="direction-options">
					<a href="{{ route('tickets.index', array_merge(request()->query(), ['direction' => 'asc'])) }}"
					   class="{{ $direction === 'asc' ? 'active' : '' }}">▲</a>
					<a href="{{ route('tickets.index', array_merge(request()->query(), ['direction' => 'desc'])) }}"
					   class="{{ $direction === 'desc' ? 'active' : '' }}">▼</a>
				</div>
			</div>
			<div class="status-filter">
				<input type="checkbox" id="show-closed"
					   onchange="window.location.href = this.checked ? '{{ route('tickets.index', array_merge(request()->query(), ['closed' => '1'])) }}' : '{{ route('tickets.index', array_merge(request()->query(), ['closed' => null])) }}'"
					   {{ $showClosed ? 'checked' : '' }}>
				<label for="show-closed">Показывать закрытые заявки</label>
			</div>
		</div>
	</div>

	<div class="ticket-list">
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
