@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="thanks__content">
    <div class="thanks__card">
            <h1>会員登録ありがとうございます</h1>

            <div class="login__button">
                <button class="login__button--link"><a href="/login">ログインする</a>
                </button>
            </div>
       
    </div>
</div>
@endsection