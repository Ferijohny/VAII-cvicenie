@extends('layouts.app')

@section('content')
    <meta name="_token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/cottage.css') }}" rel="stylesheet">
    <link href="{{ asset('css/biggercard.css') }}" rel="stylesheet">
    <div class="container">

            <article class="card_background">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 center_img">
                            <a href="">
                                @if($cottage->image != '')
                                    <img class="card-img-size" src="../{{$cottage->image}}">

                                @else
                                    <img class="card-img-size" src="../img_cottage/01.jpg">
                                @endif
                            </a>
                        </div>

                        <div class="col-sm">
                            <div class="col-sm offset-0 padr">
                                <div class="row">
                                    <h2 class="col-sm-6">{{$cottage->name}}</h2>
                                    @can('update', [\App\Models\User::class, $cottage->owner])
                                        <div class="btn-group col-sm">
                                            <a class="btn btn-block btn-success" href="{{route('cottage.edit',$cottage->id)}}" title="Edit">Edit</a>
                                            <a class="btn  btn-block btn-danger" href="{{route('cottage.delete',$cottage->id)}}" title="Delete" data-method="DELETE">Delete</a>
                                        </div>
                                    @endcan
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <a>Lokalita: {{$cottage->locality}}</a>
                                    </div>
                                    <div class="col-sm-6">
                                        Pocet osob: {{$cottage->num_ppl}}
                                    </div>
                                </div>
                                <p>{{$cottage->desc}}</p>
                                    <div class="text-right">Kontakt:</div>
                                <div class="text-right">{{$cottage->owner}}</div>

                            </div>
                            <a type="button" class="btn btn-success btn-lg btn-block alignbottom" onclick='openform({{$cottage->id}})' data-dismiss="modal">Reserve</a>
{{--                            <a type="button" href="{{route('reserve',[$cottage->id,$cottage->owner])}}" class="btn btn-success btn-lg btn-block alignbottom">Reserve</a>--}}
                        </div>
                    </div>
                </div>
            </article>
    </div>

    <div class="container">
        <div class="modal fade" id="options">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-header">
                        @csrf
                        <form role="form" id="edit_form_product" method="post">
                            <div class="form-group">
                                <div class="form-check">
                                    <input id="television" class="form-check-input" type="checkbox" value="0">
                                    <label class="form-check-label" for="television">
                                        television
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input id="mower" class="form-check-input" type="checkbox" value="1">
                                    <label class="form-check-label" for="mower">
                                        mower
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input id="blankets" class="form-check-input" type="checkbox" value="0">
                                    <label class="form-check-label" for="blankets">
                                        blankets
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input id="microwave" class="form-check-input" type="checkbox" value="1">
                                    <label class="form-check-label" for="microwave">
                                        microwave
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-primary btn-block" type="submit" data-dismiss="modal" id="submit">submit</a>
{{--                        <a class="btn btn-primary btn-block" type="submit" id="submit">submit</a>--}}
                    </div>



                </div>
            </div>
        </div>
    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        function openform(id){
            $("#options").modal('toggle');
        $('#submit').on('click',function (){

            var television = document.getElementById("television").checked;
            var blankets = document.getElementById("blankets").checked;
            var mower = document.getElementById("mower").checked;
            var microwave = document.getElementById("microwave").checked;


            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

            $.ajax({

                url: id+'/add',
                type:'post',
                data:{television:television,
                    blankets:blankets,
                    mower:mower,
                    microwave:microwave},

                success:function(data)
                {
                    location.href="{{route('homepage')}}"
                    $('#options').modal('hide');
                },
                error:function ()
                {
                    alert('asa')
                }
            });
        });
        }
    </script>
@endsection



