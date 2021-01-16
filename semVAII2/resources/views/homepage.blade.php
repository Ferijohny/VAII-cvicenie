@extends('layouts.app')

@section('content')
<link href="{{ asset('css/card.css') }}" rel="stylesheet">
<div class="container">
{{--TU TREBA PRECHADZAT KARTICKY--}}
    @foreach($cottage as $ch)
<article class="card_background">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 center_img">
                <a href="">
                    <img class="card-img-size" src="{{$ch->img_path}}">
                </a>
            </div>

            <div class="col-sm">
                <div class="col-sm offset-0 padr">
                    <div class="row">
                        <h2 class="col-sm-6">NAZOVCHATY</h2>
                        <div class="btn-group btn-group-toggle col-sm-6" data-toggle="buttons">
                            <label class="btn btn-secondary active">
                                <input type="radio" name="options" id="option1" autocomplete="off" checked> Active
                            </label>
                            <label class="btn btn-secondary active">
                                <input type="radio" name="options" id="option1" autocomplete="off" checked> Active
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <a>UMIESTNENIE</a>
                        </div>
                        <div class="col-sm-6">
                            POCET OSOB
                        </div>
                    </div>
                    <p>DESC</p>

            </div>
                <button type="button" class="btn btn-secondary btn-lg btn-block">Block level button</button>
        </div>
    </div>
    </div>
</article>
    @endforeach
{{--TU TREBA PRECHADZAT KARTICKY--}}
</div>
@endsection

