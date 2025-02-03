<!-- filepath: /c:/xampp/htdocs/cinebook-be/resources/views/seats/select.blade.php -->

@extends('layouts.app')

@section('judul', 'Pilih Kursi')

@section('content')
<div class="container">
    <h1>{{ $showtime->movies->judul }} - {{ $showtime->theaters->nama }}</h1>
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

    @if(session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('seats.book') }}">
        @csrf
        <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
        <input type="hidden" name="seats_id" value="{{ json_encode($availableSeats->pluck('id')) }}">
        <button type="submit" class="btn btn-primary mt-3">Proceed to Booking</button>
    </form>
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