@extends('layouts.app')

@section('content')
<link href="{{ asset('css/card.css') }}" rel="stylesheet">
<div class="container">
{{--TU TREBA PRECHADZAT KARTICKY--}}
    @if(Session::has('cottage_message'))
        <div id="alert" class="alert alert-success" role="alert">
            {{Session::get('cottage_message')}}
        </div>
        <script>
            function alert() {
                var alert = document.getElementById("alert")
                alert.remove();
            }
            setTimeout("alert()",3000);
        </script>
    @endif
    @foreach($cottage as $ch)
<article class="card_background">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 center_img">
                <a href="">
                    @if($ch->image != '')
                    <img class="card-img-size" src="{{$ch->image}}">

                        @else
                        <img class="card-img-size" src="img_cottage/01.jpg">
                    @endif
                </a>
            </div>

            <div class="col-sm">
                <div class="col-sm offset-0 padr">
                    <div class="row">
                        <h2 class="col-sm-6">{{$ch->name}}</h2>
                        @can('update', [\App\Models\User::class, $ch->owner])
                        <div class="btn-group col-sm-6">
                                <a class="btn btn-block btn-success" href="{{route('cottage.edit',$ch->id)}}" title="Edit">Edit</a>
                                <a class="btn  btn-block btn-danger" href="{{route('cottage.delete',$ch->id)}}" title="Delete" data-method="DELETE">Delete</a>
                        </div>
                        @endcan
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <a>Lokalita: {{$ch->locality}}</a>
                        </div>
                        <div class="col-sm-6">
                            Pocet osob: {{$ch->num_ppl}}
                        </div>
                    </div>
                    <p>{{$ch->desc}}</p>

            </div>
                    <a type="button" href="{{route('cottage.show',[$ch->id])}}" class="btn btn-secondary btn-lg btn-block">Block level button</a>
        </div>
    </div>
    </div>
</article>
    @endforeach
{{--TU TREBA PRECHADZAT KARTICKY--}}
</div>
@endsection

