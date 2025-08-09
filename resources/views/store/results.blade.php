@extends('layout')
@section('content')
    <h1>Store Results</h1>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Services</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($stores->isEmpty())
                            <tr>
                                <td colspan="2">Aucun magasin trouvé pour votre recherche</td>
                            </tr>
                        @endif

                        @foreach ($stores as $store)
                            <tr>
                                <td>{{ $store->name }}</td>
                                <td>{{ $store->address }}</td>
                                <td>
                                    <ul>
                                        @foreach ($store->services as $service)
                                            <li>{{ $service->name }}</li>
                                        @endforeach
                                    </ul>
                                <td>
                                    <a href="{{ route('store.show', $store->id) }}" class="btn btn-primary">Voir les détails</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
