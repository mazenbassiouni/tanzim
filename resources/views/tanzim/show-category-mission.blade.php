@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between">
        <button class="btn btn-primary d-flex align-items-center" data-toggle="modal" data-target="#newMissionModal">
            إضافة تكليف
            <img class="ml-2" height="16" src="{{ asset('/svg/plus.svg') }}" alt="plus">
        </button>
        <h3>{{ $category->name }}</h3>
    </div>

    <ul class="nav nav-tabs flex-row-reverse mt-3" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#activeMissionsTab" role="tab"><b>جاري</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#pendingMissionsTab" role="tab"><b>معلق</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#doneMissionsTab" role="tab"><b>منتهي</b></a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        @foreach( $missions as $key => $missions )
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{$key}}MissionsTab" role="tabpanel" aria-labelledby="sick">
                <div class="card-body" id="{{$key}}MissionsAccordion">
                    @if($missions->count())
                        @foreach ($missions as $mission)
                            @include('includes.single-mission', ['status' => $key])
                        @endforeach
                    @else
                        <div class="text-center mt-5 pt-5"><b>لا يكن</b></div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection