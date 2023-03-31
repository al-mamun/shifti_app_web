<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="https://mamundevstudios.com/shifti_api/public/IconBlue.png" type="image/x-icon">
    <link rel="shortcut icon" href="https://mamundevstudios.com/shifti_api/public/IconBlue.png" type="image/x-icon">
    <title> {{ config('app.name', 'Laravel') }}</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fontawesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/feather-icon.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/chartist.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/owlcarousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/prism.css') }}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style.css') }}">
    <style>
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 310px;
            max-width: 800px;
            margin: 1em auto;
        }
        
        #container {
            height: 320px;
            margin-top: -23px;
        }
        g.highcharts-exporting-group {
            display: none !important;
        }
        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }
        
        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }
        
        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }
        
        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }
        
        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #007AE5;
        }
        
        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }
    </style>
  </head>
  <body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="loader-index"><span></span></div>
      <svg>
        <defs></defs>
        <filter id="goo">
          <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
          <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo">    </fecolormatrix>
        </filter>
      </svg>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      @include('layouts.header')   
   
      <div class="page-body-wrapper sidebar-icon">
        <!-- Page Sidebar Start-->
         @include('layouts.sidebar')
        <!-- Page Sidebar Ends-->
        <div class="page-body">
            <div class="container-fluid">
                 @include('admin.dashboard.dashboard_head_box')
                
            </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
                <div class="col-xl-7 box-col-7 col-md-7">
                    <div class="card o-hidden"  style="background: #fff !important; height:430px">
                        <div class="card-header card-no-border">
                            <h5 class="card_title_custom">Visit</h5>
                        </div>
                     
                        <div class="card-body pt-0">
                            <div class="monthly-visit">
                                 <div id="container"></div>
                              <!--<div id="column-chart"></div>-->
                            </div>
                            <div class="code-box-copy">
                              <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head1" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                             
                            </div>
                        </div>
                    </div>
                </div>
             
                <div class="col-xl-5 col-md-5 box-col-12">
                    <div class="card" style="background: #fff !important;">
                        <div class="card-header card-no-border">
                            <h5>Lastest Activity</h5>
                            <div class="card-header-right">
                                <ul class="list-unstyled card-option">
                                    <li><i class="fa fa-spin fa-cog"></i></li>
                                    <li><i class="view-html fa fa-code"></i></li>
                                    <li><i class="icofont icofont-maximize full-card"></i></li>
                                    <li><i class="icofont icofont-minus minimize-card"></i></li>
                                    <li><i class="icofont icofont-refresh reload-card"></i></li>
                                    <li><i class="icofont icofont-error close-card"></i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body new-update pt-0">
                            <div class="activity-timeline">
                                <div class="media">
                                    <div class="activity-line"></div>
                                    <div class="activity-dot-primary"></div>
                                    <div class="media-body"><span>Update Product</span>
                                        <p class="font-roboto">Quisque a consequat ante Sit amet magna at volutapt.</p>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="activity-dot-primary"></div>
                                    <div class="media-body"><span>James liked Nike Shoes</span>
                                         <p class="font-roboto">Aenean sit amet magna vel magna fringilla ferme.</p>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="activity-dot-primary"></div>
                                    <div class="media-body"><span>john just buy your product</span>
                                        <p class="font-roboto">Vestibulum nec mi suscipit, dapibus purus.....</p>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="activity-dot-primary"></div>
                                    <div class="media-body"><span>john just buy your product</span>
                                        <p class="font-roboto">Vestibulum nec mi suscipit, dapibus purus.....</p>
                                    </div>
                                </div>
                             
                            </div>
                            <div class="code-box-copy">
                              <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head5" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                             
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row size-column">
                
                <div class="col-xl-12 xl-100 box-col-12">
                    <div class="card customerList">
                        <div class="card-body pt-0">
                        <div class="our-products">
                          <div class="table-responsive">
                            <table class="table table-bordernone customer_list">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Date Of Sign Up</th>
                                        <th>Email  address</th>
                                        <th>Monthly Subscription</th>
                                        <th></th>
                                    </tr>
                                </thead>
                              <tbody class="f-w-500">
                                @foreach($customerInfo as $customer)
                                <tr>
                                    <td>
                                        <div class="media">
                                            @if(!empty($list->photo))
    		                                    <img src="{{  URL::asset('upload/customer/'.$list->photo)}}" class="img-fluid m-r-15 rounded-circle" style="width: 66px;">
    		                                @else
    		                                    <img src="{{  URL::asset('upload/customer/author_4.png')}}" class="img-fluid m-r-15 rounded-circle" style="width: 66px;">
    		                                @endif
                                            
                                            <div class="media-body" style="text-align:left;padding-top:20px">
                                                <span>{{ $customer->first_name }} </span>
                                            </div>
                                        </div>
                                    </td>
                                  <td>
                                        <p style="padding-top:33px">@php
                                            $date = date("F d, Y", strtotime( $customer->created_at));
                                        @endphp
                                        {{ $date }}</p>
                                  </td>
                                  <td>
                                        <p style="padding-top:33px">{{ $customer->email }}</p>
                                  </td>
                                  <td style="text-align:center">
                                        <p style="padding-top:33px">@if(!empty($customer->price)) {{ '$'.$customer->price }} @endif</p>
                                  </td>
                                  <td>
                                        <div class="dropdown">
                                            <button class="button-custom" type="button" id="action_button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                . . .
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="action_button">
                                                 @if($customer->status != 2)
                                                    <a class="dropdown-item" onClick="SuspendCustomer('{{$customer->id}}','2')" href="javascript:void(0)" style="float: left;font-size: 14px; font-family: 'Nunito Sans', sans-serif;" >Suspend Customers</a>
                                                @elseif($customer->status == 2)
                                                    <a class="dropdown-item" onClick="SuspendCustomer('{{$customer->id}}','1')" href="javascript:void(0)" style="float: left;font-size: 14px; font-family: 'Nunito Sans', sans-serif;" >Un-Suspend Customers</a>
                                                @endif
                                              
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                               
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="code-box-copy">
                          <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head3" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                         
                        </div>
                      </div>
                    </div>
                </div>
            </div>
          </div>
          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <footer class="footer">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 footer-copyright">
                <p class="mb-0">© Shifti Technologies PTY. LTD. 2023, All rights reserved.</p>
              </div>
              <div class="col-md-6">
                <p class="pull-right mb-0">Hand crafted & made with <i class="fa fa-heart font-secondary"></i></p>
              </div>
            </div>
          </div>
        </footer>
       
        <script async="" defer="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGCQvcXUsXwCdYArPXo72dLZ31WS3WQRw&amp;callback=initMap"></script>
      </div>
    </div>
    <!-- latest jquery-->
    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
    <!-- Bootstrap js-->
    <script src="{{ asset('assets/js/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.js') }}"></script>
    <!-- feather icon js-->
    <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <!-- Sidebar jquery-->
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="{{ asset('assets/js/prism/prism.min.js') }}"></script>
    <script src="{{ asset('assets/js/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ asset('assets/js/counter/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/counter/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/counter/counter-custom.js') }}"></script>
    <script src="{{ asset('assets/js/custom-card/custom-card.js') }}"></script>
    <script src="{{ asset('assets/js/owlcarousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard/dashboard_2.js') }}"></script>
    <script src="{{ asset('assets/js/tooltip-init.js') }}"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{ asset('assets/js/script.js') }}"></script>
 
    <!-- login js-->
    <!-- Plugin used-->
     <script>
          Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: [
                    'Sun',
                    'Mon',
                    'Tues',
                    'Wed',
                    'Thur',
                    'Fri',
                    'Sat',
                 
                ],
                gridLineColor: '#ffffff',
             gridLineWidth: 0,
                crosshair: false,
                gridLines: {
                    display: false // This removes vertical grid lines
                  }
            },
           
            yAxis: {
                min: 0,
                title: {
                    text: ''
                },
                gridLineColor: '#ffffff',
                gridLineWidth: 0,
                labels: {
                    enabled: false
                  }
            },
            credits: {
                 enabled: false
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                },
                series: {
    	             pointWidth: 15,//width of the column bars irrespective of the chart size
    	             borderRadiusTopLeft: 8,
                     borderRadiusTopRight: 8
    	        }
            },
            legend: {
                margintTop:'-40px',
                align: 'left',
                verticalAlign: 'top',
                x: 0,
                y: 0
            },
            colors: [
                '#007AE5',
                '#9BA1CC'    
            ],
            series: [{
                name: 'This Week',
                data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6],
                type: 'column',
                borderRadiusTopLeft: 25,
                borderRadiusTopRight: 25
        
            }, {
                name: 'Last Week',
                data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0],
                type: 'column'
                
        
            }]
        });
        </script>
  </body>
</html>