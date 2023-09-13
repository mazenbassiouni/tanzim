@extends('layouts.app')

@section('styles')
    <style>
        table{
            direction: rtl;
            text-align: center;
        }
        .input-group-text{
            justify-content: center;
        }
    </style>
@endsection

@section('content')
    <div class="d-flex justify-content-between">
        <div class="d-flex">
            <button class="btn btn-primary d-flex align-items-center" data-toggle="modal" data-target="#newPersonModal">
                إضافة ضابط/فرد
                <img class="ml-2" height="16" src="{{ asset('/svg/plus.svg') }}" alt="plus">
            </button>
            <button class="btn btn-primary ml-3 d-flex align-items-center" data-toggle="modal" data-target="#searchPersonModal">
                <img height="15" src="{{ asset('svg/white-search.svg') }}" alt="">
            </button>
        </div>

        <div class="d-flex flex-row-reverse font-weight-bold">
            <div class="ml-5">
                <span>قوة : <span class="text-primary">{{ $tamam['all']['officers'] + $tamam['all']['subOfficers'] + $tamam['all']['soldiers'] }}</span></span>
            </div>
            <div class="ml-5">
                <span>ضباط : <span class="text-primary">{{ $tamam['all']['officers'] }}</span></span>
                @if( $insideAttachedPeople->where('rank_id', '<=', 21)->count() || $insideMissions->where('rank_id', '<=', 21)->count() )
                    <div class="text-success">
                        <span data-toggle="tooltip" 
                            data-html="true" 
                            data-placement="bottom" 
                            title="
                                {{ $insideAttachedPeople->where('rank_id', '<=', 21)->count() ? 'إلحاق: '.$insideAttachedPeople->where('rank_id', '<=', 21)->count().'<br>' : ''  }}
                                {{ $insideMissions->where('rank_id', '<=', 21)->count() ? 'مأمورية عمل: '.$insideMissions->where('rank_id', '<=', 21)->count().'<br>' : ''  }}
                            ">
                            +{{ $insideAttachedPeople->where('rank_id', '<=', 21)->count() + $insideMissions->where('rank_id', '<=', 21)->count() }}
                        </span>
                    </div>
                @endif
            </div>
            <div class="ml-5">
                <span>ضباط الصف : <span class="text-primary">{{ $tamam['all']['subOfficers'] }}</span></span>
                @if( $insideAttachedPeople->where('rank_id', '<', 27)->where('rank_id', '>', 21)->count() || $insideMissions->where('rank_id', '<', 27)->where('rank_id', '>', 21)->count() )
                    <div class="text-success">
                        <span data-toggle="tooltip" 
                            data-html="true" 
                            data-placement="bottom" 
                            title="
                                {{ $insideAttachedPeople->where('rank_id', '<', 27)->where('rank_id', '>', 21)->count() ? 'إلحاق: '.$insideAttachedPeople->where('rank_id', '<', 27)->where('rank_id', '>', 21)->count().'<br>' : ''  }}
                                {{ $insideMissions->where('rank_id', '<', 27)->where('rank_id', '>', 21)->count() ? 'مأمورية عمل: '.$insideMissions->where('rank_id', '<', 27)->where('rank_id', '>', 21)->count().'<br>' : ''  }}
                            ">
                            +{{ $insideAttachedPeople->where('rank_id', '<', 27)->where('rank_id', '>', 21)->count() + $insideMissions->where('rank_id', '<', 27)->where('rank_id', '>', 21)->count() }}
                        </span>
                    </div>
                @endif
            </div>
            <div>
                <span>جنود : <span class="text-primary">{{ $tamam['all']['soldiers'] }}</span></span>
                @if( $insideAttachedPeople->where('rank_id', 27)->count() || $insideMissions->where('rank_id', 27)->count() )
                    <div class="text-success">
                        <span data-toggle="tooltip" 
                            data-html="true" 
                            data-placement="bottom" 
                            title="
                                {{ $insideAttachedPeople->where('rank_id', 27)->count() ? 'إلحاق: '.$insideAttachedPeople->where('rank_id', 27)->count().'<br>' : ''  }}
                                {{ $insideMissions->where('rank_id', 27)->count() ? 'مأمورية عمل: '.$insideMissions->where('rank_id', 27)->count().'<br>' : ''  }}
                            ">
                            +{{ $insideAttachedPeople->where('rank_id', 27)->count() + $insideMissions->where('rank_id', 27)->count() }}
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs flex-row-reverse mt-3" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link" id="officer" data-toggle="tab" href="#officerTab" role="tab" aria-controls="officerTab" aria-selected="true"><b>ضباط</b></a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" id="subOfficer" data-toggle="tab" href="#subOfficerTab" role="tab" aria-controls="subOfficerTab" aria-selected="false"><b>ضباط الصف</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="soldier" data-toggle="tab" href="#soliderTab" role="tab" aria-controls="soliderTab" aria-selected="false"><b>جنود</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="notForce" data-toggle="tab" href="#notForceTab" role="tab" aria-controls="soliderTab" aria-selected="false"><b>شطب</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tamam" data-toggle="tab" href="#tamamTab" role="tab" aria-controls="soliderTab" aria-selected="false"><b>تمام</b></a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade" id="officerTab" role="tabpanel" aria-labelledby="officer">
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
        <div class="tab-pane fade show active" id="subOfficerTab" role="tabpanel" aria-labelledby="subOfficer">
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
        <div class="tab-pane fade" id="notForceTab" role="tabpanel" aria-labelledby="notForce">
            <table class="table table-striped">
                <thead class="bg-primary text-white">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">رتبة</th>
                        <th scope="col">إسم</th>
                        <th scope="col">رقم عسكري</th>
                        <th scope="col">تخصص</th>
                        <th scope="col">تسكين داخلي</th>
                        <th scope="col">تاريخ الشطب</th>
                        <th scope="col">ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notForce as $person)                        
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{ $person->rank->name }}</td>
                            <td><a href="{{ url('person',$person->id) }}">{{ $person->name }}</a></td>
                            <td>{{ $person->military_num }}</td>
                            <td>{{ $person->speciality->name }}</td>
                            <td>{{ $person->unit->name }}</td>
                            <td>{{ $person->deleted_date->format('d/m/Y') }}</td>
                            <td>{{ $person->deleted_desc }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="tamamTab" role="tabpanel" aria-labelledby="tamam">
            <table class="table table-striped table-bordered">
                <thead class="bg-primary text-white">
                    <tr>
                        <th scope="col">الوحدة</th>
                        <th scope="col">قوة</th>
                        <th scope="col">ضباط</th>
                        <th scope="col">أفراد</th>
                        <th scope="col">ضباط الصف</th>
                        <th scope="col">جنود</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">قيادة اللواء</th>
                        <td>{{ $tamam['keyada']['officers'] + $tamam['keyada']['subOfficers'] + $tamam['keyada']['soldiers'] }}</td>
                        <td>{{ $tamam['keyada']['officers'] }}</td>
                        <td>{{ $tamam['keyada']['subOfficers'] + $tamam['keyada']['soldiers'] }}</td>
                        <td>{{ $tamam['keyada']['subOfficers'] }}</td>
                        <td>{{ $tamam['keyada']['soldiers'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">مجموعة 24 صيني</th>
                        <td>{{ $tamam['24']['officers'] + $tamam['24']['subOfficers'] + $tamam['24']['soldiers'] }}</td>
                        <td>{{ $tamam['24']['officers'] }}</td>
                        <td>{{ $tamam['24']['subOfficers'] + $tamam['24']['soldiers'] }}</td>
                        <td>{{ $tamam['24']['subOfficers'] }}</td>
                        <td>{{ $tamam['24']['soldiers'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">مجموعة 205</th>
                        <td>{{ $tamam['205']['officers'] + $tamam['205']['subOfficers'] + $tamam['205']['soldiers'] }}</td>
                        <td>{{ $tamam['205']['officers'] }}</td>
                        <td>{{ $tamam['205']['subOfficers'] + $tamam['205']['soldiers'] }}</td>
                        <td>{{ $tamam['205']['subOfficers'] }}</td>
                        <td>{{ $tamam['205']['soldiers'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">مجموعة رمضان</th>
                        <td>{{ $tamam['ramadan']['officers'] + $tamam['ramadan']['subOfficers'] + $tamam['ramadan']['soldiers'] }}</td>
                        <td>{{ $tamam['ramadan']['officers'] }}</td>
                        <td>{{ $tamam['ramadan']['subOfficers'] + $tamam['ramadan']['soldiers'] }}</td>
                        <td>{{ $tamam['ramadan']['subOfficers'] }}</td>
                        <td>{{ $tamam['ramadan']['soldiers'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">مجموعة سليمان عزت</th>
                        <td>{{ $tamam['fmc']['officers'] + $tamam['fmc']['subOfficers'] + $tamam['fmc']['soldiers'] }}</td>
                        <td>{{ $tamam['fmc']['officers'] }}</td>
                        <td>{{ $tamam['fmc']['subOfficers'] + $tamam['fmc']['soldiers'] }}</td>
                        <td>{{ $tamam['fmc']['subOfficers'] }}</td>
                        <td>{{ $tamam['fmc']['soldiers'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">القاعدة الإدارية</th>
                        <td>{{ $tamam['ka3da']['officers'] + $tamam['ka3da']['subOfficers'] + $tamam['ka3da']['soldiers'] }}</td>
                        <td>{{ $tamam['ka3da']['officers'] }}</td>
                        <td>{{ $tamam['ka3da']['subOfficers'] + $tamam['ka3da']['soldiers'] }}</td>
                        <td>{{ $tamam['ka3da']['subOfficers'] }}</td>
                        <td>{{ $tamam['ka3da']['soldiers'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">إجمالي اللواء</th>
                        <td>{{ 
                            $tamam['keyada']['officers'] + $tamam['keyada']['subOfficers'] + $tamam['keyada']['soldiers']
                            + $tamam['24']['officers'] + $tamam['24']['subOfficers'] + $tamam['24']['soldiers']
                            + $tamam['205']['officers'] + $tamam['205']['subOfficers'] + $tamam['205']['soldiers']
                            + $tamam['ramadan']['officers'] + $tamam['ramadan']['subOfficers'] + $tamam['ramadan']['soldiers']
                            + $tamam['fmc']['officers'] + $tamam['fmc']['subOfficers'] + $tamam['fmc']['soldiers']
                            + $tamam['ka3da']['officers'] + $tamam['ka3da']['subOfficers'] + $tamam['ka3da']['soldiers']
                        }}</td>
                        <td>{{ 
                            $tamam['keyada']['officers']
                            + $tamam['24']['officers']
                            + $tamam['205']['officers']
                            + $tamam['ramadan']['officers']
                            + $tamam['fmc']['officers']
                            + $tamam['ka3da']['officers']
                        }}</td>
                        <td>{{ 
                            $tamam['keyada']['subOfficers'] + $tamam['keyada']['soldiers']
                            + $tamam['24']['subOfficers'] + $tamam['24']['soldiers']
                            + $tamam['205']['subOfficers'] + $tamam['205']['soldiers']
                            + $tamam['ramadan']['subOfficers'] + $tamam['ramadan']['soldiers']
                            + $tamam['fmc']['subOfficers'] + $tamam['fmc']['soldiers']
                            + $tamam['ka3da']['subOfficers'] + $tamam['ka3da']['soldiers']
                        }}</td>
                        <td>{{ 
                            $tamam['keyada']['subOfficers']
                            + $tamam['24']['subOfficers']
                            + $tamam['205']['subOfficers']
                            + $tamam['ramadan']['subOfficers']
                            + $tamam['fmc']['subOfficers']
                            + $tamam['ka3da']['subOfficers']
                        }}</td>
                        <td>{{ 
                            $tamam['keyada']['soldiers']
                            + $tamam['24']['soldiers']
                            + $tamam['205']['soldiers']
                            + $tamam['ramadan']['soldiers']
                            + $tamam['fmc']['soldiers']
                            + $tamam['ka3da']['soldiers']
                        }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="card text-right  my-5">
                <div class="card-header text-white bg-primary">
                    <div>
                        <div class="h5 m-0">
                            إلحاق على الوحدة ({{$insideAttachedPeople->count()}})
                        </div>
                    </div>
                </div>
                <div class="card-body" dir="rtl">
                    @if ($insideAttachedPeople->count())
                        @foreach ($insideAttachedPeople as $person)
                            <div>
                                <span>{{ $loop->iteration .'- ' }}</span>
                                <a href="{{ url('person',$person->id) }}">{{ $person->rank->name.'/ '.$person->name }}</a>
                                @if($person->missions->count() && $person->missions->first()->desc) <span>({{ $person->missions->first()->desc }})</span> @endif
                            </div>
                        @endforeach
                    @else
                        <div>لا يكن</div>
                    @endif
                </div>
            </div>

            <div class="card text-right  my-5">
                <div class="card-header text-white bg-primary">
                    <div>
                        <div class="h5 m-0">
                            إلحاق خارج الوحدة ({{$ousideAttachedPeople->count()}})
                        </div>
                    </div>
                </div>
                <div class="card-body" dir="rtl">
                    @if ($ousideAttachedPeople->count())
                        @foreach ($ousideAttachedPeople as $person)
                            <div>
                                <span>{{ $loop->iteration .'- ' }}</span>
                                <a href="{{ url('person',$person->id) }}">{{ $person->rank->name.'/ '.$person->name }}</a>
                                @if($person->missions->count() && $person->missions->first()->desc) <span>({{ $person->missions->first()->desc }})</span> @endif
                            </div>
                        @endforeach
                    @else
                        <div>لا يكن</div>
                    @endif
                </div>
            </div>

            <div class="card text-right  my-5">
                <div class="card-header text-white bg-primary">
                    <div>
                        <div class="h5 m-0">
                            مأمورية عمل ({{$outsideMissions->count()}})
                        </div>
                    </div>
                </div>
                <div class="card-body" dir="rtl">
                    @if ($outsideMissions->count())
                        @foreach ($outsideMissions as $person)
                            <div>
                                <span>{{ $loop->iteration .'- ' }}</span>
                                <a href="{{ url('person',$person->id) }}">{{ $person->rank->name.'/ '.$person->name }}</a>
                                @if($person->missions->count() && $person->missions->first()->desc) <span>({{ $person->missions->first()->desc }})</span> @endif
                            </div>
                        @endforeach
                    @else
                        <div>لا يكن</div>
                    @endif
                </div>
            </div>

            <div class="card text-right  my-5">
                <div class="card-header text-white bg-primary">
                    <div>
                        <div class="h5 m-0">
                            مأمورية عمل طرفنا ({{$insideMissions->count()}})
                        </div>
                    </div>
                </div>
                <div class="card-body" dir="rtl">
                    @if ($insideMissions->count())
                        @foreach ($insideMissions as $person)
                            <div>
                                <span>{{ $loop->iteration .'- ' }}</span>
                                <a href="{{ url('person',$person->id) }}">{{ $person->rank->name.'/ '.$person->name }}</a>
                                @if($person->missions->count() && $person->missions->first()->desc) <span>({{ $person->missions->first()->desc }})</span> @endif
                            </div>
                        @endforeach
                    @else
                        <div>لا يكن</div>
                    @endif
                </div>
            </div>
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
                            <select id="rankId" name="rankId" class="form-select form-control text-right" aria-label="Default select example" style="direction: rtl">
                                <option value=""></option>
                                @foreach ($ranks as $rank)
                                    <option value="{{ $rank->id }}"  {{ old('rankId') == $rank->id ? 'selected' : '' }}>{{ $rank->name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 7rem">رتبة/درجة</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control text-right" name="name" value="{{ old('name') }}">
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 7rem">الإسم</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input class="form-control text-right" name="militaryNum" value="{{ old('militaryNum') }}">
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 7rem">رقم عسكري</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input class="form-control text-right" name="seniorityNum" value="{{ old('seniorityNum') }}">
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 7rem">رقم أقدمية</span>
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
                                <span class="input-group-text justify-content-center" style="width: 7rem">التخصص</span>
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
                                <span class="input-group-text justify-content-center" style="width: 7rem">تسكين</span>
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
                                <span class="input-group-text justify-content-center" style="width: 7rem">تسكين داخلي</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <select name="medicalState" class="form-select form-control text-right" aria-label="Default select example" style="direction: rtl">
                                <option value="1"  {{ old('medicalState') == "1" ? 'selected' : '' }}>لائق</option>
                                <option value="0"  {{ old('medicalState') == "0" ? 'selected' : '' }}>غير لائق</option>
                                <option value="2"  {{ old('medicalState') == "2" ? 'selected' : '' }}>لائق مستوى ادنى</option>
                            </select>
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 7rem">الموقف الطبي</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input id="medicalCause" type="text" class="form-control text-right" name="medicalCause" value="{{ old('medicalCause') }}" {{ old('medicalState') == 1 ? 'disabled' : ( old('medicalState') === null ? 'disabled' : '' ) }}>
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 7rem">السبب</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input id="layOffDate" type="date" class="form-control text-right" name="layOffDate" value="{{ old('layOffDate') }}" {{ old('rankId') === null || old('rankId') != 27 ? 'disabled' : ''  }}>
                            <div class="input-group-append">
                                <span class="input-group-text" style="width: 7rem">تاريخ التسريح</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control text-right" name="note" value="{{ old('note') }}">
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 7rem">ملاحظات عامة</span>
                            </div>
                        </div>

                        <div class="text-right mb-1">بيانات الضم</div>
                        <div class="input-group mb-3">
                            <input type="date" class="form-control text-right" name="joinDate" value="{{ old('joinDate') }}">
                            <div class="input-group-append">
                                <span class="input-group-text" style="width: 7rem">تاريخ الضم</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control text-right" name="joinDesc" value="{{ old('joinDesc') }}">
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 7rem">ملاحظات</span>
                            </div>
                        </div>

                        <div class="text-right">تم الشطب</div>
                        <div class="form-check d-flex justify-content-end align-items-center">
                            <input class="form-check-input" type="radio" name="isForce" id="notActive" value="0" {{ old('isForce') !== null && old('isForce') == 0 ?  'checked' : '' }}>
                            <label class="form-check-label text-muted mr-4" for="notActive">
                                نعم
                            </label>
                        </div>
                        <div class="form-check d-flex justify-content-end align-items-center">
                            <input class="form-check-input" type="radio" name="isForce" id="active" value="1" {{ old('isForce') == 1 || old('isForce') === null ?  'checked' : '' }}>
                            <label class="form-check-label text-muted mr-4" for="active">
                                لا
                            </label>
                        </div>

                        <div class="text-right mb-1">بيانات الشطب</div>
                        <div class="input-group mb-3">
                            <input type="date" class="form-control text-right" id="deletedDate" name="deletedDate" value="{{ old('deletedDate') }}" {{old('isForce') === null || old('isForce') == 1 ? 'disabled' : '' }}>
                            <div class="input-group-append">
                                <span class="input-group-text" style="width: 7rem">تاريخ الشطب</span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control text-right" id="deletedDesc" name="deletedDesc" value="{{ old('deletedDesc') }}" {{old('isForce') === null || old('isForce') == 1 ? 'disabled' : '' }}>
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 7rem">ملاحظات</span>
                            </div>
                        </div>

                        {{-- <div class="text-right">موقف الخدمة</div>
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
                        </div> --}}

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

    <div class="modal fade" id="searchPersonModal" tabindex="-1" role="dialog" aria-labelledby="search person modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header flex-row-reverse">
                    <h5 class="modal-title">بحث عن ضابط/فرد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: -1rem auto -1rem -1rem">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <select id="rankIdSearch" class="form-select form-control text-right" style="direction: rtl">
                            <option value=""></option>
                            @foreach ($ranks as $rank)
                                <option value="{{ $rank->id }}"  {{ old('rankId') == $rank->id ? 'selected' : '' }}>{{ $rank->name }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <span class="input-group-text justify-content-center">رتبة/درجة</span>
                        </div>
                    </div>
                    <div class="input-group mb-3 search-input-group">
                        <input class="form-control text-right" placeholder="بحث" id="personSearch" autocomplete="off">
                        <div class="input-group-append">
                            <span class="input-group-text" style="width: 5.5rem; justify-content:center;"><img height="15" src="{{ asset('svg/search.svg') }}" alt=""></span>
                        </div>
                        <div id="search-result-wrapper" class="d-none">
                            <div class="mid p-3"><img height="20" src="{{ asset('gif/loader.gif') }}" alt=""></div>
                        </div>
                    </div>
                </div>
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

    <script>
        document.querySelectorAll('input[name="isForce"]').forEach( $item =>{
            $item.addEventListener('change', e=>{
                if(e.target.value == 1){
                    deletedDesc.disabled = true;
                    deletedDate.disabled = true;
                }else{
                    deletedDesc.disabled = false;
                    deletedDate.disabled = false;
                }
            })
        })

        document.querySelector('#rankId').addEventListener('change', e=>{
            if(e.target.value == 27){
                    layOffDate.disabled = false;
                }else{
                    layOffDate.disabled = true;
                }
        })

        document.querySelector('select[name="medicalState"]').addEventListener('change', e=>{
            if(e.target.value == 1){
                    medicalCause.disabled = true;
                }else{
                    medicalCause.disabled = false;
                }
        })
    </script>

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
                const resObj = await fetch('{{ route('person-search') }}?search='+s+'&rank='+rankIdSearch.value);
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
                            window.location.href = `/person/${one.id}`;
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
                const resObj = await fetch('{{ route('person-search') }}?search='+s+'&rank='+rankIdSearch.value);
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
                            window.location.href = `/person/${one.id}`;
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
    
    $('#searchPersonModal').on('shown.bs.modal', () => {
        personSearch.focus();
    })

    rankIdSearch.addEventListener('change', () => {
        personSearch.focus();
    })
</script>
@endsection