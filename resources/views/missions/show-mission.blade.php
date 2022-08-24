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
                            <input type="text" class="form-control text-right" name="title" value="{{ old('title') && session('error_type') == 'new task' ? old('title') : '' }}">
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">العنوان</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <textarea class="form-control text-right" aria-label="With textarea" name="desc">{{ old('desc') && session('error_type') == 'new task' ? old('desc') : '' }}</textarea>
                            <div class="input-group-append">
                                <span class="input-group-text" style="width: 5.5rem">الموضوع</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="date" class="form-control text-right" name="dueTo" value="{{ old('dueTo') && session('error_type') == 'new task' ? old('dueTo') : '' }}" {{ old('status') == 'pending' && session('error_type') == 'new task' ? 'disabled' : '' }}>
                            <div class="input-group-append">
                                <span class="input-group-text" style="width: 5.5rem">قبل تاريخ</span>
                            </div>
                        </div>
                        
                        <div class="text-right">الحالة</div>
                        <div class="form-check d-flex justify-content-end align-items-center">
                            <input class="form-check-input" type="radio" name="status" id="active" value="active" {{ old('status') == 'pending' && session('error_type') == 'new task' ? '' : 'checked' }}>
                            <label class="form-check-label text-muted mr-4" for="active">
                                جاري
                            </label>
                        </div>

                        <div class="form-check d-flex justify-content-end align-items-center">
                            <input class="form-check-input" type="radio" name="status" id="pending" value="pending" {{ old('status') == 'pending' && session('error_type') == 'new task' ? 'checked' : '' }}>
                            <label class="form-check-label text-muted mr-4" for="pending">
                                مُعلق
                            </label>
                        </div>

                        <div class="alert alert-danger bg-danger text-white mt-4 text-right d-none" id="newTaskErrorBag">
                            <ul class="list-unstyled m-0" id="newTaskErrorsList"></ul>
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
                            <input type="text" class="form-control text-right" name="title" value="{{ old('title')  && session('error_type') == 'edit mission' ? old('title') : $mission->title }}">
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">العنوان</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <textarea class="form-control text-right" aria-label="With textarea" name="desc">{{ old('desc')  && session('error_type') == 'edit mission' ? old('desc') : $mission->desc }}</textarea>
                            <div class="input-group-append">
                                <span class="input-group-text" style="width: 5.5rem">الموضوع</span>
                            </div>
                        </div>

                        <div class="input-group">
                            <input type="date" class="form-control text-right" name="startedAt" value="{{ old('startedAt')  && session('error_type') == 'edit mission' ? old('startedAt') : $mission->started_at->format('Y-m-d') }}">
                            <div class="input-group-append">
                                <span class="input-group-text" style="width: 5.5rem">تاريخ البدء</span>
                            </div>
                        </div>

                        <div class="alert alert-danger bg-danger text-white mt-4 text-right d-none" id="editMissionErrorBag">
                            <ul class="list-unstyled m-0" id="editMissionErrorsList"></ul>
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

    @if ($errors->any() && session('error_type') == 'edit mission' )
        <script>
            $(document).ready(function(){
                let errors = @json($errors->all());
                let bag = '';
                errors.forEach(error => {
                    bag += `<li>${error}<img height="14" class="ml-3" src="{{ asset('svg/times-circle.svg') }}" alt=""></i></li>`
                });
                $('#editMissionModal').modal('show');
                $('#editMissionErrorsList').html(bag);
                $('#editMissionErrorBag').removeClass('d-none');

                setTimeout(() => {
                    $('#editMissionErrorBag').addClass('d-none');
                }, 10000);
            })
            @if(session('test'))
                console.log(@json(session('test')));
            @endif
        </script>
    @endif

    @if ($errors->any() && session('error_type') == 'new task' )
        <script>
            $(document).ready(function(){
                let errors = @json($errors->all());
                let bag = '';
                errors.forEach(error => {
                    bag += `<li>${error}<img height="14" class="ml-3" src="{{ asset('svg/times-circle.svg') }}" alt=""></i></li>`
                });
                $('#newTaskModal').modal('show');
                $('#newTaskErrorsList').html(bag);
                $('#newTaskErrorBag').removeClass('d-none');

                setTimeout(() => {
                    $('#newTaskErrorBag').addClass('d-none');
                }, 10000);
            })
            @if(session('test'))
                console.log(@json(session('test')));
            @endif
        </script>
    @endif

    @if ($errors->any() && session('error_type') == 'edit task' && old('taskId') )
        <script>
            $(document).ready(function(){
                let errors = @json($errors->all());
                let bag = '';
                errors.forEach(error => {
                    bag += `<li>${error}<img height="14" class="ml-3" src="{{ asset('svg/times-circle.svg') }}" alt=""></i></li>`
                });
                $('#editTask{{old('taskId')}}').modal('show');
                $('#editTask{{old('taskId')}} #editTaskErrorsList').html(bag);
                $('#editTask{{old('taskId')}} #editTaskErrorBag').removeClass('d-none');

                setTimeout(() => {
                    $('#editTask{{old('taskId')}} #editTaskErrorBag').addClass('d-none');
                }, 10000);
            })
            @if(session('test'))
                console.log(@json(session('test')));
            @endif
        </script>
    @endif
@endsection