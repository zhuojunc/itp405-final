@extends("layouts.main")

@section("title")
    {{$party->description}}
@endsection

@section("content")
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mb-3">
        <h4 class="mt-5">hosted by {{$user->name}}</h4>
        <div>
            <form method="post" action="{{ route('party.favorite', [ 'id' => $party->id ]) }}">
                @csrf
                <button type="submit" class="btn btn-primary">Favorite</button>
            </form>              
        </div>
        <hr>
        <ul class="mt-3">
            @foreach($restaurants as $restaurant)
                <li>
                    <a href="{{ route('comment.index', [ 'partyId' => $party->id, 'restaurantId' => $restaurant->id ]) }}">
                        {{$restaurant->name}}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection