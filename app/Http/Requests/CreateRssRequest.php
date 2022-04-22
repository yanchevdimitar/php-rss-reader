<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Rss;

class CreateRssRequest extends FormRequest
{
    public function rules(): array
    {
        return Rss::$rules;
    }
}
