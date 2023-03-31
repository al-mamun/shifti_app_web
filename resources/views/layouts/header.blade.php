<!-- Page Header Start-->

<div class="modal fade" id="userProfile" tabindex="-1" role="dialog" aria-labelledby="userProfile" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="userProfile">User Profile</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
                <table class="borderless display global table" id="global2">
                    <tbody>
				  	<tr>
				  		<th>Profile</th>
				  		<td>image</td>
				  	</tr>
				  	<tr>
				  		<th>Name</th>
				  		<td>{{ Auth::user()->name  }}</td>
				  	</tr>
				  	<tr>
				  		<th>Email</th>
				  		<td>{{ Auth::user()->email  }}</td>
				  	</tr>
				  	<tr>
				  		<th>Contact</th>
				  		<td></td>
				  	</tr>
				    <tr>
				  		<th>Country</th>
				  		<td></td>
				  	</tr>
				    <tr>
				  		<th>City</th>
				  		<td></td>
				  	</tr>
				  </tbody>
                </table>
            </div>
    </div>
  </div>
</div>

<div class="page-main-header">
    <div class="main-header-right row m-0">
        <div class="main-header-left">
            <div class="logo-wrapper">
                <a href="{{ url('/admin/dashboard') }}" style-"position:relative">
                    <img class="img-fluid" src="https://mamundevstudios.com/shifti_api/public/shifti_logo.png" alt="logo">
                    
                    <span class="logo-text"> For Internal Use Only </span>
                </a>
            </div>
        </div>
        <div class="nav-right col-xxl-9 col-xl-9 col-md-9 col-9 pull-right right-header p-0 ms-auto">
         <div class="left-menu-header col">
            <ul>
                <li>
                    <form class="form-inline search-form">
                      <div class="search-bg"><i class="fa fa-search"></i></div>
                      <input class="form-control-plaintext" placeholder="Search here....." data-original-title="" title="">
                    </form>
                    <span class="d-sm-none mobile-search search-bg"><i class="fa fa-search"></i></span>
                </li>
            </ul>
          </div>
        </div>
        <div class="nav-right col-xxl-2 col-xl-2 col-md-2 col-2 pull-right right-header p-0 ms-auto">
            <ul class="nav-menus">
           
                <li class="onhover-dropdown">
                    <div class="notification-box">
                        <svg width="22" height="25" viewBox="0 0 22 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.51654 22.2163C9.11887 22.8872 9.89212 23.2558 10.6945 23.2558H10.6956C11.5014 23.2558 12.2782 22.8872 12.8817 22.2151C13.2049 21.8581 13.7561 21.8291 14.1131 22.1512C14.4712 22.4733 14.5003 23.0256 14.1782 23.3826C13.2386 24.4256 12.0026 25 10.6956 25H10.6933C9.3898 24.9988 8.15608 24.4244 7.22003 23.3814C6.89794 23.0244 6.92701 22.4721 7.28515 22.1512C7.64329 21.8279 8.19445 21.857 8.51654 22.2163ZM10.7524 0C15.921 0 19.3931 4.02558 19.3931 7.78488C19.3931 9.7186 19.8849 10.5384 20.407 11.4081C20.9233 12.2663 21.5082 13.2407 21.5082 15.0826C21.1024 19.7884 16.1896 20.1721 10.7524 20.1721C5.31515 20.1721 0.401194 19.7884 1.53911e-05 15.157C-0.00345745 13.2407 0.581426 12.2663 1.09771 11.4081L1.27997 11.1013C1.72872 10.3301 2.11166 9.49111 2.11166 7.78488C2.11166 4.02558 5.58375 0 10.7524 0ZM10.7524 1.74419C6.6884 1.74419 3.85584 4.92791 3.85584 7.78488C3.85584 10.2023 3.18491 11.3198 2.59189 12.3058C2.11631 13.0977 1.74073 13.7233 1.74073 15.0826C1.93491 17.2756 3.38259 18.4279 10.7524 18.4279C18.0814 18.4279 19.5745 17.2244 19.7675 15.007C19.764 13.7233 19.3884 13.0977 18.9128 12.3058C18.3198 11.3198 17.6489 10.2023 17.6489 7.78488C17.6489 4.92791 14.8163 1.74419 10.7524 1.74419Z" fill="#9BA1CC"/>
                        </svg>
    
                    <span class="badge badge-pill badge-secondary">2</span></div>
                    <ul class="notification-dropdown onhover-show-div">
                      <li>
                        <p class="f-w-600 font-roboto">You have 3 notifications</p>
                      </li>
                      <li>
                        <p class="mb-0"><i class="fa fa-circle-o mr-3 font-primary"> </i>Delivery processing <span class="pull-right">10 min.</span></p>
                      </li>
                      <li>
                        <p class="mb-0"><i class="fa fa-circle-o mr-3 font-success"></i>Order Complete<span class="pull-right">1 hr</span></p>
                      </li>
                      <li>
                        <p class="mb-0"><i class="fa fa-circle-o mr-3 font-info"></i>Tickets Generated<span class="pull-right">3 hr</span></p>
                      </li>
                      <li>
                        <p class="mb-0"><i class="fa fa-circle-o mr-3 font-warning"></i>Delivery Complete<span class="pull-right">6 hr</span></p>
                      </li>
                    </ul>
                </li>

              <li class="onhover-dropdown p-0">
                <div class="media profile-media"><img class="b-r-10" src="{{ asset('image/Profile.jpg') }}" alt="">
                    <div class="media-body author_name"><span> {{ Auth::user()->name  }}</span>
                        <p class="mb-0 font-roboto author_role">Admin <i class="middle fa fa-angle-down"></i></p>
                    </div>
                </div>
                <ul class="profile-dropdown onhover-show-div">
                    <!--<li>-->
                    <!--    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>-->
                    <!--    <span>Account </span>-->
                    <!--</li>-->
                    <li>
                        <a href="{{ url('/admin/logout') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-in"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                            <span>Log out</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#userProfile" title="User Profile">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-in"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                            <span>Profile</span>
                         </a>
                    </li>
                </ul>
              </li>
              
            </ul>
             
          </div>
    </div>
</div>
<!-- Page Header Ends  -->