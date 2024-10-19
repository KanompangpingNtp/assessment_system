<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'score',
        'name',
        'phone',
        'agency_id', // เพิ่มฟิลด์นี้เพื่อให้สามารถบันทึก agency_id ได้
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}
