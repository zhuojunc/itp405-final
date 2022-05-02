@extends('layouts.main')

@section('title', 'Profile')

@section('content')
    <p class="mb-5">Hello, {{ $user->name }}. Your email is {{ $user->email }}.</p>
    @if (count($parties) != 0)
        <div class="container mb-3">
            <h4>Favorite</h4>
            @foreach($parties as $party)
                <hr>
                <div class="row">
                    <div class="col-4">
                        {{$party->description}}
                    </div>
                    <div class="col-4">
                        {{-- <a href="{{ route('party.unfavorite', [ 'id' => $party->id ]) }}">
                            unfavorite
                        </a> --}}
                        <form method="post" action="{{ route('party.unfavorite', [ 'id' => $party->id ]) }}">
                            @csrf
                            <button type="submit" class="btn btn-link">Unfavorite</button>
                        </form>                                
                    </div>
                    <div class="col-4 text-end">
                        {{$party->pivot->created_at}}
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="mb-3">You do not have favorite party yet. <a href="{{ route('party.index') }}">Take a look now.</a></p>
    @endif
@endsection