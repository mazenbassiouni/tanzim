@extends('layouts.app')

@section('styles')
    <style>
        a.mission{
            text-decoration: none;
            color: rgba(255,255,255,.5);
        }

        a.mission:hover{
            color: #fff;
        }
    </style>
@endsection

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
                <div>
                    <a href="#" data-toggle="modal" data-target="#deleteMission{{$mission->id}}" class="p-2"><img height="17" src="{{ asset('svg/white-trash.svg') }}" alt=""></a>
                    <a href="#" class="p-1" data-toggle="modal" data-target="#editMissionModal">
                        <img height="20" src="{{ asset('svg/white-pencil.svg') }}" alt="">
                    </a>
                </div>
                <div>
                    <div class="h5 m-0">
                        @if($mission->category_id == 1)
                            {{ $mission->title }}
                        @else
                            {{ $mission->category->name }} <a class="mission" href="{{ url('person',$mission->person->id) }}">{{ $mission->person->rank->name.'/'.$mission->person->name }}</a>
                        @endif
                    </div>
                    <div class="text-light" style="line-height: 1">
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
                            <input type="text" class="form-control text-right" name="title" id="missionTitle" value="{{ old('title')  && session('error_type') == 'edit mission' ? old('title') : $mission->title }}" {{ old('categoryId') !== null && old('categoryId') != 1 ? 'disabled' : (old('categoryId') === null && $mission->category_id != 1 ? 'disabled' : '' ) }}>
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

                        <div class="input-group mb-3">
                            <input type="date" class="form-control text-right" name="startedAt" value="{{ old('startedAt')  && session('error_type') == 'edit mission' ? old('startedAt') : $mission->started_at->format('Y-m-d') }}">
                            <div class="input-group-append">
                                <span class="input-group-text" style="width: 5.5rem">تاريخ البدء</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <select name="categoryId" class="form-select form-control text-right" aria-label="Default select example" style="direction: rtl">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"  {{ old('categoryId') !== null && old('categoryId') == $category->id ? 'selected' : ( old('categoryId') === null && $mission->category_id == $category->id ? 'selected' : '' ) }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">النوع</span>
                            </div>
                        </div>

                        <div class="input-group mb-3 search-input-group">
                            <input class="form-control text-right" placeholder="بحث" id="personSearch" {{ old('categoryId') && old('categoryId') != 1 ? '' : ( old('categoryId') === null && $mission->category_id != 1 ? '' : ' disabled') }}>
                            <div class="input-group-append">
                                <span class="input-group-text" style="width: 5.5rem; justify-content:center;"><img height="15" src="{{ asset('svg/search.svg') }}" alt=""></span>
                            </div>
                            <div id="search-result-wrapper" class="d-none">
                                <div class="mid p-3"><img height="20" src="{{ asset('gif/loader.gif') }}" alt=""></div>
                            </div>
                        </div>

                        <div class="px-3 {{ old('categoryId') !== null && old('categoryId') != 1 ? '' : ( old('categoryId') === null && $mission->category_id != 1 ? '' : ' d-none') }}" style="direction: rtl" id="personInfo">
                            <div class="text-right">
                                <span class="d-inline-block" style="width:5rem; ">رتبة/درجة</span>
                                <span>:</span>
                                <span id="personRankDisplay">{{ old('personId') !== null ? Person::find(old('personId'))->rank->name : ( $mission->category_id != 1 ? $mission->person->rank->name : '' ) }}</span>
                            </div>
                            <div class="text-right">
                                <span class="d-inline-block" style="width:5rem; ">إسم</span>
                                <span>:</span>
                                <span id="personNameDisplay">{{ old('personId') !== null ? Person::find(old('personId'))->name : ( $mission->category_id != 1 ? $mission->person->name : '' ) }}</span>
                            </div>
                        </div>

                        <input name="personId" hidden id="personId" value="{{ old('personId') !== null ? old('personId') : ( $mission->category_id != 1 ? $mission->person->id : '' ) }}">

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

    <div class="modal fade" id="deleteMission{{$mission->id}}" tabindex="-1" role="dialog" aria-labelledby="delete mission modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header flex-row-reverse">
                    <h5 class="modal-title" id="exampleModalLongTitle">حذف تكليف</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: -1rem auto -1rem -1rem">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    تأكيد حذف التكليف
                </div>
                <form action="{{ route('delete-mission') }}" method="POST">
                    @csrf
                    <input type="number" value="{{$mission->id}}" name="missionId" hidden>
                    <div class="modal-footer justify-content-start">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button class="btn btn-primary">حذف</button>
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

    <script>
        personSearch.addEventListener('keyup', e=>{
            e.stopPropagation();
            let s = e.target.value;
            let sBox = e.target.parentElement.querySelector('#search-result-wrapper');

            if(
                e.keyCode === 13 ||
                e.keyCode === 16 ||
                e.keyCode === 17 ||
                e.keyCode === 18 ||
                e.keyCode === 32 ||
                e.keyCode === 27 ||
                e.ctrlKey ||
                e.altKey
            ){
               return false;
            }

            if(s.length && s.length >= 3 ){ 
                sBox.innerHTML = '<div class="mid p-2"><img height="20" src="{{ asset('gif/loader.gif') }}" alt=""></div>';
                sBox.classList.remove('d-none');
                
                (async function(){
                    const resObj = await fetch('{{ route('person-search') }}?search='+s);
                    const res = await resObj.json();
                    
                    if(res.success == true && res.result.length){
                        sBox.innerHTML = '';
                        res.result.forEach( one => {
                            let element = document.createElement('div');
                            element.className =  'res';
                            element.textContent =  `${one.rank.name}/ ${one.name}`;
                            element.addEventListener('click', e=>{
                                sBox.classList.add('d-none');
                                sBox.innerHTML = '';

                                personNameDisplay.innerHTML = one.name;
                                personRankDisplay.innerHTML = one.rank.name;
                                personId.value = one.id;
                            })
                            sBox.appendChild(element);
                        })
                    }else{
                        sBox.innerHTML = '<div class="mid p-2">لا يوجد</div>';
                    }
                })()

            }else{
                sBox.classList.add('d-none');
            }
        });

        personSearch.addEventListener('blur', e=>{
            let sBox = e.target.parentElement.querySelector('#search-result-wrapper');
            setTimeout(()=>{
                sBox.classList.add('d-none');
                sBox.innerHTML = '';
            },300)
        })

        personSearch.addEventListener('focus', e=>{
            let s = e.target.value;
            let sBox = e.target.parentElement.querySelector('#search-result-wrapper');
            
            if(s.length && s.length >= 3 ){ 
                sBox.innerHTML = '<div class="mid p-2"><img height="20" src="{{ asset('gif/loader.gif') }}" alt=""></div>';
                sBox.classList.remove('d-none');
                
                (async function(){
                    const resObj = await fetch('{{ route('person-search') }}?search='+s);
                    const res = await resObj.json();
                    
                    if(res.success == true && res.result.length){
                        sBox.innerHTML = '';
                        res.result.forEach( one => {
                            let element = document.createElement('div');
                            element.className =  'res';
                            element.textContent =  `${one.rank.name}/ ${one.name}`;
                            element.addEventListener('click', e=>{
                                sBox.classList.add('d-none');
                                sBox.innerHTML = '';

                                personNameDisplay.innerHTML = one.name;
                                personRankDisplay.innerHTML = one.rank.name;
                                personId.value = one.id;
                            })
                            sBox.appendChild(element);
                        })
                    }else{
                        sBox.innerHTML = '<div class="mid p-2">لا يوجد</div>';
                    }
                })()

            }else{
                sBox.classList.add('d-none');
            }
        });

        document.querySelector('#editMissionModal select[name="categoryId"]').addEventListener('change', e=>{
            if(e.target.value == 1){
                personSearch.disabled = true;
                personId.disabled = true;
                missionTitle.disabled = false;

                personInfo.classList.add('d-none');
            }else{
                personSearch.disabled = false;
                personId.disabled = false;
                missionTitle.disabled = true;

                personInfo.classList.remove('d-none');
            }
        })
    </script>
@endsection