<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model {
    protected $guarded = array('id');

    public static $rules = array(
      'title' => 'required',
      'body' => 'required'
    );

    public function histories() {

      // news(親)テーブルに関連づいている(子)historiesテーブルを全て取得するというメソッド
      return $this->hasMany('App\History');
    }
}
