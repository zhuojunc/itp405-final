@extends("layouts.main")

@section("title")
    {{$party->description}} - {{$restaurant->name}}
@endsection

@section('content')
    <form method="post" action="{{ route('comment.update', [ 'id' => $partyRestaurantUser->id ]) }}">
        @csrf
        <div class="mb-3">
            <input type="text" name="comment" id="comment" class="form-control" value="{{ old('comment', $partyRestaurantUser->comment) }}">
            @error("comment")
                <small class="text-danger">{{$message}}</small>
            @enderror
            <input type="hidden" name="partyRestaurant" id="partyRestaurant" class="form-control" value="{{ $partyRestaurant->id }}">
        </div>       
        <button type="submit" class="btn btn-primary">Edit Comment</button>
    </form>
@endsection