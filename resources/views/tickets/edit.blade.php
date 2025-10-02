@extends('layout')

@section('content')
    <div class="ticket-create">
        <h2 class="title">Редактирование заявки #{{ $ticket->id }}</h2>

        <form method="POST" action="{{ route('tickets.update', $ticket) }}">
            @csrf
            @method('PUT')

            {{-- Название и описание могут редактировать только создатель заявки и админ --}}
            @if (auth()->user()->id === $ticket->created_by || auth()->user()->isAdmin())
                <input type="text" name="title" placeholder="Заголовок" value="{{ $ticket->title }}" required>
                <textarea name="description" placeholder="Описание" required>{{ $ticket->description }}</textarea>
            @else
                {{-- Если пользователь не создатель и не админ, то поля отображаются как текст --}}
                <p><strong>Заголовок:</strong> {{ $ticket->title }}</p>
                <p><strong>Описание:</strong> {{ $ticket->description }}</p>
                <input type="hidden" name="title" value="{{ $ticket->title }}">
                <input type="hidden" name="description" value="{{ $ticket->description }}">
            @endif

            <select name="category" required>
                <option value="">-- Категория --</option>
                <option value="hardware" {{ $ticket->category === 'hardware' ? 'selected' : '' }}>Железо</option>
                <option value="software" {{ $ticket->category === 'software' ? 'selected' : '' }}>Софт</option>
            </select>

            <select name="status" required>
                <option value="">-- Статус --</option>
                <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Открыта</option>
                <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>В работе</option>
                <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Закрыта</option>
            </select>

            <select name="priority" required>
                <option value="">-- Приоритет --</option>
                <option value="low" {{ $ticket->priority === 'low' ? 'selected' : '' }}>Низкий</option>
                <option value="medium" {{ $ticket->priority === 'medium' ? 'selected' : '' }}>Средний</option>
                <option value="high" {{ $ticket->priority === 'high' ? 'selected' : '' }}>Высокий</option>
            </select>

            {{-- Назначение техника (только для админа) --}}
            @if (auth()->user()->isAdmin())
                <select name="assigned_by">
                    <option value="">-- Назначить техника --</option>
                    @foreach ($techs as $tech)
                        <option value="{{ $tech->id }}" {{ $ticket->assigned_to === $tech->id ? 'selected' : '' }}>
                            {{ $tech->full_name }}
                        </option>
                    @endforeach
                </select>
            @endif

            <button type="submit">Обновить</button>
        </form>

        {{-- Кнопка самоназначения (только для техников) --}}
        @if (auth()->user()->isTech() && !$ticket->assigned_to)
            <form method="POST" action="{{ route('tickets.assign', $ticket) }}">
                @csrf
                @method('PUT')
                <button type="submit">Назначить себя</button>
            </form>
        @endif

        {{-- Форма удаления (только для создателя и админа) --}}
        @if (auth()->user()->id === $ticket->created_by || auth()->user()->isAdmin())
            <form method="POST" action="{{ route('tickets.destroy', $ticket) }}">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Вы уверены, что хотите удалить эту заявку?')">Удалить</button>
            </form>
        @endif
    </div>
@endsection
