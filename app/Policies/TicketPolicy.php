<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
	use HandlesAuthorization;

	public function before(User $user, string $ability)
	{
		if ($user->role === 'admin') {
			return true;
		}
		return null;
	}

	/**
	 * Determine whether the user can view any models.
	 */
	public function viewAny(User $user): bool
	{
		return true;
	}

	/**
	 * Determine whether the user can view the model.
	 */
	public function view(User $user, Ticket $ticket): bool
	{
		if ($user->role === 'tech') {
			return true;
		}
		return $ticket->created_by === $user->id;
	}

	/**
	 * Determine whether the user can create models.
	 */
	public function create(User $user): bool
	{
		return $user->role === 'user';
	}

	/**
	 * Determine whether the user can update the model.
	 */
	public function update(User $user, Ticket $ticket): bool
	{
		if (in_array($user->role, ['tech', 'admin'])) {
			return true;
		}
		return $user->id === $ticket->created_by;
	}

	/**
	 * Determine whether the user can delete the model.
	 */
	public function delete(User $user, Ticket $ticket): bool
	{
		return $user->id === $ticket->created_by;
	}

	public function assign(User $user, Ticket $ticket): bool
	{
		return $user->role === 'tech' && is_null($ticket->assigned_to);
	}
}
