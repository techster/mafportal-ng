@if (Auth::check())
    <aside class="main-sidebar maf-admin-sidebar">
        <section class="sidebar">
            <div class="maf-admin-user">
                <div class="maf-admin-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div>
                    <strong>{{ Auth::user()->name }}</strong>
                    <span><i class="fa fa-circle"></i> Online</span>
                </div>
            </div>

            <ul class="sidebar-menu maf-admin-nav">
                <li class="header">WORKSPACE</li>
                <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}"><a href="{{ url('admin/dashboard') }}"><i class="fa fa-th-large"></i><span>Dashboard</span></a></li>
                <li class="header">CONTENT</li>
                <li class="{{ Request::is('admin/page*') ? 'active' : '' }}"><a href="{{ url('admin/page') }}"><i class="fa fa-file-text-o"></i><span>Pages</span></a></li>
                <li class="{{ Request::is('admin/news*') ? 'active' : '' }}"><a href="{{ url('admin/news') }}"><i class="fa fa-newspaper-o"></i><span>News</span></a></li>
                <li class="{{ Request::is('admin/menu-item*') ? 'active' : '' }}"><a href="{{ url('admin/menu-item') }}"><i class="fa fa-bars"></i><span>Navigation</span></a></li>
                <li class="header">MEDIA & EVENTS</li>
                <li class="{{ Request::is('admin/slide*') ? 'active' : '' }}"><a href="{{ url('admin/slide') }}"><i class="fa fa-picture-o"></i><span>Slides</span></a></li>
                <li class="{{ Request::is('admin/photo_gallery*') || Request::is('admin/video_gallery*') ? 'active' : '' }}"><a href="{{ url('admin/photo_gallery') }}"><i class="fa fa-camera"></i><span>Galleries</span></a></li>
                <li class="{{ Request::is('admin/tournament*') || Request::is('admin/event*') ? 'active' : '' }}"><a href="{{ url('admin/tournament') }}"><i class="fa fa-trophy"></i><span>Events & tournaments</span></a></li>
                <li class="header">COMMUNITY</li>
                <li class="{{ Request::is('admin/club*') || Request::is('admin/country*') ? 'active' : '' }}"><a href="{{ url('admin/club') }}"><i class="fa fa-users"></i><span>Clubs</span></a></li>
                <li class="{{ Request::is('admin/contact*') ? 'active' : '' }}"><a href="{{ url('admin/contact') }}"><i class="fa fa-envelope-o"></i><span>Messages</span></a></li>
                <li class="header">SHOP</li>
                <li class="{{ Request::is('admin/product*') ? 'active' : '' }}"><a href="{{ url('admin/product') }}"><i class="fa fa-shopping-bag"></i><span>Products</span></a></li>
                <li class="{{ Request::is('admin/seasons*') ? 'active' : '' }}"><a href="{{ url('admin/seasons') }}"><i class="fa fa-calendar"></i><span>Seasons</span></a></li>
                <li class="header">ACCOUNT</li>
                <li><a href="{{ url('admin/logout') }}"><i class="fa fa-sign-out"></i><span>{{ trans('backpack::base.logout') }}</span></a></li>
            </ul>
        </section>
    </aside>
@endif
