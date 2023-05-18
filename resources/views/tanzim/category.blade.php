@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-start">
        <button class="btn btn-primary d-flex align-items-center" data-toggle="modal" data-target="#addNewTask">
            إضافة بند
            <img class="ml-2" height="16" src="{{ asset('/svg/plus.svg') }}" alt="plus">
        </button>
    </div>

    <div class="card text-right  my-5">
        <div class="card-header text-white bg-primary">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <a href="#" data-toggle="modal" data-target="#deleteCategory" class="p-2"><img height="17" src="{{ asset('svg/white-trash.svg') }}" alt=""></a>
                    <a href="#" class="p-1" data-toggle="modal" data-target="#editCategoryModal">
                        <img height="20" src="{{ asset('svg/white-pencil.svg') }}" alt="">
                    </a>
                </div>
                <div>
                    <div class="h5 m-0">{{ $category->name }}</div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($category->tasks->count())
                @foreach ($category->tasks as $task)
                    <div class="card {{$loop->first ? 'mb-3' : ($loop->last? 'mt-3' : 'my-3')}}">
                        <div class="card-header py-1 d-flex justify-content-between align-items-center @if($task->status == 'done') alert-success @elseif($task->status == 'active') alert-danger @elseif($task->status == 'pending') alert-warning @endif">
                            <div>
                                <a href="#" data-toggle="modal" data-target="#deleteTask{{$task->id}}" class="p-2"><img height="15" src="{{ asset('svg/trash.svg') }}" alt=""></a>
                                <a href="#" data-toggle="modal" data-target="#editTask{{$task->id}}" class="p-2 ml-1 mr-5" ><img height="15" src="{{ asset('svg/grey-pencil.svg') }}" alt=""></a>
                            </div>
                            <h5 class="my-1 text-dark" style="direction: rtl;">
                                {{$task->order}}- {{$task->title}} 
                            </h5>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="my-2 text-center"><b>لا يوجد</b></div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="deleteCategory" tabindex="-1" role="dialog" aria-labelledby="delete category modal" aria-hidden="true">
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

    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="edit category modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header flex-row-reverse">
                    <h5 class="modal-title">تعديل النوع</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: -1rem auto -1rem -1rem">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('edit-category') }}" method="POST">
                    @csrf
                    <input type="number" value="{{$category->id}}" name="categoryId" hidden>

                    <div class="modal-body text-center">
                        <div class="input-group">
                            <input type="text" class="form-control text-right" name="name" value="{{ $category->name }}">
                            <div class="input-group-append">
                                <span class="input-group-text justify-content-center" style="width: 5.5rem">التخصص</span>
                            </div>
                        </div>

                        <div class="alert alert-danger bg-danger text-white mt-4 text-right d-none" id="editCategoryErrorBag">
                            <ul class="list-unstyled m-0" id="editCategoryErrorsList"></ul>
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

    @foreach ($category->tasks as $task)
        <div class="modal fade" id="deleteTask{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="delete task modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header flex-row-reverse">
                        <h5 class="modal-title" id="exampleModalLongTitle">حذف بند</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: -1rem auto -1rem -1rem">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        تأكيد حذف البند
                    </div>
                    <form action="{{ route('delete-category-task') }}" method="POST">
                        @csrf
                        <input type="number" value="{{$task->id}}" name="taskId" hidden>
                        <div class="modal-footer justify-content-start">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            <button class="btn btn-primary">حذف</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editTask{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="edit task modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header flex-row-reverse">
                        <h5 class="modal-title">تعديل البند</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: -1rem auto -1rem -1rem">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{ route('edit-category-task') }}" method="POST">
                        @csrf
                        <input type="number" value="{{$task->id}}" name="taskId" hidden>

                        <div class="modal-body text-center">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control text-right" name="title" value="{{ $task->title }}">
                                <div class="input-group-append">
                                    <span class="input-group-text justify-content-center" style="width: 5.5rem">العنوان</span>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <input type="text" class="form-control text-right" name="desc" value="{{ $task->desc }}">
                                <div class="input-group-append">
                                    <span class="input-group-text justify-content-center" style="width: 5.5rem">الموضوع</span>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <input type="text" class="form-control text-right" name="order" value="{{ $task->order }}">
                                <div class="input-group-append">
                                    <span class="input-group-text justify-content-center" style="width: 5.5rem">الترتيب</span>
                                </div>
                            </div>

                            <div class="alert alert-danger bg-danger text-white mt-4 text-right d-none" id="editTaskErrorBag">
                                <ul class="list-unstyled m-0" id="editTaskErrorsList"></ul>
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

        <div class="modal fade" id="addNewTask" tabindex="-1" role="dialog" aria-labelledby="new task modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header flex-row-reverse">
                        <h5 class="modal-title">إضافة بند</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: -1rem auto -1rem -1rem">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{ route('add-category-task') }}" method="POST">
                        @csrf
                        <input type="number" value="{{$task->id}}" name="taskId" hidden>
                        <input type="number" value="{{$category->id}}" name="categoryId" hidden>

                        <div class="modal-body text-center">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control text-right" name="title" value="{{ session('error_type') == 'add task' ? old('title') : '' }}">
                                <div class="input-group-append">
                                    <span class="input-group-text justify-content-center" style="width: 5.5rem">العنوان</span>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <input type="text" class="form-control text-right" name="desc" value="{{ session('error_type') == 'add task' ? old('desc') : '' }}">
                                <div class="input-group-append">
                                    <span class="input-group-text justify-content-center" style="width: 5.5rem">الموضوع</span>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <input type="text" class="form-control text-right" name="order" value="{{ session('error_type') == 'add task' ? old('order') : '' }}">
                                <div class="input-group-append">
                                    <span class="input-group-text justify-content-center" style="width: 5.5rem">الترتيب</span>
                                </div>
                            </div>

                            <div class="alert alert-danger bg-danger text-white mt-4 text-right d-none" id="addTaskErrorBag">
                                <ul class="list-unstyled m-0" id="addTaskErrorsList"></ul>
                            </div>
                        </div>

                        <div class="modal-footer justify-content-start">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            <button class="btn btn-primary">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('scripts')
    @if ($errors->any() && session('error_type') == 'edit category')
        <script>
            $(document).ready(function(){
                let errors = @json($errors->all());
                let bag = '';
                errors.forEach(error => {
                    bag += `<li>${error}<img height="14" class="ml-3" src="{{ asset('svg/times-circle.svg') }}" alt=""></i></li>`
                });
                $('#editCategoryModal').modal('show');
                $('#editCategoryModal #editCategoryErrorsList').html(bag);
                $('#editCategoryModal #editCategoryErrorBag').removeClass('d-none');

                setTimeout(() => {
                    $('#editCategoryModal #editCategoryErrorBag').addClass('d-none');
                }, 10000);
            })
            @if(session('test'))
                console.log(@json(session('test')));
            @endif
        </script>
    @endif

    @if ($errors->any() && session('error_type') == 'edit task')
        <script>
            $(document).ready(function(){
                let errors = @json($errors->all());
                let bag = '';
                errors.forEach(error => {
                    bag += `<li>${error}<img height="14" class="ml-3" src="{{ asset('svg/times-circle.svg') }}" alt=""></i></li>`
                });
                $('#editTask{{ old('taskId') }}').modal('show');
                $('#editTask{{ old('taskId') }} #editTaskErrorsList').html(bag);
                $('#editTask{{ old('taskId') }} #editTaskErrorBag').removeClass('d-none');

                setTimeout(() => {
                    $('#editTask{{ old('taskId') }} #editTaskErrorBag').addClass('d-none');
                }, 10000);
            })
        </script>
    @endif

    @if ($errors->any() && session('error_type') == 'add task')
        <script>
            $(document).ready(function(){
                let errors = @json($errors->all());
                let bag = '';
                errors.forEach(error => {
                    bag += `<li>${error}<img height="14" class="ml-3" src="{{ asset('svg/times-circle.svg') }}" alt=""></i></li>`
                });
                $('#addNewTask').modal('show');
                $('#addNewTask #addTaskErrorsList').html(bag);
                $('#addNewTask #addTaskErrorBag').removeClass('d-none');

                setTimeout(() => {
                    $('#addNewTask #addTaskErrorBag').addClass('d-none');
                }, 10000);
            })
        </script>
    @endif
@endsection