<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
	use HasFactory, Notifiable;

	protected $fillable = [
		'name',
		'surname',
		'email',
		'password',
		'role',
	];

	protected $hidden = [
		'password',
	];

	public function setPasswordAttribute($value) {
		$this->attributes['password'] = bcrypt($value);
	}

	public function getFullNameAttribute() {
		return $this->name . ' ' . $this->surname;
	}

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isTech(): bool
    {
        return $this->role === 'tech';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

	public function chatMessages() {
		return $this->hasMany(ChatMessage::class);
	}
	public function createdTickets(): HasMany {
		return $this->hasMany(Ticket::class, 'created_by');
	}
	public function assignedTickets(): HasMany {
		return $this->hasMany(Ticket::class, 'assigned_by');
	}
}
