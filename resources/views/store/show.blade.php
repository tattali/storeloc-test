@extends('layout')
@section('content')
    <h1>Store Details</h1>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ $store->name }}</h2>
                <p><strong>Address:</strong> {{ $store->address }}</p>
                <p><strong>Services:</strong></p>
                <ul>
                    @foreach ($services as $service)
                        <li>{{ $service->name }}</li>
                    @endforeach
                </ul>

                <p>
                    {{ $isOpen ? 'Ouvert' : 'Fermé' }}
            </div>
        </div>
    </div>
@endsection
