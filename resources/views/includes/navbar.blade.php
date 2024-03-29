<nav class="navbar navbar-expand-lg navbar-dark bg-primary flex-row-reverse">
    <a class="navbar-brand" href="/"><b class="h3">تنظيم و إدارة</b></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav flex-row-reverse ml-auto mr-5">
        <li class="nav-item {{ request()->route()->named('missions') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('missions') }}">التكاليف</a>
        </li>

        <li class="nav-item {{ request()->route()->named('force') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('force') }}">قوة</a>
        </li>
        
        <li class="nav-item {{ request()->route()->named('councils') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('councils') }}">مجلس طبي</a>
        </li>

        <li class="nav-item {{ request()->route()->named('injuries') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('injuries') }}">إصابات</a>
        </li>

        <li class="nav-item {{ request()->route()->named('cards') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('cards') }}">بطاقات علاجية</a>
        </li>

        <li class="nav-item {{ request()->route()->named('squads') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('squads') }}">فرق</a>
        </li>

        <li class="nav-item {{ request()->route()->named('end-services') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('end-services') }}">إنهاء خدمة</a>
        </li>

        <li class="nav-item {{ request()->route()->named('investigations') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('investigations') }}">قضايا</a>
        </li>

        <li class="nav-item {{ request()->route()->named('attachments') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('attachments') }}">إلحاقات</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            مجمع التكاليف
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @foreach (App\Models\Category::all() as $cat)  
              <a class="dropdown-item {{ request()->route()->named('show-category-mission') && request()->id == $cat->id ? 'active' : '' }}" href="{{ route('show-category-mission', $cat->id) }}">{{ $cat->name }}</a>
            @endforeach
            <div class="dropdown-divider"></div>
            <a class="dropdown-item {{ request()->route()->named('missions-settings') ? 'active' : '' }}" href="{{ route('missions-settings') }}">إعدادات</a>
          </div>
        </li>

      </ul>
    </div>
  </nav>