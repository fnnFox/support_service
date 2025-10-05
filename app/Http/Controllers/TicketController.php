<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\User;

class TicketController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$user = Auth::user();

		// Получаем параметры из запроса. По умолчанию - сортировка по дате по убыванию, без закрытых заявок.
		$sortBy = $request->get('sortBy', 'created_at');
		$direction = $request->get('direction', 'desc');
		$showClosed = $request->boolean('closed'); // Проверяем наличие параметра 'closed'

		// Проверяем, что параметры сортировки корректны
		if (!in_array($sortBy, ['created_at', 'priority']))
		{
			$sortBy = 'created_at';
		}
		if (!in_array($direction, ['asc', 'desc']))
		{
			$direction = 'desc';
		}

		// Получаем все заявки, если пользователь - техник или админ, иначе - только его
		$query = ($user->isTech() || $user->isAdmin()) ? Ticket::query() : $user->createdTickets();

		// Если параметр 'closed' не указан, добавляем фильтр по статусу
		if (!$showClosed)
		{
			$query->where('status', '!=', 'closed');
		}

		// Применяем сортировку
		$query->orderBy($sortBy, $direction);

		// Добавляем дополнительную сортировку по дате, если основная сортировка не по ней
		if ($sortBy !== 'created_at')
		{
			$query->orderBy('created_at', 'desc');
		}

		$tickets = $query->get();

		// Передаем данные в представление
		return view('tickets.index', compact('tickets', 'sortBy', 'direction', 'showClosed'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return view('tickets.create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$data = $request->validate([
			'title' => 'required|string',
			'description' => 'required|string',
			'category' => 'required|string',
			'priority' => 'required|string',
		]);
		$data['created_by'] = auth()->id();
		Ticket::create($data);
		return redirect()->route('tickets.index')->with('success','Заявка создана');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Ticket $ticket)
	{
		return view('tickets.show', compact('ticket'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Ticket $ticket)
	{
		// Проверка прав: пользователь должен быть техником ИЛИ администратором ИЛИ создателем заявки.
		$user = Auth::user();
		if (!($user->isTech() || $user->isAdmin() || $user->id === $ticket->created_by)) {
			abort(403, 'У вас нет прав для редактирования заявок.');
		}

		$techs = User::where('role', 'tech')->get();

		return view('tickets.edit', compact('ticket', 'techs'));
	}

	public function update(Request $request, Ticket $ticket)
	{
		// Проверка прав: пользователь должен быть техником ИЛИ администратором ИЛИ создателем заявки.
		$user = Auth::user();
		if (!($user->isTech() || $user->isAdmin() || $user->id === $ticket->created_by)) {
			abort(403, 'У вас нет прав для обновления заявок.');
		}

		$validated = $request->validate([
			'title'			=> 'required|string|max:255',
			'description'	=> 'required|string',
			'status'		=> 'required|in:open,in_progress,closed',
			'priority'		=> 'required|in:low,medium,high',
			'assigned_by'	=> 'nullable|exists:users,id',
		]);

		$ticket->update($validated);

		return redirect()->route('tickets.show', $ticket)
						 ->with('success', 'Заявка успешно обновлена!');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		//
	}
	public function assign(Ticket $ticket)
	{
		$this->authorize('assign', $ticket);
		$user = auth()->user();
		if ($user->isTech() && is_null($ticket->assigned_by)) {
			$ticket->update(['assigned_by' => $user->id]);
			$ticket->update(['status' => 'in_progress']);
			return redirect()->route('tickets.show', $ticket)
							 ->with('success', 'Вы успешно назначили себя на эту заявку.');
		}
		return redirect()->back()->with('error', 'Не удалось назначить.');
	}

	public function close(Ticket $ticket)
	{
		$user = auth()->user();

		if (!$user->isTech() || $ticket->assigned_by !== $user->id) {
			abort(403);
		}

		$ticket->update(['status' => 'closed']);

		return redirect()->route('tickets.show', $ticket)
						 ->with('success', 'Заявка закрыта.');
	}

	public function __construct()
	{
		$this->authorizeResource(\App\Models\Ticket::class, 'ticket');
	}
}
