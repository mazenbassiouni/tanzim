@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-start">
        <button class="btn btn-primary d-flex align-items-center" data-toggle="modal" data-target="#newMissionModal">
            إضافة تكليف
            <img class="ml-2" height="16" src="{{ asset('/svg/plus.svg') }}" alt="plus">
        </button>
    </div>

    <div class="my-4" id="injuryMissionsAccordion">
        @foreach ($investigations as $mission)
            @include('includes.single-mission', ['status' => 'injury'])
        @endforeach
    </div>
@endsection