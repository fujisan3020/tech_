<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// 以下を追記することでNews Modelが扱えるようになる
use App\News;

class NewsController extends Controller {
    public function add() {
      return view('admin.news.create');
    }

    // Requestクラスはユーザーから送られる情報を全て含んでいるオブジェクト を取得することができ、これらを$requestに代入して使用している。
    public function create(Request $request) {

      // Varidationを行う
      // validateメソッドは、の第１引数にリクエストのオブジェクトを渡し、$request->all()を判定して、問題があるなら、エラーメッセージと入力値とともに直前のページに戻る機能を持っている。第二引数は、カラムにどんなバリデーションをかけるかを指定することができる。
      $this->validate($request, News::$rules);
      // News = Newsテーブル?
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
}
