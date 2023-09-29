@extends('layout')
@section('content')
    <form method="GET" action="{{ route('results') }}" class="form">
        <div class="bounds">
            <input type="search" name="n" placeholder="Latitude nord" />
            <input type="search" name="w" placeholder="Longitude ouest" />
            <input type="search" name="s" placeholder="Latitude sud" />
            <input type="search" name="e" placeholder="Longitude est" />
        </div>
        <div class="filters">
            <select multiple name="services">
                @foreach ($services as $service)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                @endforeach
            </select>
            <select name="operator">
                <option value="OR">OR</option>
                <option value="AND">AND</option>
            </select>
        </div>
        <div class="submit">
            <input type="submit" />
        </div>
    </form>
@endsection