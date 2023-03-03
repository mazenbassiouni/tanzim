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
            <a class="nav-link active" data-toggle="tab" href="#tabOne" role="tab" aria-controls="tabOne" aria-selected="true"><b>خارج الوحدة</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tabTwo" role="tab" aria-controls="tabTwo" aria-selected="false"><b>على الوحدة</b></a>
        </li>
    </ul>

    <div class="tab-content p-3" id="myTabContent">
        <div class="tab-pane fade show active" id="tabOne" role="tabpanel" aria-labelledby="tabOne">
            <div class="card-body" style="border: 1px solid #dee2e6;">
                <ul class="nav nav-tabs flex-row-reverse mt-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#activeTabOneSub" role="tab"><b>جاري</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#pendingTabOneSub" role="tab"><b>معلق</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#doneTabOneSub" role="tab"><b>منتهي</b></a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    @foreach( $outsideAttach as $key => $missions )
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{$key}}TabOneSub" role="tabpanel" aria-labelledby="sick">
                            <div class="card-body" id="{{$key}}TabOneMissionsAccordion">
                                @if($missions->count())
                                    @foreach ($missions as $mission)
                                        @include('includes.single-mission', ['status' => $key.'TabOne'])
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

        <div class="tab-pane fade" id="tabTwo" role="tabpanel" aria-labelledby="sick">
            <div class="card-body" style="border: 1px solid #dee2e6;">
                <ul class="nav nav-tabs flex-row-reverse mt-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#activeTabTwoSub" role="tab"><b>جاري</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#pendingTabTwoSub" role="tab"><b>معلق</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#doneTabTwoSub" role="tab"><b>منتهي</b></a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    @foreach( $insideAttach as $key => $missions )
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{$key}}TabTwoSub" role="tabpanel" aria-labelledby="sick">
                            <div class="card-body" id="{{$key}}TabTwoMissionsAccordion">
                                @if($missions->count())
                                    @foreach ($missions as $mission)
                                        @include('includes.single-mission', ['status' => $key.'TabTwo'])
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