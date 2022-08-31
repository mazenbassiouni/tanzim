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


    <div class="modal fade" id="newMissionModal" tabindex="-1" role="dialog" aria-labelledby="new mission modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header flex-row-reverse">
                    <h5 class="modal-title" id="exampleModalLongTitle">تكليف جديد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: -1rem auto -1rem -1rem">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('add-new-mission') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control text-right" name="title" value="{{ old('title') }}">
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">العنوان</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <textarea class="form-control text-right" aria-label="With textarea" name="desc">{{ old('desc') }}</textarea>
                            <div class="input-group-append">
                                <span class="input-group-text" style="width: 5.5rem">الموضوع</span>
                            </div>
                        </div>

                        <div class="input-group">
                            <input type="date" class="form-control text-right" name="startedAt" value="{{ old('startedAt') }}">
                            <div class="input-group-append">
                                <span class="input-group-text" style="width: 5.5rem">تاريخ البدء</span>
                            </div>
                        </div>

                        <div class="alert alert-danger bg-danger text-white mt-4 text-right d-none" id="newMissionErrorBag">
                            <ul class="list-unstyled m-0" id="newMissionErrorsList"></ul>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if ($errors->any() && session('error_type') == 'new mission')
        <script>
            $(document).ready(function(){
                let errors = @json($errors->all());
                let bag = '';
                errors.forEach(error => {
                    bag += `<li>${error}<img height="14" class="ml-3" src="{{ asset('svg/times-circle.svg') }}" alt=""></i></li>`
                });
                $('#newMissionModal').modal('show');
                $('#newMissionErrorsList').html(bag);
                $('#newMissionErrorBag').removeClass('d-none');

                setTimeout(() => {
                    $('#newMissionErrorBag').addClass('d-none');
                }, 10000);
            })
        </script>
    @endif
@endsection