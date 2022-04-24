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
                <td>Url</td>
                <td colspan="2">Action</td>
                <td><a href="{{ route('rss.create')}}" class="btn btn-primary">Add</a></td>
            </tr>
            </thead>
            <tbody>
            @foreach($rsses as $rss)
                <tr>
                    <td>{{$rss->url}}</td>
                    <td><a href="{{ route('rss.edit', $rss->id)}}" class="btn btn-primary">Edit</a></td>
                    <td>
                        <form action="{{ route('rss.destroy', $rss->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
@endsection
