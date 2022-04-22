<!-- index.blade.php -->

@extends('layout')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="uper">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br/>
        @endif
        <table class="table table-striped">
            <thead>
            <tr>
                <td>Title</td>
                <td>Source</td>
                <td>Source Url</td>
                <td>Link</td>
                <td>Publish Date</td>
                <td>Description</td>
            </tr>
            </thead>
            <tbody>
            @foreach($feeds as $feed)
                <tr>
                    <td>{{$feed->title}}</td>
                    <td>{{$feed->source}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
@endsection
