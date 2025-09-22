<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
	{
		$direction = $request->get('sort', 'desc');

		if (!in_array($direction, ['asc', 'desc'])) {
			$direction = 'desc';
		}

		$tickets = Ticket::where('created_by', Auth::id())
			->orderBy('created_at', $direction)
			->get();

		return view('tickets.index', compact('tickets', 'direction'));
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
