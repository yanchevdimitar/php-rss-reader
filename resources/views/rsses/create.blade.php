<!-- create.blade.php -->

@extends('layout')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Add RSS Data
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br/>
            @endif
            <form method="post" action="{{ route('rss.store') }}">
                <div class="form-group">
                    @csrf
                    <label for="rss_url">Url:
                        <input type="text" class="form-control" name="url"/>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Add RSS</button>
            </form>
        </div>
    </div>
@endsection
