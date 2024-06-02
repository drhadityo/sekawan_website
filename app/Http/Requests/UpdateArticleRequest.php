<?php

namespace App\Http\Requests;

use App\Models\Article;
use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $article = $this->route('article');
        $auth = $article->user_id == auth()->id() || auth()->user()->role;
        return $auth;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'         => "required|unique:articles,title,{$this->route('article')->id}|max:128",
            'img'           => 'nullable|image',
            'contents'      => 'required',
        ];
    }
}
