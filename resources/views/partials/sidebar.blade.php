<nav class="col-md-2 sidebar">
    <div class="user-box text-center pt-3">
        <div class="user-img">
            <img src="{{ auth()->user()->present()->avatar }}"
                 width="90"
                 height="90"
                 alt="user-img"
                 class="rounded-circle img-thumbnail img-responsive">
        </div>
        <h5 class="my-3">
            <a href="{{ route('profile') }}">{{ auth()->user()->present()->nameOrEmail }}</a>
        </h5>
    </div>

    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/') ? 'active' : ''  }}" href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i>
                    <span>@lang('app.dashboard')</span>
                </a>
            </li>
            
            @permission('results.manage')
            <li class="nav-item">
                <a class="nav-link {{ Request::is('result*') ? 'active' : ''  }}" href="{{ route('result.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Results</span>
                </a>
            </li>
            @endpermission
            
            @permission('hostel.manage')
            <li class="nav-item">
                <a class="nav-link {{ Request::is('hostel*') ? 'active' : ''  }}" href="{{ route('hostel.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Hostel</span>
                </a>
            </li>
            @endpermission
            
            @permission('library.manage')
            <li class="nav-item">
                <a class="nav-link {{ Request::is('library*') ? 'active' : ''  }}" href="{{ route('library.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Books</span>
                </a>
            </li>
            @endpermission
            
            @permission('registration.manage')
            <li class="nav-item">
                <a class="nav-link {{ Request::is('registration*') ? 'active' : ''  }}" href="{{ route('registration.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Registration</span>
                </a>
            </li>
            @endpermission
            
            @permission('income.manage')
            <li class="nav-item">
                <a class="nav-link {{ Request::is('finance*') ? 'active' : ''  }}" href="{{ route('finance.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Record Receipt</span>
                </a>
            </li>
            @endpermission

            @permission('users.manage')
            <li class="nav-item">
                <a class="nav-link {{ Request::is('user*') ? 'active' : ''  }}" href="{{ route('user.list') }}">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
            @endpermission

            @permission('department.manage')
            <li class="nav-item">
                <a class="nav-link {{ Request::is('department*') ? 'active' : ''  }}" href="{{ route('department.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Departments</span>
                </a>
            </li>
            @endpermission

            @permission('option.manage')
            <li class="nav-item">
                <a class="nav-link {{ Request::is('option*') ? 'active' : ''  }}" href="{{ route('option.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Options</span>
                </a>
            </li>
            @endpermission

            @permission('tracking.request.manage')
            <li class="nav-item">
                <a class="nav-link {{ Request::is('tracking*') ? 'active' : ''  }}" href="{{ route('student.clearance.request.track') }}">
                    <i class="fas fa-map"></i>
                    <span>Tracking</span>
                </a>
            </li>
            @endpermission

            @permission(['roles.manage', 'permissions.manage'])
            <li class="nav-item">
                <a href="#roles-dropdown"
                   class="nav-link"
                   data-toggle="collapse"
                   aria-expanded="{{ Request::is('role*') || Request::is('permission*') ? 'true' : 'false' }}">
                    <i class="fas fa-users-cog"></i>
                    <span>@lang('app.roles_and_permissions')</span>
                </a>
                <ul class="{{ Request::is('role*') || Request::is('permission*') ? '' : 'collapse' }} list-unstyled sub-menu" id="roles-dropdown">
                    @permission('roles.manage')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('role*') ? 'active' : '' }}"
                           href="{{ route('role.index') }}">@lang('app.roles')</a>
                    </li>
                    @endpermission
                    @permission('permissions.manage')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('permission*') ? 'active' : '' }}"
                           href="{{ route('permission.index') }}">@lang('app.permissions')</a>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission

            @permission(['settings.general', 'settings.auth', 'settings.notifications'], false)
            <li class="nav-item">
                <a href="#settings-dropdown"
                   class="nav-link"
                   data-toggle="collapse"
                   aria-expanded="{{ Request::is('settings*') ? 'true' : 'false' }}">
                    <i class="fas fa-cogs"></i>
                    <span>@lang('app.settings')</span>
                </a>
                <ul class="{{ Request::is('settings*') ? '' : 'collapse' }} list-unstyled sub-menu"
                    id="settings-dropdown">

                    @permission('settings.general')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('settings') ? 'active' : ''  }}"
                           href="{{ route('settings.general') }}">
                            @lang('app.general')
                        </a>
                    </li>
                    @endpermission

                    @permission('settings.auth')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('settings/auth*') ? 'active' : ''  }}"
                           href="{{ route('settings.auth') }}">@lang('app.auth_and_registration')</a>
                    </li>
                    @endpermission

                    @permission('settings.notifications')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('settings/notifications*') ? 'active' : ''  }}"
                           href="{{ route('settings.notifications') }}">@lang('app.notifications')</a>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission
        </ul>
    </div>
</nav>

