<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="/" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{Theme::url('assets/images/logo-sm.png')}}" alt="@setting('core::site-name')"
                                 height="22">
                        </span>
                    <span class="logo-lg">
                            <img src="{{Theme::url('assets/images/logo-dark.png')}}" alt="@setting('core::site-name')"
                                 height="20">
                        </span>
                </a>

                <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{Theme::url('assets/images/logo-sm.png')}}" alt="@setting('core::site-name')"
                                 height="22">
                        </span>
                    <span class="logo-lg">
                            <img src="{{Theme::url('assets/images/logo-light.png')}}" alt="@setting('core::site-name')"
                                 height="20">
                        </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="mdi mdi-menu"></i>
            </button>


            <!--            <div class="topbar-social-icon me-3 d-none d-md-block">
                            <ul class="list-inline title-tooltip m-0">
                                <li class="list-inline-item">
                                    <a href="email-inbox.html" data-bs-toggle="tooltip" data-placement="top" title="Email">
                                        <i class="mdi mdi-email-outline"></i>
                                    </a>
                                </li>

                                <li class="list-inline-item">
                                    <a href="chat.html" data-bs-toggle="tooltip" data-placement="top" title="Chat">
                                        <i class="mdi mdi-tooltip-outline"></i>
                                    </a>
                                </li>

                                <li class="list-inline-item">
                                    <a href="calendar.html" data-bs-toggle="tooltip" data-placement="top" title="Calendar">
                                        <i class="mdi mdi-calendar"></i>
                                    </a>
                                </li>

                                <li class="list-inline-item">
                                    <a href="pages-invoice.html" data-bs-toggle="tooltip" data-placement="top" title="Printer">
                                        <i class="mdi mdi-printer"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>-->

        </div>

        <!--        &lt;!&ndash; Search input &ndash;&gt;
                <div class="search-wrap" id="search-wrap">
                    <div class="search-bar">
                        <input class="search-input form-control" placeholder="Search" />
                        <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                            <i class="mdi mdi-close-circle"></i>
                        </a>
                    </div>
                </div>-->

        <div class="d-flex">
            <!--            <div class="dropdown d-none d-lg-inline-block">
                            <button type="button" class="btn header-item toggle-search noti-icon waves-effect" data-target="#search-wrap">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                        </div>-->
            @if(count(LaravelLocalization::getSupportedLocales())>1)
                <div class="dropdown d-none d-md-block ms-2">
                    <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <img class="me-2" src="assets/images/flags/{{LaravelLocalization::getCurrentLocale()  }}.jpg"
                             alt="Header Language" height="16"> {{ LaravelLocalization::getCurrentLocaleName()  }} <span
                            class="mdi mdi-chevron-down"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <!-- item-->
                            <a href="{{LaravelLocalization::getLocalizedURL($localeCode) }}"
                               class="dropdown-item notify-item {{ App::getLocale() == $localeCode ? 'active' : '' }}"
                               rel="alternate" lang="{{$localeCode}}">
                                <img src="assets/images/flags/{{$localeCode}}.jpg" alt="lang-{{$localeCode}}"
                                     class="me-1" height="12"> <span
                                    class="align-middle"> {!! $properties['native'] !!} </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="mdi mdi-fullscreen"></i>
                </button>
            </div>
            @if (is_module_enabled('Notification'))
                @include('notification.notifications')
            @endif
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{$user->present()->gravatar()}}"
                         alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1">
                        @if ($user->first_name != ' ')
                            {{ $user->first_name }}
                        @else
                            <em>{{trans('core::core.general.complete your profile')}}.</em>
                        @endif</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('admin.account.profile.edit') }}"><i
                            class="mdi mdi-account-circle-outline font-size-16 align-middle me-1"></i> {{ trans('core::core.general.profile') }}
                    </a>
                    <!--                    <a class="dropdown-item" href="#"><i class="mdi mdi-wallet-outline font-size-16 align-middle me-1"></i> My Wallet</a>-->
                    <a class="dropdown-item d-block" href="{{route('admin.setting.settings.index')}}"><i
                            class="mdi mdi-cog-outline font-size-16 align-middle me-1"></i>
                        {{trans('setting::settings.title.settings')}}</a>
                    <!--                    <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline font-size-16 align-middle me-1"></i> Lock screen</a>-->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"><i
                            class="mdi mdi-power font-size-16 align-middle me-1 text-danger"></i> {{ trans('core::core.general.sign out') }}
                    </a>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="mdi mdi-cog-outline font-size-20"></i>
                </button>
            </div>

        </div>
    </div>
</header>


{{--<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="navbar-btn sidebar-toggle" data-toggle="push-menu" role="button" style="margin: 0;">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </a>

    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <?php if (is_module_enabled('Notification')): ?>
            @include('notification::partials.notifications')
            <?php endif; ?>
            <li>
                <a href="" class="publicUrl" style="display: none">
                    <i class="fa fa-eye"></i> {{ trans('page::pages.view-page') }}
        </a>
</li>
<li><a href="{{ url('/') }}"><i class="fa fa-eye"></i> {{ trans('core::core.general.view website') }}</a>
</li>
@if(count(LaravelLocalization::getSupportedLocales())>1)
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-flag"></i>
        <span>
                        {{ LaravelLocalization::getCurrentLocaleName()  }}
            <i class="caret"></i>
                    </span>
    </a>
    <ul class="dropdown-menu language-menu">
      @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <li class="{{ App::getLocale() == $localeCode ? 'active' : '' }}">
            <a rel="alternate" lang="{{$localeCode}}"
               href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
              {!! $properties['native'] !!}
            </a>
        </li>
      @endforeach
    </ul>
</li>
@endif
        <!-- User Account: style can be found in dropdown.less -->
<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="glyphicon glyphicon-user"></i>
        <span>
                        <?php if ($user->present()->fullname() != ' '): ?>
                        {{ $user->present()->fullName() }}
                        <?php else: ?>
            <em>{{trans('core::core.general.complete your profile')}}.</em>
            <?php endif; ?>
            <i class="caret"></i>
                    </span>
    </a>
    <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header bg-light-blue">
            <img src="{{ $user->present()->gravatar() }}" class="img-circle" alt="User Image"/>
            <p>
                <?php if ($user->present()->fullname() != ' '): ?>
                {{ $user->present()->fullname() }}
                <?php else: ?>
                <em>{{trans('core::core.general.complete your profile')}}.</em>
                <?php endif; ?>
            </p>
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-left">
                <a href="{{ route('admin.account.profile.edit') }}" class="btn btn-default btn-flat">
                  {{ trans('core::core.general.profile') }}
                </a>
            </div>
            <div class="pull-right">
                <a href="{{ route('logout') }}" class="btn btn-danger btn-flat">
                  {{ trans('core::core.general.sign out') }}
                </a>
            </div>
        </li>
    </ul>
</li>
</ul>
</div>
</nav>--}}
