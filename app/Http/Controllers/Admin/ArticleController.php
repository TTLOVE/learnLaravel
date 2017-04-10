<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;

class ArticleController extends Controller
{

    /**
     * 主页
     *
     * @return 
     */
    public function index()
    {
        return view('admin/article/index')->withArticles(Article::all());
    }

    /**
     * 插入新的文章
     *
     * @return 
     */
    public function create()
    {
        return view('admin/article/create');
    }

    /**
     * 保存数据方法
     *
     * @param $request
     *
     * @return 
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:articles|max:255',
            'body' => 'required',
        ]);

        $article = new Article;
        $article->title = $request->get('title');
        $article->body = $request->get('body');
        $article->user_id = $request->user()->id;

        if ($article->save()) {
            return redirect('admin/article');
        } else {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    /**
        * 显示详情
        *
        * @param $id 文章id
        *
        * @return 
     */
    public function edit($id)
    {
        $article = Article::find($id);
        return view('admin/article/edit')->withArticle($article);
    }

    /**
        * 更新文章
        *
        * @param $request
        *
        * @return 
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:articles,title,'.$id.'|max:255',
            'body' => 'required',
        ]);

        $article = Article::find($id);
        $article->title = $request->get('title');
        $article->body = $request->get('body');
        if ($article->save()) {
            return redirect('admin/article');
        } else {
            return redirect()->back()->withInput()->withErrors('修改失败！');
        }
    }

    /**
        * 删除文章
        *
        * @param $id 文章id
        *
        * @return 
     */
    public function destroy($id)
    {
        Article::find($id)->delete();
        return redirect()->back()->withInput()->withErrors('删除成功！');
    }
}
