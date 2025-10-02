<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$users = User::all();
		return view('admin.users.index', compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return view('admin.users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$data = $request->validate([
			'name' => 'required|string|max:255',
			'surname' => 'required|string|max:255',
			'email' => 'required|email|unique:users,email',
			'password' => 'required|string|min:6',
			'role' => 'required|in:user,tech,admin',
		]);

		User::create($data);

		return redirect()->route('admin.users.index')->with('success', 'Пользователь успешно создан');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(User $user)
	{
		return view('admin.users.show', compact('user'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(User $user)
	{
		return view('admin.users.edit', compact('user'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, User $user)
	{
		$data = $request->validate([
			'name'     => 'required|string|max:255',
			'surname'  => 'required|string|max:255',
			'email'    => "required|email|unique:users,email,{$user->id}",
			'password' => 'nullable|string|min:6',
			'role'     => 'required|in:user,tech,admin',
		]);

		if (empty($data['password'])) {
			unset($data['password']);
		}

		$user->update($data);

		return redirect()->route('admin.users.index')
			->with('success', 'Пользователь успешно обновлён');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(User $user)
	{
		$user->delete();
		return redirect()->route('admin.users.index');
	}
}
