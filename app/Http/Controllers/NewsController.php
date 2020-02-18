<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\HTML;

use App\News;

class NewsController extends Controller {
    public function index(Request $request) {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
        $posts = News::where('title', $cond_title).orderBy('updated_at, desc')->get();
      } else {
        //sortBydesc()メソッド: キー()の値で降順に並べる
        $posts = News::all()->sortBydesc('updated_at');
      }

      if (count($posts) > 0) {
        // shift()メソッド: 配列の最初のデータを削除し、その値を返す
        // この場合、一番最新の記事が格納される
        $headline = $posts->shift();
      } else {
        $headline = null;
      }

      return view('news.index', ['headline' => $headline, 'posts' => $posts, 'cond_title' => $cond_title]);
    }
}
