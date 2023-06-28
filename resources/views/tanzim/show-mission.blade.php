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
                    <div class="h5 m-0 d-flex flex-row-reverse">
                        <div class="ml-3">
                            @if($mission->category_id == 1)
                                {{ $mission->title }}
                            @else
                                {{ $mission->category->name }}
                            @endif
                        </div>
                        
                        <div>
                            @if ($mission->people->count() && $mission->people->count() == 1 )
                                <a class="mission d-block" href="{{ url('person',$mission->people()->first()->id) }}">{{ $mission->people()->first()->rank->name.'/'.$mission->people()->first()->name }}</a>
                            @elseif($mission->people->count())
                                @foreach ($mission->people as $per)
                                    <a class="mission d-block {{ $loop->last ? 'mb-3' : '' }}" href="{{ url('person',$per->id) }}">{{ $per->rank->name.'/'.$per->name }}</a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="text-light">
                        {{ $mission->desc ? $mission->desc .'.': ''  }} <b>({{ $mission->started_at->locale('ar')->isoFormat('dddd, DD/MM/OY') }})</b>
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
                    <h5 class="modal-title">بند جديد</h5>
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
                    <h5 class="modal-title">تعديل تكليف</h5>
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
                            <input class="form-control text-right" placeholder="بحث" id="personSearch" autocomplete="off">
                            <div class="input-group-append">
                                <span class="input-group-text" style="width: 5.5rem; justify-content:center;"><img height="15" src="{{ asset('svg/search.svg') }}" alt=""></span>
                            </div>
                            <div id="search-result-wrapper" class="d-none" style="z-index: 999;">
                                <div class="mid p-3"><img height="20" src="{{ asset('gif/loader.gif') }}" alt=""></div>
                            </div>
                        </div>

                        <div class="px-3" style="direction: rtl" id="personInfo">
                            <div class="text-right row">
                                <div class="col-2">خاصة</div>
                                <div class="col-10 pr-0">
                                    <ul id="peopleList">
                                        @if (old('peopleId'))
                                            @foreach (json_decode(old('peopleId')) as $id)
                                                @php
                                                    $old_person = Person::find($id);
                                                @endphp
                                                <li>
                                                    <div class="d-flex justify-content-between">
                                                        <span>{{ $old_person->rank->name .'/ '. $old_person->name }}</span>
                                                        <span class="close d-flex align-items-center" data-id="{{ $old_person->id }}" style="font-size: 1rem;">x</span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @else
                                            @foreach ($mission->people as $per)
                                                <li>
                                                    <div class="d-flex justify-content-between">
                                                        <span>{{ $per->rank->name .'/ '. $per->name }}</span>
                                                        <span class="close d-flex align-items-center" data-id="{{ $per->id }}" style="font-size: 1rem;">x</span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <input name="peopleId" hidden id="peopleId" value="{{ old('peopleId') ? old('peopleId') : $mission->people->pluck('id') }}">

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
                    <h5 class="modal-title">حذف تكليف</h5>
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

                                if( !JSON.parse(peopleId.value).includes(one.id) ){
                                let personLable = document.createElement('div');
                                personLable.className = 'd-flex justify-content-between'
                                
                                let personName = document.createElement('span');
                                personName.textContent = `${one.rank.name}/ ${one.name}`;
                                personLable.appendChild(personName);
    
                                let removePerson = document.createElement('span');
                                removePerson.className = 'close d-flex align-items-center';
                                removePerson.textContent = `x`;
                                removePerson.style.fontSize = '1rem'
                                removePerson.dataset.id = one.id;
                                personLable.appendChild(removePerson);
                                addRemovePersonFq(removePerson, one.id);
    
                                let personListItem = document.createElement('li');
                                personListItem.appendChild(personLable);
    
                                peopleList.appendChild(personListItem);
    
                                let peopleArray = JSON.parse(peopleId.value);
                                peopleArray.push(one.id);
                                peopleId.value = JSON.stringify(peopleArray);
                            }
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

                                if( !JSON.parse(peopleId.value).includes(one.id) ){
                                let personLable = document.createElement('div');
                                personLable.className = 'd-flex justify-content-between'
                                
                                let personName = document.createElement('span');
                                personName.textContent = `${one.rank.name}/ ${one.name}`;
                                personLable.appendChild(personName);
    
                                let removePerson = document.createElement('span');
                                removePerson.className = 'close d-flex align-items-center';
                                removePerson.textContent = `x`;
                                removePerson.style.fontSize = '1rem'
                                removePerson.dataset.id = one.id;
                                personLable.appendChild(removePerson);
                                addRemovePersonFq(removePerson, one.id);
    
                                let personListItem = document.createElement('li');
                                personListItem.appendChild(personLable);
    
                                peopleList.appendChild(personListItem);
    
                                let peopleArray = JSON.parse(peopleId.value);
                                peopleArray.push(one.id);
                                peopleId.value = JSON.stringify(peopleArray);
                            }
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

        function addRemovePersonFq(btn, id){
            btn.addEventListener('click', e =>{
                let peopleArray = JSON.parse(peopleId.value);
                let index = peopleArray.indexOf(id);
                if (index > -1) {
                    peopleArray.splice(index, 1);
                    peopleId.value = JSON.stringify(peopleArray);
                    btn.closest('li').remove();
                }
            })
        }

        document.querySelectorAll('#peopleList .close').forEach(btn => {
            addRemovePersonFq(btn, parseInt(btn.dataset.id))
        })

        document.querySelector('#editMissionModal select[name="categoryId"]').addEventListener('change', e=>{
            if(e.target.value == 1){
                // personSearch.disabled = true;
                // peopleId.disabled = true;
                missionTitle.disabled = false;

                // personInfo.classList.add('d-none');
            }else{
                // personSearch.disabled = false;
                // peopleId.disabled = false;
                missionTitle.disabled = true;

                // personInfo.classList.remove('d-none');
            }
        })
    </script>
@endsection