@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-start">
        <button class="btn btn-primary d-flex align-items-center" data-toggle="modal" data-target="#newTaskModal">
            إضافة بند
            <img class="ml-2" height="16" src="{{ asset('/svg/plus.svg') }}" alt="plus">
        </button>
    </div>

    <div class="card text-right  my-5">
        <div class="card-header text-white bg-primary">
            <div class="d-flex align-items-center justify-content-between">
                <a href="#" class="p-1" data-toggle="modal" data-target="#editMissionModal">
                    <img height="20" src="{{ asset('svg/white-pencil.svg') }}" alt="">
                </a>
                <div>
                    <div class="h5 m-0">
                        {{ $mission->title }}
                    </div>
                    <div class="text-light" style="line-height: .9">
                        {{ $mission->desc }} ({{ $mission->started_at->locale('ar')->isoFormat('dddd, DD/MM/OY') }})
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @foreach ($mission->tasks as $task)
                @include('includes.single-task')
            @endforeach
        </div>
    </div>

    <div class="modal fade" id="newTaskModal" tabindex="-1" role="dialog" aria-labelledby="new task modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header flex-row-reverse">
                    <h5 class="modal-title" id="exampleModalLongTitle">بند جديد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: -1rem auto -1rem -1rem">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('add-new-task') }}" method="POST">
                    @csrf
                    <input type="number" name="missionId" value="{{$mission->id}}" hidden>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control text-right" name="title">
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">العنوان</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <textarea class="form-control text-right" aria-label="With textarea" name="desc"></textarea>
                            <div class="input-group-append">
                                <span class="input-group-text" style="width: 5.5rem">الموضوع</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="date" class="form-control text-right" name="dueTo">
                            <div class="input-group-append">
                                <span class="input-group-text" style="width: 5.5rem">قبل تاريخ</span>
                            </div>
                        </div>
                        
                        <div class="text-right">الحالة</div>
                        <div class="form-check d-flex justify-content-end align-items-center">
                            <input class="form-check-input" type="radio" name="status" id="active" value="active" checked>
                            <label class="form-check-label text-muted mr-4" for="active">
                                جاري
                            </label>
                        </div>

                        <div class="form-check d-flex justify-content-end align-items-center">
                            <input class="form-check-input" type="radio" name="status" id="pending" value="pending">
                            <label class="form-check-label text-muted mr-4" for="pending">
                                مُعلق
                            </label>
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

    <div class="modal fade" id="editMissionModal" tabindex="-1" role="dialog" aria-labelledby="new mission modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header flex-row-reverse">
                    <h5 class="modal-title" id="exampleModalLongTitle">تعديل تكليف</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: -1rem auto -1rem -1rem">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('edit-mission') }}" method="POST">
                    @csrf
                    <input type="number" name="missionId" value="{{$mission->id}}" hidden>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control text-right" name="title" value="{{ $mission->title }}">
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">العنوان</span>
                            </div>
                        </div>

                        <div class="input-group">
                            <textarea class="form-control text-right" aria-label="With textarea" name="desc">{{ $mission->desc }}</textarea>
                            <div class="input-group-append">
                                <span class="input-group-text" style="width: 5.5rem">الموضوع</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button class="btn btn-primary">تعديل</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.querySelectorAll('input[name="status"]').forEach(input => {
            input.addEventListener('change', (e)=>{
                let dateInput = e.target.closest('form').querySelector('input[name="dueTo"]');
                if(e.target.checked && e.target.value == 'active'){
                    dateInput.disabled = false;
                }else{
                    dateInput.disabled = true;
                }
            })
        })
    </script>
@endsection