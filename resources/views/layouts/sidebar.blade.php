<!-- Page Sidebar Start-->
<header class="main-nav">
    <div class="logo-wrapper">
        <a href="{{ url('/admin/dashboard') }}">
            <img class="img-fluid" src="{{ asset('shifti_logo.png') }}" alt="">
        </a>
    </div>
    <div class="logo-icon-wrapper">
        <a href="{{ url('/admin/dashboard') }}">
            <img class="img-fluid" src="{{ asset('shifti_logo.png') }}" alt="">
        </a>
    </div>
    <nav>
        <div class="main-navbar">
      <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
      <div id="mainnav">
        <ul class="nav-menu custom-scrollbar">
            <li class="back-btn">
                <div class="mobile-back text-right">
                    <span>Back</span>
                    <i class="fa fa-angle-right pl-2"></i>
                </div>
            </li>
            <li >
                <a class="" href="{{ url('/admin/dashboard') }}">
                    <i data-feather="home"></i>
                    <span>Dashboard</span>
                </a>
             
            </li>
        
            <li class="dropdown blog_list">
                <a class="nav-link menu-title @if(isset($type) && $type==2) active @endif" href="#"><i data-feather="airplay"></i><span>Blog</span></a>
                <ul class="nav-submenu menu-content blog_list_data"  @if(isset($type) && $type==2) style="display:block !important" @endif>
                    <li><a href="{{ url('/admin/blog/category/tag/create') }}">New Category</a></li>
                    <li><a href="{{ url('/admin/blog/category/tag') }}">Category list</a></li>
                    <li><a href="{{ url('/admin/blog/tag/create') }}">New Tag</a></li>
                    <li><a href="{{ url('/admin/blog/tag/show') }}">Tag List</a></li>
                    <li><a href="{{ url('/admin/blog/create') }}">New setup</a></li>
                    <li class="blog_list_data"><a href="{{ url('/admin/blog') }}">Blog list</a></li>
                </ul>
            </li>
            
          
            <li class="dropdown">
                <a class="nav-link menu-title product_menu_title" href="#"><i data-feather="airplay"></i><span>Product</span></a>
                <ul class="nav-submenu menu-content product_submenu">
                    <li><a href="{{ url('/admin/category/create') }}">New Category</a></li>
                    <li><a href="{{ url('/admin/category/show') }}">Category list</a></li>
                    <li><a href="{{ url('/admin/product/tag/create') }}">New Tag</a></li>
                    <li><a href="{{ url('/admin/product/tag/show') }}">Tag List</a></li>
                    <li><a href="{{ url('/admin/product/create') }}">New Product</a></li>
                    <li><a href="{{ url('/admin/product') }}">Product list</a></li>
                </ul>
            </li>
            <li class="dropdown order_menu">
                <a class="nav-link menu-title order_menu_title" href="#"><i data-feather="airplay"></i><span>Order</span></a>
                <ul class="nav-submenu menu-content order_submenu">
                    <li><a href="{{ url('/order/list') }}">Order List</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="nav-link menu-title customer_menu_title" href="#"><i data-feather="airplay"></i><span>Customer List</span></a>
                <ul class="nav-submenu menu-content customer_submenu">
                    <li><a href="{{ url('/customer/list') }}">Customer </a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="nav-link menu-title stories_menu_title" href="#"><i data-feather="airplay"></i><span>Stories</span></a>
                <ul class="nav-submenu menu-content stories_submenu">
                    <li><a href="{{ url('/admin/stories/create') }}">New Stories</a></li>
                    <li><a href="{{ url('/admin/story') }}">Stories list</a></li>
                    <li><a href="{{ url('/admin/stories/tag/create') }}">New Tag</a></li>
                    <li><a href="{{ url('/admin/stories/tag/show') }}">Tag List</a></li>
                </ul>
            </li>
            <!--<li class="dropdown">-->
            <!--    <a class="nav-link menu-title" href="#"><i data-feather="airplay"></i><span>Pages</span></a>-->
            <!--    <ul class="nav-submenu menu-content">-->
            <!--        <li><a href="{{ url('/admin/pages/create') }}">New Page</a></li>-->
            <!--        <li><a href="{{ url('/admin/pages') }}">Page list</a></li>-->
            <!--    </ul>-->
            <!--</li>-->
            <li class="dropdown">
                <a class="nav-link menu-title email_menu_title" href="#"><i data-feather="airplay"></i><span>Email History</span></a>
                <ul class="nav-submenu menu-content email_submenu">
                    <li><a href="{{ url('/email/history') }}">List</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="nav-link menu-title job_menu_title" href="#"><i data-feather="airplay"></i><span>Job Listing</span></a>
                <ul class="nav-submenu menu-content job_submenu">
                    <li><a href="{{ url('/admin/joblist/create') }}">Add Job</a></li>
                    <li><a href="{{ url('/admin/joblist') }}">Job List</a></li>
                    <li><a href="{{ url('/admin/joblist/categories/create') }}">Add Category</a></li>
                    <li><a href="{{ url('/admin/joblist/categories/show') }}">All Category</a></li>
                    <li><a href="{{ url('/admin/joblist/locations/create') }}">Add Location</a></li>
                    <li><a href="{{ url('/admin/joblist/locations/show') }}">All Location</a></li>
                    <li><a href="{{ url('/admin/aply/joblist') }}">Apply Job List</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="nav-link menu-title page_menu_title" href="#"><i data-feather="airplay"></i><span>Page Settings</span></a>
                <ul class="nav-submenu menu-content page_submenu">
                    <li><a href="{{ url('/admin/home') }}">Home</a></li>
                    <li><a href="{{ url('/admin/about') }}">About</a></li>
                    <li><a href="{{ url('/admin/contact') }}">Contact</a></li>
                    <li><a href="{{ url('/admin/faqs') }}">FAQ</a></li>
                    <li><a href="{{ url('/admin/terms') }}">Terms</a></li>
                    <li><a href="{{ url('/admin/product/page/create') }}">Product Page</a></li>
                    <li><a href="{{ url('/admin/career-listing') }}">Career Listing</a></li>
                    <li><a href="{{ url('/admin/stories') }}">Stories</a></li>
                </ul>
            </li>
            <li>
                <a class="nav-link menu-title" href="{{ url('/admin/setting') }}"><i data-feather="airplay"></i><span>Settings</span></a>
            </li>
            <li>
                <a class="nav-link menu-title" href="{{ url('/payments') }}"><i data-feather="airplay"></i><span>Payment Method</span></a>
            </li>
            <li>
                <a class="nav-link menu-title" href="{{ url('/transaction/history') }}"><i data-feather="airplay"></i><span>Transaction History</span></a>
            </li>
            <li class="dropdown">
                <a class="nav-link menu-title team_menu_title" href="#"><i data-feather="airplay"></i><span>Team Setup</span></a>
                <ul class="nav-submenu menu-content team_submenu">
                  <li><a href="{{ url('/admin/team/create') }}">Add Team</a></li>
                  <li><a href="{{ url('/admin/team') }}">Team</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="nav-link menu-title team_menu_title" href="#"><i data-feather="airplay"></i><span>User Setup</span></a>
                <ul class="nav-submenu menu-content team_submenu">
                  <li><a href="{{ url('/admin/user/setup') }}">Add User</a></li>
                  <li><a href="{{ url('/admin/userlist') }}">User List</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="nav-link menu-title team_menu_title" href="#"><i data-feather="airplay"></i><span>Partner</span></a>
                <ul class="nav-submenu menu-content team_submenu">
                  <li><a href="{{ url('/admin/partner/create') }}">Add</a></li>
                  <li><a href="{{ url('/admin/partner') }}">List</a></li>
                </ul>
            </li>
    
        </ul>
      </div>
    </div>
    </nav>
</header>
<!-- Page Sidebar Ends-->