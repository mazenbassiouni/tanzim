@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-start">
        <button class="btn btn-primary d-flex align-items-center" data-toggle="modal" data-target="#newMissionModal">
            إضافة تكليف
            <img class="ml-2" height="16" src="{{ asset('/svg/plus.svg') }}" alt="plus">
        </button>
    </div>

    <ul class="nav nav-tabs flex-row-reverse mt-3" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="injuries" data-toggle="tab" href="#injuryTab" role="tab" aria-controls="injuryTab" aria-selected="true"><b>إصابة</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="sick" data-toggle="tab" href="#sickTab" role="tab" aria-controls="sickTab" aria-selected="false"><b>مرضي</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="surgery" data-toggle="tab" href="#surgeryTab" role="tab" aria-controls="surgeryTab" aria-selected="false"><b>تدخل جراحي</b></a>
        </li>
    </ul>

    <div class="tab-content p-3" id="myTabContent">
        <div class="tab-pane fade show active" id="injuryTab" role="tabpanel" aria-labelledby="injuries">
            <div class="card-body" style="border: 1px solid #dee2e6;">
                <ul class="nav nav-tabs flex-row-reverse mt-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#activeInjuryTab" role="tab"><b>جاري</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#pendingInjuryTab" role="tab"><b>معلق</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#doneInjuryTab" role="tab"><b>منتهي</b></a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    @foreach( $injuryCouncils as $key => $missions )
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{$key}}InjuryTab" role="tabpanel" aria-labelledby="sick">
                            <div class="card-body" id="{{$key}}InjuryMissionsAccordion">
                                @if($missions->count())
                                    @foreach ($missions as $mission)
                                        @include('includes.single-mission', ['status' => $key.'Injury'])
                                    @endforeach
                                @else
                                    <div class="text-center mt-5 pt-5"><b>لا يكن</b></div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="sickTab" role="tabpanel" aria-labelledby="sick">
            <div class="card-body" style="border: 1px solid #dee2e6;">
                <ul class="nav nav-tabs flex-row-reverse mt-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#activeSickTab" role="tab"><b>جاري</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#pendingSickTab" role="tab"><b>معلق</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#doneSickTab" role="tab"><b>منتهي</b></a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    @foreach( $sickCouncils as $key => $missions )
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{$key}}SickTab" role="tabpanel" aria-labelledby="sick">
                            <div class="card-body" id="{{$key}}SickMissionsAccordion">
                                @if($missions->count())
                                    @foreach ($missions as $mission)
                                        @include('includes.single-mission', ['status' => $key.'sick'])
                                    @endforeach
                                @else
                                    <div class="text-center mt-5 pt-5"><b>لا يكن</b></div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="surgeryTab" role="tabpanel" aria-labelledby="surgery">
            <div class="card-body" style="border: 1px solid #dee2e6;">
                <ul class="nav nav-tabs flex-row-reverse mt-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#activeSurgeryTab" role="tab"><b>جاري</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#pendingSurgeryTab" role="tab"><b>معلق</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#doneSurgeryTab" role="tab"><b>منتهي</b></a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    @foreach( $surgeryApprovals as $key => $missions )
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{$key}}SurgeryTab" role="tabpanel" aria-labelledby="surgery">
                            <div class="card-body" id="{{$key}}SurgeryMissionsAccordion">
                                @if($missions->count())
                                    @foreach ($missions as $mission)
                                        @include('includes.single-mission', ['status' => $key.'Surgery'])
                                    @endforeach
                                @else
                                    <div class="text-center mt-5 pt-5"><b>لا يكن</b></div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection