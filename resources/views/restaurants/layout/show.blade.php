@extends('master.layout.index')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="mt-4">Restaurant detail</h1>
                <div class="card mt-5">
                    <h5 class="card-header">{{ $restaurant->name }}</h5>
                    <div class="card-body">
                        <p class="font-weight-bold">{{ $restaurant->description }}</p>
                        @if($restaurant->tag)
                            <p>Restaurant ID: {{ $restaurant->tag }}</p>
                        @endif
                        @if($restaurant->cuisine)
                            <p>Cuisine: {{ $restaurant->cuisine }}</p>
                        @endif
                        @if($restaurant->price)
                            <p>Price: {{ $restaurant->price }}</p>
                        @endif
                        @if($restaurant->rating)
                            <p>Rating: {{ $restaurant->rating }}</p>
                        @endif
                        @if($restaurant->location)
                            <p>Location: {{ $restaurant->location }}</p>
                        @endif
                        <h4 class="mt-5">Opening hours:</h4>
                        <table class="table mt-4 col-sm-3">
                            <thead>
                            <tr>
                                <th scope="col">Day</th>
                                <th scope="col">Opens</th>
                                <th scope="col">Closes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($restaurant->openingHours as $item)
                                <tr>
                                    <td>{{ \App\Utils::getDayNameByNumber($item->day) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->open_time)->format('H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->close_time)->format('H:i') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
