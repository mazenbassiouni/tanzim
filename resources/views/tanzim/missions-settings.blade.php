@extends('layouts.app')

@section('content')

    <h3 class="h3 text-center">الإعدادات</h3>

    <div class="d-flex justify-content-start">
        <button class="btn btn-primary d-flex align-items-center" data-toggle="modal" data-target="#newSpecialityModal">
            إضافة تخصص
            <img class="ml-2" height="16" src="{{ asset('/svg/plus.svg') }}" alt="plus">
        </button>
        <button class="btn btn-primary d-flex align-items-center ml-3" data-toggle="modal" data-target="#newCategoryModal">
            إضافة نوع تكليف
            <img class="ml-2" height="16" src="{{ asset('/svg/plus.svg') }}" alt="plus">
        </button>
    </div>

    <ul class="nav nav-tabs flex-row-reverse mt-3" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ session('error_type') != 'edit speciality' ? 'active' : '' }}" data-toggle="tab" href="#categoriesTab" role="tab"><b>أنواع التكاليف</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ session('error_type') == 'edit speciality' ? 'active' : '' }}" data-toggle="tab" href="#specialitiesTab" role="tab"><b>تخصصات</b></a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade {{ session('error_type') != 'edit speciality' ? 'show active' : '' }}" id="categoriesTab" role="tabpanel" aria-labelledby="categories">
            <div class="card-body" id="categoriesAccordion">
                @if($categories->count())
                    @foreach ($categories as $category)
                        <div class="card {{$loop->first ? 'mb-3' : ($loop->last? 'mt-3' : 'my-3')}}">
                            <div class="card-header py-1 d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="#" data-toggle="modal" data-target="#deleteCategory{{$category->id}}" class="p-2"><img height="20" src="{{ asset('svg/trash.svg') }}" alt=""></a>
                                    <a href="{{ url('category', $category->id) }}" class="p-2 ml-1 mr-5"><img height="15" src="{{ asset('svg/eye.svg') }}" alt=""></a>
                                </div>
                                <h5 class="mb-0">
                                    <a>
                                        <button style="text-decoration:none" class="btn btn-link" data-toggle="collapse" data-target="#collapseCategory{{$category->id}}" aria-expanded="true" aria-controls="collapseOne">
                                            <b>{{ $category->name }}</b>
                                        </button>
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseCategory{{$category->id}}" class="collapse" data-parent="#categoriesAccordion">
                                <div class="card-body">
                                    @if ($category->tasks->count())
                                        <ul style="direction: rtl;">
                                            @foreach( $category->tasks as $task )
                                                <li class="py-2 text-right">
                                                        <b>{{$task->title}} ({{ $task->order }})</b>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else    
                                        <div class="text-center"><b>لا يوجد بنود</b></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center mt-5 pt-5"><b>لا يكن</b></div>
                @endif
            </div>
        </div>

        <div class="tab-pane fade {{ session('error_type') == 'edit speciality' ? 'show active' : '' }}" id="specialitiesTab" role="tabpanel" aria-labelledby="specialities">
            <div class="card-body" id="specialitiesAccordion">
                @if($specialities->count())
                    @foreach ($specialities as $speciality)
                        <div class="card {{$loop->first ? 'mb-3' : ($loop->last? 'mt-3' : 'my-3')}}">
                            <div class="card-header py-1 d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="#" data-toggle="modal" data-target="#deleteSpeciality{{$speciality->id}}" class="p-2"><img height="20" src="{{ asset('svg/trash.svg') }}" alt=""></a>
                                    <a href="#" data-toggle="modal" data-target="#editSpeciality{{$speciality->id}}" class="p-2 ml-1 mr-5" ><img height="15" src="{{ asset('svg/grey-pencil.svg') }}" alt=""></a>
                                </div>
                                <h6 class="mb-0 py-1">
                                    <b>{{ $speciality->name }}</b>
                                </h6>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center mt-5 pt-5"><b>لا يكن</b></div>
                @endif
            </div>
        </div>
    </div>

    @foreach ($categories as $category)
        <div class="modal fade" id="deleteCategory{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="delete category modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header flex-row-reverse">
                        <h5 class="modal-title">حذف نوع تكليف</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: -1rem auto -1rem -1rem">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        تأكيد حذف نوع التكليف
                    </div>
                    <form action="{{ route('delete-category') }}" method="POST">
                        @csrf
                        <input type="number" value="{{$category->id}}" name="categoryId" hidden>
                        <div class="modal-footer justify-content-start">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            <button class="btn btn-primary">حذف</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($specialities as $speciality)
        <div class="modal fade" id="deleteSpeciality{{$speciality->id}}" tabindex="-1" role="dialog" aria-labelledby="delete speciality modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header flex-row-reverse">
                        <h5 class="modal-title">حذف تخصص</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: -1rem auto -1rem -1rem">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        تأكيد حذف التخصص
                    </div>
                    <form action="{{ route('delete-speciality') }}" method="POST">
                        @csrf
                        <input type="number" value="{{$speciality->id}}" name="specialityId" hidden>
                        <div class="modal-footer justify-content-start">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            <button class="btn btn-primary">حذف</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editSpeciality{{$speciality->id}}" tabindex="-1" role="dialog" aria-labelledby="edit speciality modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header flex-row-reverse">
                        <h5 class="modal-title">تعديل التخصص</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: -1rem auto -1rem -1rem">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{ route('edit-speciality') }}" method="POST">
                        @csrf
                        <input type="number" value="{{$speciality->id}}" name="specialityId" hidden>

                        <div class="modal-body text-center">
                            <div class="input-group">
                                <input type="text" class="form-control text-right" name="name" value="{{ $speciality->name }}">
                                <div class="input-group-append">
                                    <span class="input-group-text justify-content-center" style="width: 5.5rem">التخصص</span>
                                </div>
                            </div>

                            <div class="alert alert-danger bg-danger text-white mt-4 text-right d-none" id="editSpecialityErrorBag">
                                <ul class="list-unstyled m-0" id="editSpecialityErrorsList"></ul>
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
    @endforeach

    <div class="modal fade" id="newSpecialityModal" tabindex="-1" role="dialog" aria-labelledby="add speciality modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header flex-row-reverse">
                    <h5 class="modal-title">تخصص جديد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: -1rem auto -1rem -1rem">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('add-speciality') }}" method="POST">
                    @csrf
                    <div class="modal-body text-center">
                        <div class="input-group">
                            <input type="text" class="form-control text-right" name="name">
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">التخصص</span>
                            </div>
                        </div>

                        <div class="alert alert-danger bg-danger text-white mt-4 text-right d-none" id="addSpecialityErrorBag">
                            <ul class="list-unstyled m-0" id="addSpecialityErrorsList"></ul>
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

    <div class="modal fade" id="newCategoryModal" tabindex="-1" role="dialog" aria-labelledby="add category modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header flex-row-reverse">
                    <h5 class="modal-title">نوع تكليف جديد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: -1rem auto -1rem -1rem">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('add-category') }}" method="POST">
                    @csrf
                    <div class="modal-body text-center">
                        <div class="input-group">
                            <input type="text" class="form-control text-right" name="name">
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">النوع</span>
                            </div>
                        </div>

                        <div class="alert alert-danger bg-danger text-white mt-4 text-right d-none" id="addCategoryErrorBag">
                            <ul class="list-unstyled m-0" id="addCategoryErrorsList"></ul>
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
    @if ($errors->any() && session('error_type') == 'edit speciality' && old('specialityId') )
        <script>
            $(document).ready(function(){
                let errors = @json($errors->all());
                let bag = '';
                errors.forEach(error => {
                    bag += `<li>${error}<img height="14" class="ml-3" src="{{ asset('svg/times-circle.svg') }}" alt=""></i></li>`
                });
                $('#editSpeciality{{old('specialityId')}}').modal('show');
                $('#editSpeciality{{old('specialityId')}} #editSpecialityErrorsList').html(bag);
                $('#editSpeciality{{old('specialityId')}} #editSpecialityErrorBag').removeClass('d-none');

                setTimeout(() => {
                    $('#editSpeciality{{old('specialityId')}} #editSpecialityErrorBag').addClass('d-none');
                }, 10000);
            })
            @if(session('test'))
                console.log(@json(session('test')));
            @endif
        </script>
    @endif

    @if ($errors->any() && session('error_type') == 'add speciality')
        <script>
            $(document).ready(function(){
                let errors = @json($errors->all());
                let bag = '';
                errors.forEach(error => {
                    bag += `<li>${error}<img height="14" class="ml-3" src="{{ asset('svg/times-circle.svg') }}" alt=""></i></li>`
                });
                $('#newSpecialityModal').modal('show');
                $('#newSpecialityModal #addSpecialityErrorsList').html(bag);
                $('#newSpecialityModal #addSpecialityErrorBag').removeClass('d-none');

                setTimeout(() => {
                    $('#newSpecialityModal #addSpecialityErrorBag').addClass('d-none');
                }, 10000);
            })
            @if(session('test'))
                console.log(@json(session('test')));
            @endif
        </script>
    @endif

    @if ($errors->any() && session('error_type') == 'add category')
        <script>
            $(document).ready(function(){
                let errors = @json($errors->all());
                let bag = '';
                errors.forEach(error => {
                    bag += `<li>${error}<img height="14" class="ml-3" src="{{ asset('svg/times-circle.svg') }}" alt=""></i></li>`
                });
                $('#newCategoryModal').modal('show');
                $('#newCategoryModal #addCategoryErrorsList').html(bag);
                $('#newCategoryModal #addCategoryErrorBag').removeClass('d-none');

                setTimeout(() => {
                    $('#newCategoryModal #addCategoryErrorBag').addClass('d-none');
                }, 10000);
            })
            @if(session('test'))
                console.log(@json(session('test')));
            @endif
        </script>
    @endif
@endsection