@extends('account.account')
@section('content')
    @if(!Auth::user()->verified)
        <p style="color: red;">
            {{trans('account.confirm_email')}}
            <a style="color: red;text-decoration: underline;" href="{{ route('sendConfirmEmail') }}">
                {{trans('account.send')}}
            </a>
        </p>
    @endif
    <p>
        {{trans('account.welcome', ['name' => Auth::user()->name])}}
    </p>
    <div class="line m-t-30 m-b-20"></div>

    <div class="title_form"><strong>{{trans('account.my_clubs')}}</strong></div>
    <div class="clubs">
        <ul>
            @foreach($current_clubs as $club)
                <li style="{{$club->pivot->confirm?'':'color:red'}}">- {{$club->title}}</li>
            @endforeach
        </ul>
    </div>

    <br>

    <div class="title_form"><strong>{{trans('account.apple_to_club')}}</strong></div>
    <div class="clubs">
        <form action="{{route('apple_club')}}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <select name="club">
                @foreach($other_clubs as $club)
                    <option value="{{$club->id}}">{{$club->title}}</option>
                @endforeach
            </select>
            <input type="submit" value="Send">
        </form>
    </div>
@endsection