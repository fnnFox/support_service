<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
	protected $fillable = [
		'title',
		'description',
		'category',
		'priority',
		'status',
		'created_by',
		'assigned_by',
	];

	public function getStatusTextAttribute(): string {
		return [
			'open' => 'Открыта',
			'in_progress' => 'В процессе',
			'closed' => 'Закрыта',
		][$this->status] ?? 'Неизвестно';
	}
	public function getPriorityTextAttribute(): string {
		return [
			'low' => 'Низкий',
			'medium' => 'Средний',
			'high' => 'Высокий',
		][$this->priority] ?? 'Неизвестно';
	}

	public function createdBy() {
		return $this->belongsTo(User::class, 'created_by');
	}
	public function assignedTo() {
		return $this->belongsTo(User::class, 'assigned_by');
	}
	public function messages() {
		return $this->hasMany(ChatMessage::class);
	}
}
