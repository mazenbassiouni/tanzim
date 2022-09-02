@extends('layouts.app')

@section('content')
    
    <div class="card text-right  my-5">
        <div class="card-header text-white bg-primary">
            <div class="d-flex align-items-center justify-content-between">
                <a href="#" class="p-1" data-toggle="modal" data-target="#editPersonModal">
                    <img height="20" src="{{ asset('svg/white-pencil.svg') }}" alt="">
                </a>
                <div>
                    <div class="h5 m-0">
                        {{ $person->rank->name.'/'.$person->name }}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @foreach ($person->missions as $mission)
                @include('includes.single-mission', ['status' => ''])
            @endforeach
        </div>
    </div>


    <div class="modal fade" id="editPersonModal" tabindex="-1" role="dialog" aria-labelledby="edit person modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header flex-row-reverse">
                    <h5 class="modal-title" id="exampleModalLongTitle">تعديل بيانات الضابط/الفرد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: -1rem auto -1rem -1rem">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('edit-person') }}" method="POST">
                    @csrf
                    <input type="number" name="personId" value="{{ $person->id }}" hidden>

                    <div class="modal-body"> 
                        <div class="input-group mb-3">
                            <select name="rankId" class="form-select form-control text-right" aria-label="Default select example" style="direction: rtl">
                                <option value=""></option>
                                @foreach ($ranks as $rank)
                                    <option value="{{ $rank->id }}"  {{ old('rankId') === null && $person->rank_id == $rank->id ? 'selected' : (old('rankId') == $rank->id) ? 'selected' : '' }}>{{ $rank->name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">رتبة/درجة</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control text-right" name="name" value="{{ old('name')?? $person->name }}">
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">الإسم</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input class="form-control text-right" name="militaryNum" value="{{ old('militaryNum')?? $person->military_num }}">
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">رقم عسكري</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input class="form-control text-right" name="seniorityNum" value="{{ old('seniorityNum')?? $person->seniority_num }}">
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">رقم أقدمية</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <select name="specialityId" class="form-select form-control text-right" aria-label="Default select example" style="direction: rtl">
                                <option value=""></option>
                                @foreach ($specialities as $speciality)
                                    <option value="{{ $speciality->id }}"  {{ old('specialityId') === null && $person->speciality_id == $speciality->id ? 'selected' : (old('specialityId') == $speciality->id) ? 'selected' : '' }}>{{ $speciality->name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">النخصص</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <select name="milUnitId" class="form-select form-control text-right" aria-label="Default select example" style="direction: rtl">
                                <option value=""></option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}"  {{ old('milUnitId') === null && $person->mil_unit_id == $unit->id ? 'selected' : (old('milUnitId') == $unit->id) ? 'selected' : '' }}>{{ $unit->name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">تسكين</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <select name="unitId" class="form-select form-control text-right" aria-label="Default select example" style="direction: rtl">
                                <option value=""></option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}"  {{ old('unitId') === null && $person->unit_id == $unit->id ? 'selected' : (old('unitId') == $unit->id) ? 'selected' : '' }}>{{ $unit->name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">تسكين داخلي</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control text-right" name="note" value="{{ old('note')?? $person->note }}">
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">ملاحظات</span>
                            </div>
                        </div>

                        <div class="text-right">على القوة</div>
                        <div class="form-check d-flex justify-content-end align-items-center">
                            <input class="form-check-input" type="radio" name="isForce" id="active" value="1" {{ old('isForce') === null && $person->is_force == 1 ? 'checked' : (old('isForce') == 1  ?  'checked' : '') }}>
                            <label class="form-check-label text-muted mr-4" for="active">
                                نعم
                            </label>
                        </div>
                        <div class="form-check d-flex justify-content-end align-items-center">
                            <input class="form-check-input" type="radio" name="isForce" id="notActive" value="0" {{ old('isForce') === null && $person->is_force == 0 ? 'checked' : (old('isForce') !== null && old('isForce') == 0  ?  'checked' : '') }}>
                            <label class="form-check-label text-muted mr-4" for="notActive">
                                لا
                            </label>
                        </div>

                        <div class="text-right">موقف الخدمة</div>
                        <div class="form-check d-flex justify-content-end align-items-center">
                            <input class="form-check-input" type="radio" name="service" id="Service" value="1" {{ old('service') === null && $person->service == 1 ? 'checked' : (old('service') == 1  ?  'checked' : '') }}>
                            <label class="form-check-label text-muted mr-4" for="Service">
                                خدمة
                            </label>
                        </div>
                        <div class="form-check d-flex justify-content-end align-items-center">
                            <input class="form-check-input" type="radio" name="service" id="notService" value="0" {{ old('service') === null && $person->service == 0 ? 'checked' : (old('service') !== null && old('service') == 0  ?  'checked' : '') }}>
                            <label class="form-check-label text-muted mr-4" for="notService">
                                معاش
                            </label>
                        </div>

                        <div class="alert alert-danger bg-danger text-white mt-4 text-right d-none" id="editPersonErrorBag">
                            <ul class="list-unstyled m-0" id="editPersonErrorsList"></ul>
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
    @if ($errors->any())
        <script>
            $(document).ready(function(){
                let errors = @json($errors->all());
                let bag = '';
                errors.forEach(error => {
                    bag += `<li>${error}<img height="14" class="ml-3" src="{{ asset('svg/times-circle.svg') }}" alt=""></i></li>`
                });
                $('#editPersonModal').modal('show');
                $('#editPersonErrorsList').html(bag);
                $('#editPersonErrorBag').removeClass('d-none');

                setTimeout(() => {
                    $('#editPersonErrorBag').addClass('d-none');
                }, 10000);
            })
        </script>
    @endif
@endsection