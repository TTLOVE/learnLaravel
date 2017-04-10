<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Article;

class ArticleController extends Controller
{
    /**
        * 显示列表
        *
        * @param $id 对应一个
        *
        * @return 
     */
    public function show($id)
    {
        return view('article/show')->withArticle(Article::with('hasManyComments')->find($id));
    }
}
