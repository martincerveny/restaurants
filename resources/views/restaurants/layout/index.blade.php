@extends('master.layout.index')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="mt-4">{{ request()->has('search') ? 'Search' : 'Open restaurants' }}</h1>
                <form action="" method="get">
                    <div class="form-group col-sm-3 float-right">
                        <input type="text" class="form-control" id="search" placeholder="Search" name="search">
                    </div>
                </form>
                @if(request()->has('search'))
                    <div class="mt-4">{{ count($restaurants) }} results for {{ request('search') }}</div>
                @endif
                <table class="table mt-2">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Cuisine</th>
                        <th scope="col">Location</th>
                        <th scope="col">Price</th>
                        <th scope="col">Rating</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($restaurants as $restaurant)
                        <tr>
                            <td><a href="{{ route('restaurant.show', $restaurant) }}">{{ $restaurant->name }}</a></td>
                            <td>{{ $restaurant->cuisine }}</td>
                            <td>{{ $restaurant->location }}</td>
                            <td>{{ $restaurant->price }}</td>
                            <td>{{ $restaurant->rating }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
