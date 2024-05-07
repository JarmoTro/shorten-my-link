@extends('layouts.main')

@section('content')

<div class="card-container">

    <form class="form-login-register">

        <label for="email">Email</label>

        <input type="email" name="email" id="email" placeholder="Your email">

        <label for="password">Password</label>

        <input type="password" name="password" id="password" placeholder="Your password">

        <div class="login-register-buttons">

            <input class="form-submit" id="btn-login" type="submit" value="LOGIN">

            <input class="form-submit" id="btn-register" type="submit" value="REGISTER">

        </div>

    </form>

</div>

@endsection