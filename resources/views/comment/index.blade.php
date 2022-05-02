@extends("layouts.main")

@section("title")
    {{$party->description}} - {{$restaurant->name}}
@endsection

@section('content')
    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif

    @if (count($users) != 0)
        <div class="container mb-3">
            @foreach($users as $user)
                <hr>
                <div class="row mb-1">
                    <div class="col-9">
                        {{$user->name}}
                    </div>
                    <div class="col-3 text-end">
                        <small>{{$user->updated_at}}</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-10">{{$user->comment}}</div>
                    <div class="col-1">
                        @if (Gate::allows('edit-comment', $user->user_id))
                        <a href="{{ route('comment.edit', [ 'id' => $user->id ]) }}">
                            Edit
                        </a>
                        @endif                        
                    </div>
                    <div class="col-1">
                        @if (Gate::allows('edit-comment', $user->user_id))
                        <form method="post" action="{{ route('comment.delete', [ 'id' => $user->id ]) }}">
                            @csrf
                            <input type="hidden" name="partyRestaurant" id="partyRestaurant" class="form-control" value="{{ $partyRestaurant->id }}">
                            <button type="submit" class="btn btn-link">Delete</button>
                        </form>
                        @endif                         
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="mb-3">No comment yet.</p>
    @endif
    <div class="mb-3">
        <form method="post" action="{{ route('comment.store') }}">
            @csrf
            <div class="mb-3">
                <input type="text" name="comment" id="comment" class="form-control" value="{{ old('comment') }}">
                @error("comment")
                    <small class="text-danger">{{$message}}</small>
                @enderror
                <input type="hidden" name="partyRestaurant" id="partyRestaurant" class="form-control" value="{{ $partyRestaurant->id }}">
                <input type="hidden" name="party" id="party" class="form-control" value="{{ $party->id }}">
                <input type="hidden" name="restaurant" id="restaurant" class="form-control" value="{{ $restaurant->id }}">
            </div>       
            <button type="submit" class="btn btn-primary">Post Comment</button>
        </form>              
    </div>
@endsection