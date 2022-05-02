@extends("layouts.main")

@section("title", "Parties")

@section("content")
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (Auth::check())
        <div class="mb-3 text-end">
            <a href="{{ route('party.create') }}">New Party</a>
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Party</th>
                <th colspan="2">Host</th>
            </tr>
        </thead>
        <tbody>
            @foreach($parties as $party)
                <tr>
                    <td>
                        {{$party->description}}
                    </td>
                    <td>
                        {{$party->name}}
                    </td>
                    <td>
                        <a href="{{ route('party.show', [ 'id' => $party->id ]) }}">
                            Restaurant Selections
                        </a>                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection