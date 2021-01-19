@extends('layouts.app')

@section('content')
    <meta name="_token" content="{{ csrf_token() }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Users') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @can('create', \App\Models\User::class)
                        <div class="mb-3">
                            <a href="{{route('user.create')}}" class="btn btn-sm btn-success" role="button">Pridaj uzivatela</a>
                        </div>
                        @endcan
                            <div class="panel panel-default">
                            <div class="panel-heading">Search Customer Data</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Search Customer Data" />
                                </div>
                                <div class="table-responsive">
                                    <h3 align="center">Total Data : <span id="total_records"></span></h3>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>
                    </div>
                </div>


{{--                        {!!$grid->show()!!}--}}
                    </div>
                </div>
            </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({ headers: { 'csrf-token' : '{{ csrf_token() }}' } });
            fetch_user_data();

            function fetch_user_data(query = '')
            {

                $.ajax({
                    type:'GET',
                    url: 'user/action',

                    data:{query:query},
                    dataType:'json',
                    success:function(data)
                    {
                        $('tbody').html(data.table_data);
                        $('#total_records').text(data.total_data);
                    }
                });
            }

            $(document).on('keyup', '#search', function(){
                var query = $(this).val();
                fetch_user_data(query);
            });
        });
    </script>

@endsection



