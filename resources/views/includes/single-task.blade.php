<div class="card {{$loop->first ? 'mb-3' : ($loop->last? 'mt-3' : 'my-3')}}">
    <div class="card-header py-1 d-flex justify-content-between align-items-center @if($task->status == 'done') alert-success @elseif($task->status == 'active') alert-danger @elseif($task->status == 'pending') alert-warning @endif">
        <div>
            <a href="#" data-toggle="modal" data-target="#deleteTask{{$task->id}}" class="p-2"><img height="15" src="{{ asset('svg/trash.svg') }}" alt=""></a>
            <a href="#" data-toggle="modal" data-target="#editTask{{$task->id}}" class="p-2 ml-1" ><img height="15" src="{{ asset('svg/grey-pencil.svg') }}" alt=""></a>
        </div>
        <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$task->id}}" aria-expanded="true" aria-controls="collapseOne">
                {{$task->title}}
            </button>
        </h5>
    </div>
    <div id="collapse{{$task->id}}" class="collapse">
        <div class="card-body">
            <div style="white-space: pre;">{{$task->desc}}</div>
            @if( $task->status != 'done' )
                <div class="text-left">
                    <form action="{{ route('task-done') }}" method="POST">
                        @csrf
                        <input type="number" name="taskId" value="{{$task->id}}" hidden>
                        <button class="btn btn-sm btn-success d-flex align-items-center">إنتهاء البند <img class="ml-1" height="14" src="{{ asset('svg/white-check.svg') }}" alt=""></button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>

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
            <form action="{{ route('delete-task') }}" method="POST">
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
                <h5 class="modal-title" id="exampleModalLongTitle">تعديل بند</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: -1rem auto -1rem -1rem">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('edit-task') }}" method="POST">
                @csrf
                <input type="number" name="taskId" value="{{$task->id}}" hidden>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control text-right" name="title" value="{{ old('title') && session('error_type') == 'edit task' && old('taskId') == $task->id ? old('title') : $task->title }}">
                        <div class="input-group-append">
                            <span class="input-group-text justify-content-center" style="width: 5.5rem">العنوان</span>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <textarea class="form-control text-right" aria-label="With textarea" name="desc">{{ old('desc') && session('error_type') == 'edit task' && old('taskId') == $task->id ? old('desc') : $task->desc }}</textarea>
                        <div class="input-group-append">
                            <span class="input-group-text" style="width: 5.5rem">الموضوع</span>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="date" class="form-control text-right" name="dueTo" value="{{ old('dueTo') && session('error_type') == 'edit task' && old('taskId') == $task->id ? old('dueTo') : $task->due_to->format('Y-m-d') }}" {{ old('status') && session('error_type') == 'edit task' && old('taskId') == $task->id ? (old('status') == 'active' ? '' : 'disabled') : ($task->status == 'done' || $task->status == 'pending' ? 'disabled' : '' ) }}>
                        <div class="input-group-append">
                            <span class="input-group-text" style="width: 5.5rem">قبل تاريخ</span>
                        </div>
                    </div>
                    
                    <div class="text-right">الحالة</div>
                    <div class="form-check d-flex justify-content-end align-items-center">
                        <input class="form-check-input" type="radio" name="status" id="active" value="active" {{ old('status')  && session('error_type') == 'edit task' && old('taskId') == $task->id ? (old('status') == 'active' ? 'checked' : '') : ($task->status == 'active' ? 'checked' : '') }}>
                        <label class="form-check-label text-muted mr-4" for="active">
                            جاري
                        </label>
                    </div>

                    <div class="form-check d-flex justify-content-end align-items-center">
                        <input class="form-check-input" type="radio" name="status" id="pending" value="pending" {{ old('status') && session('error_type') == 'edit task' && old('taskId') == $task->id ? (old('status') == 'pending' ? 'checked' : '') : ($task->status == 'pending' ? 'checked' : '') }}>
                        <label class="form-check-label text-muted mr-4" for="pending">
                            مُعلق
                        </label>
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