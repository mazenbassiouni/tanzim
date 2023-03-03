@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-start">
        <button class="btn btn-primary d-flex align-items-center" data-toggle="modal" data-target="#newMissionModal">
            إضافة تكليف
            <img class="ml-2" height="16" src="{{ asset('/svg/plus.svg') }}" alt="plus">
        </button>
    </div>

    <ul class="nav nav-tabs flex-row-reverse mt-3" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#activeInvestigationTab" role="tab"><b>جاري</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#pendingInvestigationTab" role="tab"><b>معلق</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#doneInvestigationTab" role="tab"><b>منتهي</b></a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        @foreach( $investigations as $key => $missions )
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{$key}}InvestigationTab" role="tabpanel" aria-labelledby="sick">
                <div class="card-body" id="{{$key}}InvestigationMissionsAccordion">
                    @if($missions->count())
                        @foreach ($missions as $mission)
                            @include('includes.single-mission', ['status' => $key.'Investigation'])
                        @endforeach
                    @else
                        <div class="text-center mt-5 pt-5"><b>لا يكن</b></div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection