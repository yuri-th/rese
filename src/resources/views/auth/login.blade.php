@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="form__content">
  <div class="login__form">
    <form class="form" action="/login" method="post">
      @csrf
      <div class="form__group">
        <div class="form__group-title">
          <span class="form__label--item"><i class="fas fa-envelope icon"></i></span>
        </div>
        <div class="form__group-content">
          <div class="form__input--text">
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" />
          </div>
          <div class="form__error">
            @error('email')
            {{ $message }}
            @enderror
          </div>
        </div>
      </div>
      <div class="form__group">
        <div class="form__group-title">
          <span class="form__label--item"><i class="fas fa-lock icon"></i></span>
        </div>
        <div class="form__group-content">
          <div class="form__input--text">
            <input type="password" name="password" placeholder="Password" />
          </div>
          <div class="form__error">
            @error('password')
            {{ $message }}
            @enderror
          </div>
        </div>
      </div>
      <div class="form__button">
        <button class="form__button-submit" type="submit">ログイン</button>
      </div>
    </form>
  </div>
</div>
@endsection