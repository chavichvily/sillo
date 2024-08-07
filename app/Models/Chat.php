<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    protected $fillable = [
		'question',
		'answer',
	];
    
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}
