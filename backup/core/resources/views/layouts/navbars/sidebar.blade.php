<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">{{ __(' ') }}</a>
            <a href="#" class="simple-text logo-normal">{{ __('Algo Sea Biz') }}</a>
        </div>
        <ul class="nav">
            <li @if ($pageSlug == 'dashboard') class="active " @endif>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'clients') class="active " @endif>
                <a data-toggle="collapse" href="#clients" aria-expanded="true">
                    <i class="fa fa-user"></i>
                    <span class="nav-link-text">{{ __('Clients') }}</span>
                    <b class="caret mt-1"></b>
                </a>
            </li>
            <div class="collapse {{ $pageSlug == 'clients' ? 'show' : false }}" id="clients">
                <ul class="nav pl-4">
                    <li @if (isset($activePage)) class="{{ $activePage == 'ClientIndex' ? 'active' : false }}" @endif>

                        <a href="{{ route('client.index') }}">
                            <i class="tim-icons icon-single-02"></i>
                            <p>{{ __('Client List') }}</p>
                        </a>
                    </li>
                    <li @if (isset($activePage)) class="{{ $activePage == 'ClientForm' ? 'active' : false }}" @endif>
                        <a href="{{ route('client.create') }}">
                            <i class="tim-icons icon-simple-add"></i>
                            <p>{{ __('Add New Client') }}</p>
                        </a>
                    </li>
                </ul>
            </div>

            <li @if ($pageSlug == 'organizations') class="active " @endif>
                <a href="{{ route('organization.edit',1) }}">
                    <i class="tim-icons icon-settings-gear-63"></i>
                    <p>{{ __('Organization') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'bank') class="active " @endif>
                <a href="{{ route('bank.index') }}">
                    <i class="tim-icons icon-bank"></i>
                    <p>{{ __('Bank List') }}</p>
                </a>
            </li>

            <li @if ($pageSlug == 'invoices') class="active " @endif>
                <a href="{{ route('invoice.index') }}">
                    <i class="tim-icons icon-paper"></i>
                    <p>{{ __('Invoice') }}</p>
                </a>
            </li>
            {{-- <li>
                <a data-toggle="collapse" href="#laravel-examples" aria-expanded="true">
                    <i class="fab fa-laravel"></i>
                    <span class="nav-link-text">{{ __('Laravel Examples') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse show" id="laravel-examples">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'profile') class="active " @endif>
                            <a href="{{ route('profile.edit') }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('User Profile') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'users') class="active " @endif>
                            <a href="{{ route('user.index') }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('User Management') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li @if ($pageSlug == 'icons') class="active " @endif>
                <a href="{{ route('pages.icons') }}">
                    <i class="tim-icons icon-atom"></i>
                    <p>{{ __('Icons') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'maps') class="active " @endif>
                <a href="{{ route('pages.maps') }}">
                    <i class="tim-icons icon-pin"></i>
                    <p>{{ __('Maps') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'notifications') class="active " @endif>
                <a href="{{ route('pages.notifications') }}">
                    <i class="tim-icons icon-bell-55"></i>
                    <p>{{ __('Notifications') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'tables') class="active " @endif>
                <a href="{{ route('pages.tables') }}">
                    <i class="tim-icons icon-puzzle-10"></i>
                    <p>{{ __('Table List') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'typography') class="active " @endif>
                <a href="{{ route('pages.typography') }}">
                    <i class="tim-icons icon-align-center"></i>
                    <p>{{ __('Typography') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'rtl') class="active " @endif>
                <a href="{{ route('pages.rtl') }}">
                    <i class="tim-icons icon-world"></i>
                    <p>{{ __('RTL Support') }}</p>
                </a>
            </li>
            <li class=" {{ $pageSlug == 'upgrade' ? 'active' : '' }} bg-info">
                <a href="{{ route('pages.upgrade') }}">
                    <i class="tim-icons icon-spaceship"></i>
                    <p>{{ __('Upgrade to PRO') }}</p>
                </a>
            </li> --}}
        </ul>
    </div>
</div>
