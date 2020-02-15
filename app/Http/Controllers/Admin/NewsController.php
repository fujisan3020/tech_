<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// 以下を追記することでNews Modelが扱えるようになる
use App\News;
use App\History;
use Carbon\Carbon;

class NewsController extends Controller {
    public function add() {
      return view('admin.news.create');
    }

    // ニュースの作成
    // Requestクラスはユーザーから送られる情報を全て含んでいるオブジェクト を取得することができ、これらを$requestに代入して使用している。
    public function create(Request $request) {

      // Varidationを行う
      // validateメソッドは、の第１引数にリクエストのオブジェクトを渡し、$request->all()を判定して、問題があるなら、エラーメッセージと入力値とともに直前のページに戻る機能を持っている。第二引数は、カラムにどんなバリデーションをかけるかを指定することができる。
      $this->validate($request, News::$rules);
      // News = Newsテーブル? , $new = newレコード?
      $news = new News;
      // formで入力されたユーザー情報を全て取得、格納
      $form = $request->all();

      // フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
      if (isset($form['image'])) {
        // file('image'): 画像をアップロードするメソッド
        // sotre('public/image'): どこのフォルダにファイルを保存するか、パスを指定するメソッド
        // $pathの中には「public/image/ハッシュ化されたファイル名」が入っている
        $path = $request->file('image')->store('public/image');
        // newsテーブルのimage_pathには、ファイル名のみを保存させたい。
        // そこで、パスではなくファイル名だけ取得するメソッド、basenameを使用
        $news->image_path = basename($path);
      } else {
        $news->image_path = null;
      }

      // 「_token」と「image」は不要なので、
      // フォームから送信されてきた_tokenを削除する
      unset($form{'_token'});
      // フォームから送信されてきたimageを削除する
      unset($form{'image'});

      // データベースに保存する
      $news->fill($form);
      $news->save();

      return redirect('admin/news/create');
    }


    // 投稿したニュース一覧を表示
    public function index(Request $request) {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
        // 検索されたら検索結果を取得する
        // where()メソッド:第一引数で指定したtitleカラムで、
        // 第二引数で指定した$cond_title(ユーザが入力した文字)に一致する
        // レコードを全て取得する
        $posts = News::where('title', $cond_title)->get();
      } else {
        // それ以外はすべてのニュースを取得する
        $posts = News::all();
      }
      
      // index.blade.phpのファイルで取得したレコード($post)と、
      // ユーザーが入力した文字列($cond_title)を渡し、ページを開く
      return view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);
      }


      public function edit(Request $request) {
        //New Modelからデータを取得する
        $news = News::find($request->id);
        if (empty($news)) {
          abort(404);
        }
        return view('admin.news.edit', ['news_form' => $news]);
      }


      // 既存ニュースの編集
      public function update(Request $request) {
        $this->validate($request, News::$rules);
        $news = News::find($request->id);
        // 送信されてきたフォームデータを格納する
        $news_form = $request->all();
        if ($request->file('image')) {
            $path = $request->file('image')->store('public/image');
            $news_form['image_path'] = basename($path);
        } elseif($request->input('remove')) {
            $news->imege_path = null;
        } else {
            $news_form['image_path']  = $news->image_path;
        }

        unset($news_form['_token']);
        unset($news_form['image']);
        unset($news_form['remove']);
        $news->fill($news_form)->save();


        $history = new History;
        $history->news_id = $news->id;
        $history->edited_at = Carbon::now();
        $history->save();

        return redirect('admin/news/');
      }


      public function delete(Request $request) {
        $news = News::find($request->id);
        // 削除する
        $news->delete();
        return redirect('admin/news/');
      }
}
