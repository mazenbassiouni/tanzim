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
                        <input class="form-control text-right" placeholder="بحث" id="personSearch" autocomplete="off">
                        <div class="input-group-append">
                            <span class="input-group-text" style="width: 5.5rem; justify-content:center;"><img height="15" src="{{ asset('svg/search.svg') }}" alt=""></span>
                        </div>
                        <div id="search-result-wrapper" class="d-none" style="z-index: 999">
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
                                    @elseif(request()->route()->named('show-person'))
                                        <li>
                                            <div class="d-flex justify-content-between">
                                                <span>{{ $person->rank->name .'/ '. $person->name }}</span>
                                                <span class="close d-flex align-items-center" data-id="{{ $person->id }}" style="font-size: 1rem;">x</span>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <input name="peopleId" hidden id="peopleId" value="{{ old('peopleId') ? old('peopleId') : ((request()->route()->named('show-person') ? "[$person->id]" : '[]')) }}">

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