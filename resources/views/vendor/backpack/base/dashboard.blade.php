<?php
$users_for_confirm = array();
foreach(App\Models\Club::with('users')->get() as $club){
    foreach($club->users as $user){
        if($user->pivot->confirm == 0) $users_for_confirm[] = array(
            "club" => $club,
            "user" => $user
        );
    }
}
if (Auth::check()) {
	Cart::restore(Auth::user()->id);
	Cart::store(Auth::user()->id);
}
?>

@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('backpack::base.dashboard') }}<small>{{ trans('backpack::base.first_page_you_see') }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('backpack::base.dashboard') }}</li>
      </ol>
    </section>
@endsection


@section('content')
    @if($users_for_confirm)
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Not confirmed members</div>
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Club</th>
                                <th>Status</th>
                                <th>Confirm</th>
                                <th>Cancel</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($users_for_confirm as $key => $club_user)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$club_user["user"]->last_name}} {{$club_user["user"]->name}}</td>
                                        <td>{{$club_user["club"]->title}}</td>
                                        <td><span class="label label-warning">Pending your confirmation</span></td>
                                        <td>
                                            <a href="/admin/confirm_user_to_club/{{$club_user["club"]->id}}/{{$club_user["user"]->id}}">
                                                <span class="label label-success">Confirm</span>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="/admin/cancel_user_to_club/{{$club_user["club"]->id}}/{{$club_user["user"]->id}}">
                                                <span class="label label-danger">Cancel</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">{{ trans('backpack::base.login_status') }}</div>
                </div>

                <div class="box-body">{{ trans('backpack::base.logged_in') }}</div>
            </div>
        </div>
    </div>
@endsection
