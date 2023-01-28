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
          <a class="nav-link active" id="families" data-toggle="tab" href="#familyTab" role="tab" aria-controls="familyTab" aria-selected="true"><b>عائلية</b></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="parents" data-toggle="tab" href="#parentTab" role="tab" aria-controls="parentTab" aria-selected="false"><b>والدين</b></a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="familyTab" role="tabpanel" aria-labelledby="families">
            <div class="card-body" id="familyMissionsAccordion">
                @foreach ($familyCards as $mission)
                    @include('includes.single-mission', ['status' => 'family'])
                @endforeach
            </div>
        </div>

        <div class="tab-pane fade" id="parentTab" role="tabpanel" aria-labelledby="parents">
            <div class="card-body" id="parentMissionsAccordion">
                @foreach ($parentCards as $mission)
                    @include('includes.single-mission', ['status' => 'parent'])
                @endforeach
            </div>
        </div>
    </div>
@endsection