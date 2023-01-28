@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-start">
        <button class="btn btn-primary d-flex align-items-center" data-toggle="modal" data-target="#newMissionModal">
            إضافة تكليف
            <img class="ml-2" height="16" src="{{ asset('/svg/plus.svg') }}" alt="plus">
        </button>
    </div>

    <div class="card text-right my-5">
        <div class="card-header h5 text-white bg-primary">
            التكاليف الجارية
        </div>
        <div class="card-body" id="activeMissionsAccordion">
            @foreach ($activeMissions as $mission)
                @include('includes.single-mission', ['status' => 'active'])
            @endforeach
        </div>
    </div>

    <div class="card text-right my-5">
        <div class="card-header h5 text-white bg-primary">
            التكاليف المعلقة
        </div>
        <div class="card-body" id="pendingMissionsAccordion">
            @foreach ($pendingMissions as $mission)
                @include('includes.single-mission', ['status' => 'pending'])
            @endforeach
        </div>
    </div>

    <div class="card text-right my-5">
        <div class="card-header h5 text-white bg-primary">
            التكاليف المنتهية
        </div>
        <div class="card-body" id="doneMissionsAccordion">
            @foreach ($doneMissions as $mission)
                @include('includes.single-mission', ['status' => 'done'])
            @endforeach
        </div>
    </div>
@endsection