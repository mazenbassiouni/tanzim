<div class="card {{$loop->first ? 'mb-3' : ($loop->last? 'mt-3' : 'my-3')}}">
    <div class="card-header py-1 d-flex justify-content-between align-items-center">
        <div>
            <a href="#" data-toggle="modal" data-target="#deleteMission{{$mission->id}}" class="p-2"><img height="15" src="{{ asset('svg/trash.svg') }}" alt=""></a>
            <a href="{{ url('mission', $mission->id) }}" class="p-2 ml-1"><img height="15" src="{{ asset('svg/eye.svg') }}" alt=""></a>
        </div>
        <h5 class="mb-0">
            <a data-toggle="tooltip" data-placement="top" title="{{$mission->desc}}">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$mission->id}}" aria-expanded="true" aria-controls="collapseOne">
                    <b>{{$mission->title}}</b>
                </button>
            </a>
        </h5>
    </div>
    <div id="collapse{{$mission->id}}" class="collapse" data-parent="#missionsAccordion">
        <div class="card-body">
            <ul style="direction: rtl;">
                @foreach( $mission->tasks as $task )
                    <li class="py-2 @if($task->status == 'done') text-success @elseif($task->status == 'active') text-danger @elseif($task->status == 'pending') text-warning @endif">
                        <div class="d-flex justify-content-between">
                            <b data-toggle="tooltip" data-placement="top" title="{{$task->desc}}" style="cursor: pointer">
                                {{$task->title}}
                            </b>
                            @if ($task->status == 'active')                                    
                                <b>{{ $task->due_to->locale('ar')->isoFormat('dddd, DD/MM/OY') }}</b>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
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