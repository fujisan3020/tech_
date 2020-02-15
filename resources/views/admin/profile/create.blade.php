@extends('layouts.profile')

@section('title', 'Myプロフィール作成')

@section('content')
      <div class="container">
         <div class="row">
            <div class="col-md-8 mx-auto">
               <h2>Myプロフィール作成</h2>
               <form action="{{ action('Admin\ProfileController@create') }}" method="post">
                   @if (count($errors) > 0)
                     <ul>
                        @foreach ($errors->all() as $e)
                             <li>{{ $e }}</li>
                        @endforeach
                     </ul>
                   @endif
                   <div class="form-group row">
                      <label class="col-md-2" for="name">氏名</label>
                      <div class="col-md-10">
                         <input class="form-control" type="text"  name="name" value="{{ old('name') }}">
                      </div>
                   </div>
                   <div class="form-group row">
                      <label class="col-md-2" for="gender">性別</label>
                      <div class="col-md-10">
                        <input class="form-control" type="text" name="gender" value="{{ old('gender') }}">
                      </div>
                   </div>
                   <div class="form-group row">
                      <label class="col-md-2" for="hobby">趣味</label>
                      <div class="col-md-10">
                        <textarea class="form-control" name="hobby" rows="4">{{ old('hobby') }}</textarea>
                      </div>
                   </div>
                   <div class="form-group row">
                      <label class="col-md-2" for="introduction">自己紹介欄</label>
                      <div class="col-md-10">
                        <textarea class="form-control" name="introduction" rows="5">{{ old('introduction') }}</textarea>
                      </div>
                   </div>
                   {{ csrf_field() }}
                   <input class="btn btn-primary" type="submit" value="作成">
                   </div>
               </form>
            </div>
         </div>
      </div>
@endsection
