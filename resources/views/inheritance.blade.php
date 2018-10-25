@extends('layouts.base')

@section('head')
    @parent <!-- herda o conteúdo da template ancestral -->
    <link rel="stylesheet" href="another.css" />
@stop

@section('body')
    <h1>Hurray!</h1>
    <p>We have a template!</p>
@stop