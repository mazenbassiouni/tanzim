@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-start">
        <button class="btn btn-primary d-flex align-items-center" data-toggle="modal" data-target="#newPersonModal">
            إضافة ضابط/فرد
            <img class="ml-2" height="16" src="{{ asset('/svg/plus.svg') }}" alt="plus">
        </button>
    </div>

    <div class="modal fade" id="newPersonModal" tabindex="-1" role="dialog" aria-labelledby="new person modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header flex-row-reverse">
                    <h5 class="modal-title" id="exampleModalLongTitle">إضافة ضابط/فرد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: -1rem auto -1rem -1rem">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('add-new-person') }}" method="POST">
                    @csrf
                    <div class="modal-body"> 
                        <div class="input-group mb-3">
                            <select name="rankId" class="form-select form-control text-right" aria-label="Default select example" style="direction: rtl">
                                <option value=""></option>
                                @foreach ($ranks as $rank)
                                    <option value="{{ $rank->id }}"  {{ old('rankId') == $rank->id ? 'selected' : '' }}>{{ $rank->name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">رتبة/درجة</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control text-right" name="name" value="{{ old('name') }}">
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">الإسم</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input class="form-control text-right" name="militaryNum" value="{{ old('militaryNum') }}">
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">رقم عسكري</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input class="form-control text-right" name="seniorityNum" value="{{ old('seniorityNum') }}">
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">رقم أقدمية</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <select name="specialityId" class="form-select form-control text-right" aria-label="Default select example" style="direction: rtl">
                                <option value=""></option>
                                @foreach ($specialities as $speciality)
                                    <option value="{{ $speciality->id }}"  {{ old('specialityId') == $speciality->id ? 'selected' : '' }}>{{ $speciality->name }}</option>
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
                                    <option value="{{ $unit->id }}"  {{ old('milUnitId') == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
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
                                    <option value="{{ $unit->id }}"  {{ old('unitId') == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">تسكين داخلي</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control text-right" name="note" value="{{ old('note') }}">
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">ملاحظات</span>
                            </div>
                        </div>

                        <div class="text-right">على القوة</div>
                        <div class="form-check d-flex justify-content-end align-items-center">
                            <input class="form-check-input" type="radio" name="isForce" id="active" value="1" {{ old('isForce') == 1 || old('isForce') === null ?  'checked' : '' }}>
                            <label class="form-check-label text-muted mr-4" for="active">
                                نعم
                            </label>
                        </div>
                        <div class="form-check d-flex justify-content-end align-items-center">
                            <input class="form-check-input" type="radio" name="isForce" id="notActive" value="2" {{ old('isForce') !== null && old('isForce') == 0 ?  'checked' : '' }}>
                            <label class="form-check-label text-muted mr-4" for="notActive">
                                لا
                            </label>
                        </div>

                        <div class="text-right">موقف الخدمة</div>
                        <div class="form-check d-flex justify-content-end align-items-center">
                            <input class="form-check-input" type="radio" name="service" id="Service" value="1" {{ old('service') == 1 || old('service') === null ?  'checked' : '' }}>
                            <label class="form-check-label text-muted mr-4" for="Service">
                                خدمة
                            </label>
                        </div>
                        <div class="form-check d-flex justify-content-end align-items-center">
                            <input class="form-check-input" type="radio" name="service" id="notService" value="2" {{ old('service') !== null && old('service') == 0 ?  'checked' : '' }}>
                            <label class="form-check-label text-muted mr-4" for="notService">
                                معاش
                            </label>
                        </div>

                        <div class="alert alert-danger bg-danger text-white mt-4 text-right d-none" id="newPersonErrorBag">
                            <ul class="list-unstyled m-0" id="newPersonErrorsList"></ul>
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
                $('#newPersonModal').modal('show');
                $('#newPersonErrorsList').html(bag);
                $('#newPersonErrorBag').removeClass('d-none');

                setTimeout(() => {
                    $('#newPersonErrorBag').addClass('d-none');
                }, 10000);
            })
        </script>
    @endif
@endsection