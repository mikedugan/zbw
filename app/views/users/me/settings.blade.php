@extends('layouts.master')
@section('title')
My Profile
@stop
@section('header')
@stop
@section('content')
	<h1 class="text-center">My Profile</h1>
    <div class="col-md-12">
    <p><b>Full Name:</b></p>$me['name']</p>
    <p><b>Controller ID:</b></p>$me['cid']</p>
    <p><b>Operating Initials:</b></p>$me['operating_id']
    <p><b>Email:</b></p><?php $me['email'] = Form::text('email', 'example@gmail.com');?>
    Form::checkbox('Subscribe', 'value', true);
@stop