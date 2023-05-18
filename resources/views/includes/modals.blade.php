@if (!request()->route()->named('show-mission') && !request()->route()->named('force') && !request()->route()->named('missions-settings') && !request()->route()->named('show-category'))
    @include('includes.new-mission-modal')
@endif