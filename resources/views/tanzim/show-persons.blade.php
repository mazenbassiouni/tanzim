@extends('layouts.app')

@section('styles')
    <style>
        table{
            direction: rtl;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="d-flex justify-content-between">
        <button class="btn btn-primary d-flex align-items-center" data-toggle="modal" data-target="#newPersonModal">
            إضافة ضابط/فرد
            <img class="ml-2" height="16" src="{{ asset('/svg/plus.svg') }}" alt="plus">
        </button>

        <div class="d-flex flex-row-reverse font-weight-bold">
            <div class="ml-5">
                <span>قوة : <span class="text-primary">{{ $tamam['total'] }}</span></span>
            </div>
            <div class="ml-5">
                <span>ضباط : <span class="text-primary">{{ $tamam['officers'] }}</span></span>
            </div>
            <div class="ml-5">
                <span>ضباط الصف : <span class="text-primary">{{ $tamam['subOfficers'] }}</span></span>
            </div>
            <div>
                <span>جنود : <span class="text-primary">{{ $tamam['soldiers'] }}</span></span>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs flex-row-reverse mt-3" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="officer" data-toggle="tab" href="#officerTab" role="tab" aria-controls="officerTab" aria-selected="true"><b>ضباط</b></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="subOfficer" data-toggle="tab" href="#subOfficerTab" role="tab" aria-controls="subOfficerTab" aria-selected="false"><b>ضباط الصف</b></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="soldier" data-toggle="tab" href="#soliderTab" role="tab" aria-controls="soliderTab" aria-selected="false"><b>جنود</b></a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="officerTab" role="tabpanel" aria-labelledby="officer">
            <table class="table table-striped">
                <thead class="bg-primary text-white">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">رتبة</th>
                        <th scope="col">إسم</th>
                        <th scope="col">رقم عسكري</th>
                        <th scope="col">رقم أقدمية</th>
                        <th scope="col">تخصص</th>
                        <th scope="col">تسكين</th>
                        <th scope="col">تسكين داخلي</th>
                        <th scope="col">ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($officers as $officer)                        
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{ $officer->rank->name }}</td>
                            <td><a style="text-decoration: none" href="{{ url('person',$officer->id) }}">{{ $officer->name }}</a></td>
                            <td>{{ $officer->military_num }}</td>
                            <td>{{ $officer->seniority_num }}</td>
                            <td>{{ $officer->speciality->name }}</td>
                            <td>{{ $officer->milUnit->name }}</td>
                            <td>{{ $officer->Unit->name }}</td>
                            <td>{{ $officer->note }}</td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
        <div class="tab-pane fade" id="subOfficerTab" role="tabpanel" aria-labelledby="subOfficer">
            <table class="table table-striped">
                <thead class="bg-primary text-white">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">رتبة</th>
                        <th scope="col">إسم</th>
                        <th scope="col">رقم عسكري</th>
                        <th scope="col">تخصص</th>
                        <th scope="col">تسكين</th>
                        <th scope="col">تسكين داخلي</th>
                        <th scope="col">ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subOfficers as $subOfficer)                        
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{ $subOfficer->rank->name }}</td>
                            <td><a href="{{ url('person',$subOfficer->id) }}">{{ $subOfficer->name }}</a></td>
                            <td>{{ $subOfficer->military_num }}</td>
                            <td>{{ $subOfficer->speciality->name }}</td>
                            <td>{{ $subOfficer->milUnit->name }}</td>
                            <td>{{ $subOfficer->Unit->name }}</td>
                            <td>{{ $subOfficer->note }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="soliderTab" role="tabpanel" aria-labelledby="soldier">
            <table class="table table-striped">
                <thead class="bg-primary text-white">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">رتبة</th>
                        <th scope="col">إسم</th>
                        <th scope="col">رقم عسكري</th>
                        <th scope="col">تخصص</th>
                        <th scope="col">تسكين</th>
                        <th scope="col">تسكين داخلي</th>
                        <th scope="col">ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($soliders as $solider)                        
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{ $solider->rank->name }}</td>
                            <td><a href="{{ url('person',$solider->id) }}">{{ $solider->name }}</a></td>
                            <td>{{ $solider->military_num }}</td>
                            <td>{{ $solider->speciality->name }}</td>
                            <td>{{ $solider->milUnit->name }}</td>
                            <td>{{ $solider->Unit->name }}</td>
                            <td>{{ $solider->note }}</td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
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
                            <input class="form-check-input" type="radio" name="service" id="notService" value="0" {{ old('service') !== null && old('service') == 0 ?  'checked' : '' }}>
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