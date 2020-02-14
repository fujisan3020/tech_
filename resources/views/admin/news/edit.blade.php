@extends('layouts.admin')

@section('title', 'ニュースの編集')

@section('content')
   <div class="row">
      <div class="col-md-8 mx-auto">
         <h2>ニュースの編集</h2>
         <form action="{{ action('Admin\NewsController@update') }}" method="post" enctype="multipart/form-data">
            @if(count($errors) > 0)
               <ul>
                  @foreach($errors->all() as $e)
                  <li>{{ $e }}</li>
                  @endforeach
               </ul>
            @endif
            <div class="form-group row">
               <label class="col-md-2" for="title">タイトル</label>
               <div class="col-md-10">
                  <input class="form-control" type="text" name="title" value="{{ $news_form->title }}">
               </div>
            </div>
            <div class="form-group row">
               <label class="col-md-2" for="title">本文</label>
               <div class="col-md-10">
                  <textarea class="form-control" type="text" name="body" rows="20">{{ $news_form->body }}</textarea>
               </div>
            </div>
            <div class="form-group row">
               <label class="col-md-2" for="title">画像</label>
               <div class="col-md-10">
                  <input class="form-control-file" type="file" name="image">
                  <div class="form-text text-info">
                     設定中: {{ $news_form->image_path }}
                  </div>
                  <div class="form-check">
                     <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="remove" value="true">画像を削除
                     </label>
                  </div>
               </div>
            </div>
            <div class="form-group row">
               <div class="col-md-10">
                  <input type="hidden" name="id" value="{{ $news_form->id }}">
                  {{ csrf_field() }}
                  <input class="btn btn-primary" type="submit" value="更新">
               </div>
            </div>
          </form>
       </div>
     </div>
@endsection
