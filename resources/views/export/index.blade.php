@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            <span class="text-capitalize"></span>
            <small>Export<span class="text-lowercase"></span></small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}"></a>
            </li>
            <li><a href="" class="text-capitalize"></a></li>
            <li class="active"></li>
        </ol>
    </section>
@endsection

@section('content')
    <!-- Default box -->
    <div class="row">
        <!-- THE ACTUAL CONTENT -->
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div id="datatable_button_stack" class="pull-right text-right"></div>
                </div>
                <div class="box-body table-responsive">
                    <div style="margin: auto" style="color: red">
                        @if($errors->any())
                            <h4>{{$errors->first()}}</h4>
                        @endif
                    </div>
                    <form method="get" action="{{route('export.file')}}">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Users</label>
                            <select class="form-control" name="user_id" id="inputGroupSelect01" required>
                                <option selected value="">Choose User</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}} {{$user->last_name}}</option>
                                @endforeach
                            </select>
                        </div>

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

                        <button type="submit" class="btn btn-primary" style="margin-top: 20px">Export CSV</button>
                    </form>
                </div><!-- /.box-body -->


            </div><!-- /.box -->
        </div>

    </div>

@endsection

@section('after_styles')
    <!-- DATA TABLES -->
    <link href="{{ asset('vendor/adminlte/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/list.css') }}">

    <!-- CRUD LIST CONTENT - crud_list_styles stack -->
    @stack('crud_list_styles')
@endsection



