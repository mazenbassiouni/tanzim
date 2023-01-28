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

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="injuryTab" role="tabpanel" aria-labelledby="injuries">
            <div class="card-body" id="injuryMissionsAccordion">
                @foreach ($injuryCouncils as $mission)
                    @include('includes.single-mission', ['status' => 'injury'])
                @endforeach
            </div>
        </div>

        <div class="tab-pane fade" id="sickTab" role="tabpanel" aria-labelledby="sick">
            <div class="card-body" id="sickMissionsAccordion">
                @foreach ($sickCouncils as $mission)
                    @include('includes.single-mission', ['status' => 'sick'])
                @endforeach
            </div>
        </div>

        <div class="tab-pane fade" id="surgeryTab" role="tabpanel" aria-labelledby="surgery">
            <div class="card-body" id="surgeryMissionsAccordion">
                @foreach ($surgeryApprovals as $mission)
                    @include('includes.single-mission', ['status' => 'surgery'])
                @endforeach
            </div>
        </div>
    </div>
@endsection