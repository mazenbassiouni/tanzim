@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-start">
        <button class="btn btn-primary d-flex align-items-center" data-toggle="modal" data-target="#newMissionModal">
            إضافة تكليف
            <img class="ml-2" height="16" src="{{ asset('/svg/plus.svg') }}" alt="plus">
        </button>
    </div>

    {{-- <div class="my-4" id="injuryMissionsAccordion">
        @foreach ($end_services as $mission)
            @include('includes.single-mission', ['status' => 'injury'])
        @endforeach
    </div> --}}

    <ul class="nav nav-tabs flex-row-reverse mt-3" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#activeEndServiceTab" role="tab"><b>جاري</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#pendingEndServiceTab" role="tab"><b>معلق</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#doneEndServiceTab" role="tab"><b>منتهي</b></a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        @foreach( $end_services as $key => $missions )
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{$key}}EndServiceTab" role="tabpanel" aria-labelledby="sick">
                <div class="card-body" id="{{$key}}EndServiceMissionsAccordion">
                    @if($missions->count())
                        @foreach ($missions as $mission)
                            @include('includes.single-mission', ['status' => $key.'EndService'])
                        @endforeach
                    @else
                        <div class="text-center mt-5 pt-5"><b>لا يكن</b></div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection