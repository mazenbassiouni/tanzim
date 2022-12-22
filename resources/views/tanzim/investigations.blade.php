@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-start">
        <button class="btn btn-primary d-flex align-items-center" data-toggle="modal" data-target="#newMissionModal">
            إضافة تكليف
            <img class="ml-2" height="16" src="{{ asset('/svg/plus.svg') }}" alt="plus">
        </button>
    </div>

    <div class="my-4" id="injuryMissionsAccordion">
        @foreach ($investigations as $mission)
            @include('includes.single-mission', ['status' => 'injury'])
        @endforeach
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
                            <input type="text" class="form-control text-right" name="title" value="{{ old('title') }}" id="missionTitle" {{ old('categoryId') && old('categoryId') != 1 ? 'disabled' : '' }}>
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

                        <div class="input-group mb-3">
                            <input type="date" class="form-control text-right" name="startedAt" value="{{ old('startedAt') }}">
                            <div class="input-group-append">
                                <span class="input-group-text" style="width: 5.5rem">تاريخ البدء</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <select name="categoryId" class="form-select form-control text-right" aria-label="Default select example" style="direction: rtl">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"  {{ old('categoryId') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">النوع</span>
                            </div>
                        </div>

                        <div class="input-group mb-3 search-input-group">
                            <input class="form-control text-right" placeholder="بحث" id="personSearch" {{ old('categoryId') && old('categoryId') != 1 ? '' : 'disabled' }}>
                            <div class="input-group-append">
                                <span class="input-group-text" style="width: 5.5rem; justify-content:center;"><img height="15" src="{{ asset('svg/search.svg') }}" alt=""></span>
                            </div>
                            <div id="search-result-wrapper" class="d-none">
                                <div class="mid p-3"><img height="20" src="{{ asset('gif/loader.gif') }}" alt=""></div>
                            </div>
                        </div>

                        <div class="px-3 {{ old('categoryId') && old('categoryId') != 1 ? '' : 'd-none' }}" style="direction: rtl" id="personInfo">
                            <div class="text-right">
                                <span class="d-inline-block" style="width:5rem; ">رتبة/درجة</span>
                                <span>:</span>
                                <span id="personRankDisplay">{{ old('personId') ? User::find(old('personId'))->rank->name : '' }}</span>
                            </div>
                            <div class="text-right">
                                <span class="d-inline-block" style="width:5rem; ">إسم</span>
                                <span>:</span>
                                <span id="personNameDisplay">{{ old('personId') ? User::find(old('personId'))->name : '' }}</span>
                            </div>
                        </div>

                        <input name="personId" hidden id="personId" value="{{ old('personId') }}">

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

        document.querySelector('#newMissionModal select[name="categoryId"]').addEventListener('change', e=>{
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