@extends('layouts.app')

@section('judul', 'Pilih Kursi')

@section('content')
<div class="container">
    <!-- Display the movie title and theater name -->
    <h1>{{ $showtime->movies->judul }} - {{ $showtime->theaters->nama }}</h1>
    
    <!-- Form to reserve seats -->
    <form method="POST" action="{{ route('seats.store') }}">
        @csrf
        <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
        <div class="available-seats">
            @foreach ($availableSeats as $seat)
                <label>
                    <input type="checkbox" name="seats_id[]" value="{{ $seat->id }}">
                    {{ $seat->seat_number }}
                </label>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Reserve Seats</button>
    </form>

    <!-- Display error message if any -->
    @if(session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif

    <!-- Display success message if any -->
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    .available-seats {
        margin-top: 20px;
    }
    .seats-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
</style>
@endsection