@extends("layouts.main")

@section("title", "New Party")

@section("content")
    <form action="{{ route('party.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" name="description" id="description" class="form-control" value="{{ old('description') }}">
            @error("description")
                <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label for="restaurant-1" class="form-label">Restaurant 1</label>
            <input type="text" name="restaurant-1" id="restaurant-1" class="form-control" value="{{ old('restaurant-1') }}">
            @error("restaurant-1")
                <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label for="restaurant-2" class="form-label">Restaurant 2</label>
            <input type="text" name="restaurant-2" id="restaurant-2" class="form-control" value="{{ old('restaurant-2') }}">
            @error("restaurant-2")
                <small class="text-danger">{{$message}}</small>
            @enderror
        </div>  
        <div class="mb-3">
            <label for="restaurant-3" class="form-label">Restaurant 3</label>
            <input type="text" name="restaurant-3" id="restaurant-3" class="form-control" value="{{ old('restaurant-3') }}">
            @error("restaurant-3")
                <small class="text-danger">{{$message}}</small>
            @enderror
        </div>      
        <button type="submit" class="btn btn-primary">
            Save
        </button>
    </form>
@endsection