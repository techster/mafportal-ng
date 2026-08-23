@extends('account.account')
@section('content')
    <div class="Rating_table" >
        <form method="get" action="{{route('export.file')}}">
            <input type="hidden" value="{{\Illuminate\Support\Facades\Auth::user()->id}}" name="user_id">
            <div class="form-group col-md-6">
                <div class="col-md-6">
                    <label for="exampleInputPassword1">From Date</label>
                    <input type="date" class="form-control" name="from-date" placeholder="YYYY-MM-DD"
                           data-date="" data-date-format="YYYY MMMM DD" value="2020-01-01" required>
                </div>

                <div class="col-md-6">
                    <label for="exampleInputPassword1">End Date</label>
                    <input type="date" class="form-control" name="to-date" placeholder="YYYY-MM-DD"
                           data-date="" data-date-format="YYYY MMMM DD" value="2020-12-31" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top: 26px">Export CSV</button>
        </form>
        <div class="table_content">
            <table class="body" cellpadding="0" cellspacing="0" border="0">
                <tbody>
                    <tr>
                        <th>#</th>
                        <th><span>Game name</span></th>
                        <th><span>Club</span></th>
                        <th><span>Tournament</span></th>
                        <th><span>Role</span></th>
                        <th><span>Result</span></th>
                        <th><span>Best player</span></th>
                        <th><span>Best move 1</span></th>
                        <th><span>Best move 2</span></th>
                        <th><span>Prima nota</span></th>
                        <th><span>Mafia guessed</span></th>
                    </tr>
                    @foreach($gameRatings as $gameRating)
                        <tr class="animate_repeat">
                            <th>{{$loop->iteration}}</th>
                            <th>{{$gameRating->title}}</th>
                            <th>{{$gameRating->club != null ? $gameRating->club->title : ""}}</th>
                            <th>{{$gameRating->tournament != null ? $gameRating->tournament->title : ""}}</th>
                            <th>
                                @php
                                    foreach (json_decode($gameRating->results) as $item){
                                        if(isset($item->player) && $item->player == \Illuminate\Support\Facades\Auth::user()->id){
                                             if($item->role === "1"){

                                                 echo  'Citizen';
                                             }elseif ($item->role === "2"){
                                                 echo 'Sheriff';
                                             }elseif ($item->role === "3"){
                                                 echo  'Mafia';
                                             }elseif ($item->role === "4"){
                                                 echo  'Don';
                                             }else{
                                                 echo  '';
                                             }

                                        }
                                    }
                                @endphp
                            </th>
                            <th>
                                @if($gameRating->sentence == 2)
                                    Mafia
                                @elseif($gameRating->sentence == 1)
                                    Citizens
                                @endif
                            </th>
                            <th>{{$gameRating->bestPlayer != null ? $gameRating->bestPlayer->name . ' '. $gameRating->bestPlayer->last_name : ''}}</th>
                            <th>{{$gameRating->bestMove != null ? $gameRating->bestMove->name . ' '. $gameRating->bestMove->last_name : ''}}</th>
                            <th>{{$gameRating->bestMove2 != null ? $gameRating->bestMove2->name . ' '. $gameRating->bestMove2->last_name : ''}}</th>
                            <th>{{$gameRating->primaNota != null ? $gameRating->primaNota->name . ' '. $gameRating->primaNota->last_name : ''}}</th>
                            <th>{{$gameRating->select_prima}}</th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pull-right">
            {{ $gameRatings->links() }}
        </div>
    </div>
@endsection
