<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'answer_1',
        'answer_2',
        'answer_4',
        'answer_5',
        'answer_6',
        'answer_8',
        'answer_9',
        'answer_10',
        'answer_11',
        'answer_13',
        'answer_15',
        'answer_17',
        'answer_18',
        'answer_19',
        'answer_20',
        'answer_22',
        'answer_23',
        'height',
        'weight',
        'desired_weight',
        'user_id',
        'gender',
        'cid',
        'sid'
    ];
}
