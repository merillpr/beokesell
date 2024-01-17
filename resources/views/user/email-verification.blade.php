@extends('layouts.email-layout')

@section('content')
<div style="color:#595959; font-family:sans-serif; line-height:170%;">
  <h1 style="text-align:center;margin-bottom:50px;">Kode Verifikasi Email Anda</h1>
  <p style="font-size:18px">Hello, {{ $user->name }}</p>
  <p style="font-size:18px">Anda baru saja melakukan registrasi ke akun Okesell. Untuk memastikan alamat email Anda resmi, segera gunakan kode di bawah ini untuk memverifikasi email Anda.</p>
  <p style="font-size:28px; font-weight: bold; text-align: center;">{{ $code }}</p> 
  <p style="font-size:12px">"Kode tersebut akan berlaku selama 24 jam!</p>
</div>
@endsection