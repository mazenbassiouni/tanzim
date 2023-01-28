@if (!request()->route()->named('show-mission') && !request()->route()->named('force'))
    @include('includes.new-mission-modal')
@endif