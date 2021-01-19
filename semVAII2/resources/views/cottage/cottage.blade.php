@extends('layouts.app')

@section('content')
    <link href="{{ asset('css/cottage.css') }}" rel="stylesheet">
    <link href="{{ asset('css/biggercard.css') }}" rel="stylesheet">
    <div class="container">
{{--        --}}{{--TU TREBA PRECHADZAT KARTICKY--}}
{{--        @if(Session::has('cottage_message'))--}}
{{--            <div id="alert" class="alert alert-success" role="alert">--}}
{{--                {{Session::get('cottage_message')}}--}}
{{--            </div>--}}
{{--            <script>--}}
{{--                function alert() {--}}
{{--                    var alert = document.getElementById("alert")--}}
{{--                    alert.remove();--}}
{{--                }--}}
{{--                setTimeout("alert()",3000);--}}
{{--            </script>--}}
{{--        @endif--}}

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
                            <a type="button" href="{{route('reserve',[$cottage->id,$cottage->owner])}}" class="btn btn-success btn-lg btn-block alignbottom">Reserve</a>
                        </div>
                    </div>
                </div>
            </article>
        {{--TU TREBA PRECHADZAT KARTICKY--}}
    </div>
@endsection
