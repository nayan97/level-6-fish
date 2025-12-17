<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="Fish Market">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
    <meta name="author" content="Fish Market">
    <meta name="robots" content="noindex, nofollow">
    <title>Fish Market</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('backend/s.png') }}">



    @yield('css')


</head>

<body>
    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div>

    <div class="main-wrapper">

        <div class="header">

            <div class="header-left active" style="background: #d1dcff;">
                <a href="{{ route('admin.dashboard') }}" class="logo">
                    <img src="{{ asset('backend/s.png') }}" alt="">
                </a>
                <a href="index.html" class="logo-small">
                    <img src="{{ asset('assets/img/logo-small.png') }}" alt="">
                </a>
                <a id="toggle_btn" href="javascript:void(0);">
                </a>
            </div>

            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <ul class="nav user-menu">

                {{--            <li class="nav-item"> --}}
                {{--                <div class="top-nav-search"> --}}
                {{--                    <a href="javascript:void(0);" class="responsive-search"> --}}
                {{--                        <i class="fa fa-search"></i> --}}
                {{--                    </a> --}}
                {{--                    <form action="#"> --}}
                {{--                        <div class="searchinputs"> --}}
                {{--                            <input type="text" placeholder="Search Here ..."> --}}
                {{--                            <div class="search-addon"> --}}
                {{--                                <span><img src="{{ asset('assets/img/icons/closes.svg') }}" alt="img"></span> --}}
                {{--                            </div> --}}
                {{--                        </div> --}}
                {{--                        <a class="btn" id="searchdiv"><img src="{{ asset('assets/img/icons/search.svg') }}" alt="img"></a> --}}
                {{--                    </form> --}}
                {{--                </div> --}}
                {{--            </li> --}}


                {{--            <li class="nav-item dropdown has-arrow flag-nav"> --}}
                {{--                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);" role="button"> --}}
                {{--                    <img src="{{ asset('assets/img/flags/us1.png') }}" alt="" height="20"> --}}
                {{--                </a> --}}
                {{--                <div class="dropdown-menu dropdown-menu-right"> --}}
                {{--                    <a href="javascript:void(0);" class="dropdown-item"> --}}
                {{--                        <img src="{{ asset('assets/img/flags/us.png') }}" alt="" height="16"> English --}}
                {{--                    </a> --}}
                {{--                    <a href="javascript:void(0);" class="dropdown-item"> --}}
                {{--                        <img src="{{ asset('assets/img/flags/fr.png') }}" alt="" height="16"> French --}}
                {{--                    </a> --}}
                {{--                    <a href="javascript:void(0);" class="dropdown-item"> --}}
                {{--                        <img src="{{ asset('assets/img/flags/es.png') }}" alt="" height="16"> Spanish --}}
                {{--                    </a> --}}
                {{--                    <a href="javascript:void(0);" class="dropdown-item"> --}}
                {{--                        <img src="{{ asset('assets/img/flags/de.png') }}" alt="" height="16"> German --}}
                {{--                    </a> --}}
                {{--                </div> --}}
                {{--            </li> --}}


                {{--            <li class="nav-item dropdown"> --}}
                {{--                <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown"> --}}
                {{--                    <img src="{{ asset('assets/img/icons/notification-bing.svg') }}" alt="img"> <span class="badge rounded-pill">4</span> --}}
                {{--                </a> --}}
                {{--                <div class="dropdown-menu notifications"> --}}
                {{--                    <div class="topnav-dropdown-header"> --}}
                {{--                        <span class="notification-title">Notifications</span> --}}
                {{--                        <a href="javascript:void(0)" class="clear-noti"> Clear All </a> --}}
                {{--                    </div> --}}
                {{--                    <div class="noti-content"> --}}
                {{--                        <ul class="notification-list"> --}}
                {{--                            <li class="notification-message"> --}}
                {{--                                <a href="activities.html"> --}}
                {{--                                    <div class="media d-flex"> --}}
                {{--                        <span class="avatar flex-shrink-0"> --}}
                {{--                        <img alt="" src="{{ asset('assets/img/profiles/avatar-02.jpg') }}"> --}}
                {{--                        </span> --}}
                {{--                                        <div class="media-body flex-grow-1"> --}}
                {{--                                            <p class="noti-details"><span class="noti-title">John Doe</span> added new task <span class="noti-title">Patient appointment booking</span></p> --}}
                {{--                                            <p class="noti-time"><span class="notification-time">4 mins ago</span></p> --}}
                {{--                                        </div> --}}
                {{--                                    </div> --}}
                {{--                                </a> --}}
                {{--                            </li> --}}
                {{--                            --}}
                {{--                            --}}
                {{--                            <li class="notification-message"> --}}
                {{--                                <a href="activities.html"> --}}
                {{--                                    <div class="media d-flex"> --}}
                {{--                                    <span class="avatar flex-shrink-0"> --}}
                {{--                                    <img alt="" src="{{ asset('assets/img/profiles/avatar-03.jpg') }}"> --}}
                {{--                                    </span> --}}
                {{--                                        <div class="media-body flex-grow-1"> --}}
                {{--                                            <p class="noti-details"><span class="noti-title">Tarah Shropshire</span> changed the task name <span class="noti-title">Appointment booking with payment gateway</span></p> --}}
                {{--                                            <p class="noti-time"><span class="notification-time">6 mins ago</span></p> --}}
                {{--                                        </div> --}}
                {{--                                    </div> --}}
                {{--                                </a> --}}
                {{--                            </li> --}}
                {{--                            <li class="notification-message"> --}}
                {{--                                <a href="activities.html"> --}}
                {{--                                    <div class="media d-flex"> --}}
                {{--                                        <span class="avatar flex-shrink-0"> --}}
                {{--                                        <img alt="" src="{{ asset('assets/img/profiles/avatar-06.jpg') }}"> --}}
                {{--                                        </span> --}}
                {{--                                        <div class="media-body flex-grow-1"> --}}
                {{--                                            <p class="noti-details"><span class="noti-title">Misty Tison</span> added <span class="noti-title">Domenic Houston</span> and <span class="noti-title">Claire Mapes</span> to project <span class="noti-title">Doctor available module</span></p> --}}
                {{--                                            <p class="noti-time"><span class="notification-time">8 mins ago</span></p> --}}
                {{--                                        </div> --}}
                {{--                                    </div> --}}
                {{--                                </a> --}}
                {{--                            </li> --}}
                {{--                            <li class="notification-message"> --}}
                {{--                                <a href="activities.html"> --}}
                {{--                                    <div class="media d-flex"> --}}
                {{--                                        <span class="avatar flex-shrink-0"> --}}
                {{--                                        <img alt="" src="{{ asset('assets/img/profiles/avatar-17.jpg') }}"> --}}
                {{--                                        </span> --}}
                {{--                                        <div class="media-body flex-grow-1"> --}}
                {{--                                            <p class="noti-details"><span class="noti-title">Rolland Webber</span> completed task <span class="noti-title">Patient and Doctor video conferencing</span></p> --}}
                {{--                                            <p class="noti-time"><span class="notification-time">12 mins ago</span></p> --}}
                {{--                                        </div> --}}
                {{--                                    </div> --}}
                {{--                                </a> --}}
                {{--                            </li> --}}
                {{--                            <li class="notification-message"> --}}
                {{--                                <a href="activities.html"> --}}
                {{--                                    <div class="media d-flex"> --}}
                {{--                                    <span class="avatar flex-shrink-0"> --}}
                {{--                                    <img alt="" src="{{ asset('assets/img/profiles/avatar-13.jpg') }}"> --}}
                {{--                                    </span> --}}
                {{--                                        <div class="media-body flex-grow-1"> --}}
                {{--                                            <p class="noti-details"><span class="noti-title">Bernardo Galaviz</span> added new task <span class="noti-title">Private chat module</span></p> --}}
                {{--                                            <p class="noti-time"><span class="notification-time">2 days ago</span></p> --}}
                {{--                                        </div> --}}
                {{--                                    </div> --}}
                {{--                                </a> --}}
                {{--                            </li> --}}
                {{--                        </ul> --}}
                {{--                    </div> --}}
                {{--                    <div class="topnav-dropdown-footer"> --}}
                {{--                        <a href="activities.html">View all Notifications</a> --}}
                {{--                    </div> --}}
                {{--                </div> --}}
                {{--            </li> --}}

                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-img"><img src="{{ asset('backend/men.png') }}" alt="">
                            <span class="status online"></span></span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src="{{ asset('backend/men.png') }}" alt="">
                                    <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h6>John Doe</h6>
                                    <h5>Admin</h5>
                                </div>
                            </div>
                            <hr class="m-0">
                            <a class="dropdown-item" href="profile.html"> <i class="me-2" data-feather="user"></i> My
                                Profile</a>
                            <a class="dropdown-item" href="generalsettings.html"><i class="me-2"
                                    data-feather="settings"></i>Settings</a>
                            <hr class="m-0">
                            {{--                        <a class="dropdown-item logout pb-0" href="signin.html"><img src="{{ asset('assets/img/icons/log-out.svg') }}" class="me-2" alt="img">Logout</a> --}}

                            <a class="dropdown-item logout pb-0" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><img
                                    src="{{ asset('assets/img/icons/log-out.svg') }}" class="me-2" alt="img">
                                {{ __('Logout') }}
                            </a>

                        </div>
                    </div>
                </li>
            </ul>


            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.html">My Profile</a>
                    <a class="dropdown-item" href="generalsettings.html">Settings</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                </div>
            </div>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>

        </div>









        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('admin.dashboard') }}"><img
                                    src="{{ asset('assets/img/icons/dashboard.svg') }}"
                                    alt="img"><span>ড্যাশবোর্ড</span> </a>
                        </li>


                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg') }}"
                                    alt="img"><span>পাইকার</span> <span class="menu-arrow"></span></a>
                            <ul>

                                <li>
                                    <a href="{{ route('customers.index') }}"
                                        class="{{ request()->routeIs('customers.index') ? 'active' : '' }}">
                                        পাইকারের তালিকা
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('customers_joma.index') }}"
                                        class="{{ request()->routeIs('customers_joma.index') ? 'active' : '' }}">
                                        পাইকারের জমার তালিকা
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg') }}"
                                    alt="img"><span>মহাজন</span> <span class="menu-arrow"></span></a>
                            <ul>

                                <li>
                                    <a href="{{ route('mohajons.index') }}"
                                        class="{{ request()->routeIs('mohajons.index') ? 'active' : '' }}">
                                        মহাজনের তালিকা
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg') }}"
                                    alt="img"><span>পণ্য</span> <span class="menu-arrow"></span></a>
                            <ul>

                                <li>
                                    <a href="{{ route('products.index') }}"
                                        class="{{ request()->routeIs('products.index') ? 'active' : '' }}">
                                        পণ্যের তালিকা
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg') }}"
                                    alt="img"><span>দাদন বাকি/জমা</span> <span class="menu-arrow"></span></a>
                            <ul>

                                <li>
                                    <a href="{{ route('dadon_add.index') }}"
                                        class="{{ request()->routeIs('dadon_add.index') ? 'active' : '' }}">
                                        দাদন জমা
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('dadon.due_soon') }}"
                                        class="{{ request()->routeIs('dadon.due_soon') ? 'active' : '' }}">
                                        দাদন বাকি
                                    </a>
                                </li>

                                {{--                            <li> --}}
                                {{--                                <a href="{{ route('category.index') }}" class="{{ request()->routeIs('category.index') ? 'active' : '' }}"> --}}
                                {{--                                    Category List --}}
                                {{--                                </a> --}}
                                {{--                            </li> --}}
                                {{--                            <li> --}}
                                {{--                                <a href="{{ route('category.add') }}" class="{{ request()->routeIs('category.add') ? 'active' : '' }}"> --}}
                                {{--                                    Add Category --}}
                                {{--                                </a> --}}
                                {{--                            </li> --}}
                                {{--                            <li> --}}
                                {{--                                <a href="{{ route('subcategory.index') }}" class="{{ request()->routeIs('subcategory.index') ? 'active' : '' }}"> --}}
                                {{--                                    Sub Category List --}}
                                {{--                                </a> --}}
                                {{--                            </li> --}}
                                {{--                            <li> --}}
                                {{--                                <a href="{{ route('subcategory.add') }}" class="{{ request()->routeIs('subcategory.add') ? 'active' : '' }}"> --}}
                                {{--                                    Add Sub Category --}}
                                {{--                                </a> --}}
                                {{--                            </li> --}}
                                {{--                            <li> --}}
                                {{--                                <a href="{{ route('unit.view') }}" class="{{ request()->routeIs('unit.view') ? 'active' : '' }}"> --}}
                                {{--                                    Add Unit --}}
                                {{--                                </a> --}}
                                {{--                            </li> --}}
                                {{--                            <li> --}}
                                {{--                                <a href="{{ route('size.view') }}" class="{{ request()->routeIs('size.view') ? 'active' : '' }}"> --}}
                                {{--                                    Add Size --}}
                                {{--                                </a> --}}
                                {{--                            </li> --}}
                                {{--                            <li> --}}
                                {{--                                <a href="{{ route('material.view') }}" class="{{ request()->routeIs('material.view') ? 'active' : '' }}"> --}}
                                {{--                                    Add Material --}}
                                {{--                                </a> --}}
                                {{--                            </li> --}}
                                {{--                            <li> --}}
                                {{--                                <a href="{{ route('plating.view') }}" class="{{ request()->routeIs('plating.view') ? 'active' : '' }}"> --}}
                                {{--                                    Add Plating --}}
                                {{--                                </a> --}}
                                {{--                            </li> --}}
                                {{--                            <li> --}}
                                {{--                                <a href="{{ route('import.index') }}" class="{{ request()->routeIs('import.index') ? 'active' : '' }}"> --}}
                                {{--                                    Import Products --}}
                                {{--                                </a> --}}
                                {{--                            </li> --}}


                            </ul>
                        </li>


                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg') }}"
                                    alt="img"><span>আয়/ব্যয় হিসাব</span> <span class="menu-arrow"></span></a>
                            <ul>

                                {{-- <li>
                                    <a href="{{ route('paikar_charge.index') }}"
                                        class="{{ request()->routeIs('paikar_charge.index') ? 'active' : '' }}">
                                        পাইকারের চার্জ
                                    </a>
                                </li> --}}
                                <li>
                                    <a href="{{ route('paikar_due.index') }}"
                                        class="{{ request()->routeIs('paikar_due.index') ? 'active' : '' }}">
                                        আয়ের খাত
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('income.index') }}"
                                        class="{{ request()->routeIs('income.index') ? 'active' : '' }}">
                                        আয় হিসাব
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('expense.index') }}"
                                        class="{{ request()->routeIs('expense.index') ? 'active' : '' }}">
                                        ব্যয় হিসাব
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg') }}"
                                    alt="img"><span>আমানত</span> <span class="menu-arrow"></span></a>
                            <ul>

                                <li>
                                    <a href="{{ route('chalan.report') }}"
                                        class="{{ request()->routeIs('chalan.report') ? 'active' : '' }}">
                                        চালান বাকি
                                    </a>
                                </li>
                        </li>
                        <li>
                            <a href="{{ route('chalans.history') }}"
                                class="{{ request()->routeIs('chalans.history') ? 'active' : '' }}">
                                চালান বাকি ফেরত তালিকা
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('amanot.index') }}"
                                class="{{ request()->routeIs('amanot.index') ? 'active' : '' }}">
                                আমানত সংগ্রহ
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('amanot.history') }}"
                                class="{{ request()->routeIs('amanot.history') ? 'active' : '' }}">
                                ফেরত তালিকা
                            </a>
                        </li>
                    </ul>
                    </li>
                    <li class="submenu">
                        <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg') }}"
                                alt="img"><span>চালান</span> <span class="menu-arrow"></span></a>
                        <ul>

                            <li>
                                <a href="{{ route('chalans.index') }}"
                                    class="{{ request()->routeIs('chalans.index') ? 'active' : '' }}">
                                    চালানের তালিকা
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg') }}"
                                alt="img"><span>চালান খাতা</span> <span class="menu-arrow"></span></a>
                        <ul>

                            <li>
                                <a href="{{ route('daily.index') }}"
                                    class="{{ request()->routeIs('daily.index') ? 'active' : '' }}">
                                    দৈনিক ক্রয়ের তালিকা
                                </a>
                                <a href="{{ route('kroy.hishab') }}"
                                    class="{{ request()->routeIs('kroy.hishab') ? 'active' : '' }}">
                                    ক্রয়ের তালিকা বিস্তারিত
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="{{ request()->routeIs('uttolon.index') ? 'active' : '' }}">
                        <a href="{{ route('cash.index') }}"><img src="{{ asset('assets/img/icons/cash.svg') }}"
                                alt="img"><span>ক্যাশ খাতা</span></a>
                    </li>
                    <li class="{{ request()->routeIs('uttolon.index') ? 'active' : '' }}">
                        <a href="{{ route('uttolon.index') }}"><img
                                src="{{ asset('assets/img/icons/wallet1.svg') }}"
                                alt="img"><span>উত্তোলন</span></a>
                    </li>


                    {{--                    <li class="submenu"> --}}
                    {{--                        <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/sales1.svg') }}" alt="img"><span> Sales</span> <span class="menu-arrow"></span></a> --}}
                    {{--                        <ul> --}}
                    {{--                            <li><a href="saleslist.html">Sales List</a></li> --}}
                    {{--                            <li><a href="pos.html">POS</a></li> --}}
                    {{--                            <li><a href="pos.html">New Sales</a></li> --}}
                    {{--                            <li><a href="salesreturnlists.html">Sales Return List</a></li> --}}
                    {{--                            <li><a href="createsalesreturns.html">New Sales Return</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}
                    {{--                    <li class="submenu"> --}}
                    {{--                        <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/purchase1.svg') }}" alt="img"><span> Purchase</span> <span class="menu-arrow"></span></a> --}}
                    {{--                        <ul> --}}
                    {{--                            <li><a href="purchaselist.html">Purchase List</a></li> --}}
                    {{--                            <li><a href="addpurchase.html">Add Purchase</a></li> --}}
                    {{--                            <li><a href="importpurchase.html">Import Purchase</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}
                    {{--                    <li class="submenu"> --}}
                    {{--                        <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/expense1.svg') }}" alt="img"><span> Expense</span> <span class="menu-arrow"></span></a> --}}
                    {{--                        <ul> --}}
                    {{--                            <li><a href="expenselist.html">Expense List</a></li> --}}
                    {{--                            <li><a href="createexpense.html">Add Expense</a></li> --}}
                    {{--                            <li><a href="expensecategory.html">Expense Category</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}
                    {{--                    <li class="submenu"> --}}
                    {{--                        <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/quotation1.svg') }}" alt="img"><span> Quotation</span> <span class="menu-arrow"></span></a> --}}
                    {{--                        <ul> --}}
                    {{--                            <li><a href="quotationList.html">Quotation List</a></li> --}}
                    {{--                            <li><a href="addquotation.html">Add Quotation</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}
                    {{--                    <li class="submenu"> --}}
                    {{--                        <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/transfer1.svg') }}" alt="img"><span> Transfer</span> <span class="menu-arrow"></span></a> --}}
                    {{--                        <ul> --}}
                    {{--                            <li><a href="transferlist.html">Transfer List</a></li> --}}
                    {{--                            <li><a href="addtransfer.html">Add Transfer </a></li> --}}
                    {{--                            <li><a href="importtransfer.html">Import Transfer </a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}
                    {{--                    <li class="submenu"> --}}
                    {{--                        <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/return1.svg') }}" alt="img"><span> Return</span> <span class="menu-arrow"></span></a> --}}
                    {{--                        <ul> --}}
                    {{--                            <li><a href="salesreturnlist.html">Sales Return List</a></li> --}}
                    {{--                            <li><a href="createsalesreturn.html">Add Sales Return </a></li> --}}
                    {{--                            <li><a href="purchasereturnlist.html">Purchase Return List</a></li> --}}
                    {{--                            <li><a href="createpurchasereturn.html">Add Purchase Return </a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}
                    {{--                    <li class="submenu"> --}}
                    {{--                        <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/users1.svg') }}" alt="img"><span> People</span> <span class="menu-arrow"></span></a> --}}
                    {{--                        <ul> --}}
                    {{--                            <li><a href="customerlist.html">Customer List</a></li> --}}
                    {{--                            <li><a href="addcustomer.html">Add Customer </a></li> --}}
                    {{--                            <li><a href="supplierlist.html">Supplier List</a></li> --}}
                    {{--                            <li><a href="addsupplier.html">Add Supplier </a></li> --}}
                    {{--                            <li><a href="userlist.html">User List</a></li> --}}
                    {{--                            <li><a href="adduser.html">Add User</a></li> --}}
                    {{--                            <li><a href="storelist.html">Store List</a></li> --}}
                    {{--                            <li><a href="addstore.html">Add Store</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> <li class="submenu"> --}}
                    {{--                        <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/places.svg') }}" alt="img"><span> Places</span> <span class="menu-arrow"></span></a> --}}
                    {{--                        <ul> --}}
                    {{--                            <li><a href="newcountry.html">New Country</a></li> --}}
                    {{--                            <li><a href="countrieslist.html">Countries list</a></li> --}}
                    {{--                            <li><a href="newstate.html">New State </a></li> --}}
                    {{--                            <li><a href="statelist.html">State list</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}
                    {{--                    <li> --}}
                    {{--                        <a href="components.html"><i data-feather="layers"></i><span> Components</span> </a> --}}
                    {{--                    </li> --}}
                    {{--                    <li> --}}
                    {{--                        <a href="blankpage.html"><i data-feather="file"></i><span> Blank Page</span> </a> --}}
                    {{--                    </li> --}}
                    {{--                    <li class="submenu"> --}}
                    {{--                        <a href="javascript:void(0);"><i data-feather="alert-octagon"></i> <span> Error Pages </span> <span class="menu-arrow"></span></a> --}}
                    {{--                        <ul> --}}
                    {{--                            <li><a href="error-404.html">404 Error </a></li> --}}
                    {{--                            <li><a href="error-500.html">500 Error </a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}
                    {{--                    <li class="submenu"> --}}
                    {{--                        <a href="javascript:void(0);"><i data-feather="box"></i> <span>Elements </span> <span class="menu-arrow"></span></a> --}}
                    {{--                        <ul> --}}
                    {{--                            <li><a href="sweetalerts.html">Sweet Alerts</a></li> --}}
                    {{--                            <li><a href="tooltip.html">Tooltip</a></li> --}}
                    {{--                            <li><a href="popover.html">Popover</a></li> --}}
                    {{--                            <li><a href="ribbon.html">Ribbon</a></li> --}}
                    {{--                            <li><a href="clipboard.html">Clipboard</a></li> --}}
                    {{--                            <li><a href="drag-drop.html">Drag & Drop</a></li> --}}
                    {{--                            <li><a href="rangeslider.html">Range Slider</a></li> --}}
                    {{--                            <li><a href="rating.html">Rating</a></li> --}}
                    {{--                            <li><a href="toastr.html">Toastr</a></li> --}}
                    {{--                            <li><a href="text-editor.html">Text Editor</a></li> --}}
                    {{--                            <li><a href="counter.html">Counter</a></li> --}}
                    {{--                            <li><a href="scrollbar.html">Scrollbar</a></li> --}}
                    {{--                            <li><a href="spinner.html">Spinner</a></li> --}}
                    {{--                            <li><a href="notification.html">Notification</a></li> --}}
                    {{--                            <li><a href="lightbox.html">Lightbox</a></li> --}}
                    {{--                            <li><a href="stickynote.html">Sticky Note</a></li> --}}
                    {{--                            <li><a href="timeline.html">Timeline</a></li> --}}
                    {{--                            <li><a href="form-wizard.html">Form Wizard</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}
                    {{--                    <li class="submenu"> --}}
                    {{--                        <a href="javascript:void(0);"><i data-feather="bar-chart-2"></i> <span> Charts </span> <span class="menu-arrow"></span></a> --}}
                    {{--                        <ul> --}}
                    {{--                            <li><a href="chart-apex.html">Apex Charts</a></li> --}}
                    {{--                            <li><a href="chart-js.html">Chart Js</a></li> --}}
                    {{--                            <li><a href="chart-morris.html">Morris Charts</a></li> --}}
                    {{--                            <li><a href="chart-flot.html">Flot Charts</a></li> --}}
                    {{--                            <li><a href="chart-peity.html">Peity Charts</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}
                    {{--                    <li class="submenu"> --}}
                    {{--                        <a href="javascript:void(0);"><i data-feather="award"></i><span> Icons </span> <span class="menu-arrow"></span></a> --}}
                    {{--                        <ul> --}}
                    {{--                            <li><a href="icon-fontawesome.html">Fontawesome Icons</a></li> --}}
                    {{--                            <li><a href="icon-feather.html">Feather Icons</a></li> --}}
                    {{--                            <li><a href="icon-ionic.html">Ionic Icons</a></li> --}}
                    {{--                            <li><a href="icon-material.html">Material Icons</a></li> --}}
                    {{--                            <li><a href="icon-pe7.html">Pe7 Icons</a></li> --}}
                    {{--                            <li><a href="icon-simpleline.html">Simpleline Icons</a></li> --}}
                    {{--                            <li><a href="icon-themify.html">Themify Icons</a></li> --}}
                    {{--                            <li><a href="icon-weather.html">Weather Icons</a></li> --}}
                    {{--                            <li><a href="icon-typicon.html">Typicon Icons</a></li> --}}
                    {{--                            <li><a href="icon-flag.html">Flag Icons</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}
                    {{--                    <li class="submenu"> --}}
                    {{--                        <a href="javascript:void(0);"><i data-feather="columns"></i> <span> Forms </span> <span class="menu-arrow"></span></a> --}}
                    {{--                        <ul> --}}
                    {{--                            <li><a href="form-basic-inputs.html">Basic Inputs </a></li> --}}
                    {{--                            <li><a href="form-input-groups.html">Input Groups </a></li> --}}
                    {{--                            <li><a href="form-horizontal.html">Horizontal Form </a></li> --}}
                    {{--                            <li><a href="form-vertical.html"> Vertical Form </a></li> --}}
                    {{--                            <li><a href="form-mask.html">Form Mask </a></li> --}}
                    {{--                            <li><a href="form-validation.html">Form Validation </a></li> --}}
                    {{--                            <li><a href="form-select2.html">Form Select2 </a></li> --}}
                    {{--                            <li><a href="form-fileupload.html">File Upload </a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}
                    {{--                    <li class="submenu"> --}}
                    {{--                        <a href="javascript:void(0);"><i data-feather="layout"></i> <span> Table </span> <span class="menu-arrow"></span></a> --}}
                    {{--                        <ul> --}}
                    {{--                            <li><a href="tables-basic.html">Basic Tables </a></li> --}}
                    {{--                            <li><a href="data-tables.html">Data Table </a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}
                    {{--                    <li class="submenu"> --}}
                    {{--                        <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg') }}" alt="img"><span> Application</span> <span class="menu-arrow"></span></a> --}}
                    {{--                        <ul> --}}
                    {{--                            <li><a href="chat.html">Chat</a></li> --}}
                    {{--                            <li><a href="calendar.html">Calendar</a></li> --}}
                    {{--                            <li><a href="email.html">Email</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}
                    {{--                    <li class="submenu"> --}}
                    {{--                        <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/time.svg') }}" alt="img"><span> Report</span> <span class="menu-arrow"></span></a> --}}
                    {{--                        <ul> --}}
                    {{--                            <li><a href="purchaseorderreport.html">Purchase order report</a></li> --}}
                    {{--                            <li><a href="inventoryreport.html">Inventory Report</a></li> --}}
                    {{--                            <li><a href="salesreport.html">Sales Report</a></li> --}}
                    {{--                            <li><a href="invoicereport.html">Invoice Report</a></li> --}}
                    {{--                            <li><a href="purchasereport.html">Purchase Report</a></li> --}}
                    {{--                            <li><a href="supplierreport.html">Supplier Report</a></li> --}}
                    {{--                            <li><a href="customerreport.html">Customer Report</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}
                    {{--                    <li class="submenu"> --}}
                    {{--                        <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/users1.svg') }}" alt="img"><span> Users</span> <span class="menu-arrow"></span></a> --}}
                    {{--                        <ul> --}}
                    {{--                            <li><a href="newuser.html">New User </a></li> --}}
                    {{--                            <li><a href="userlists.html">Users List</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}
                    {{--                    <li class="submenu"> --}}
                    {{--                        <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/settings.svg') }}" alt="img"><span> Settings</span> <span class="menu-arrow"></span></a> --}}
                    {{--                        <ul> --}}
                    {{--                            <li><a href="generalsettings.html">General Settings</a></li> --}}
                    {{--                            <li><a href="emailsettings.html">Email Settings</a></li> --}}
                    {{--                            <li><a href="paymentsettings.html">Payment Settings</a></li> --}}
                    {{--                            <li><a href="currencysettings.html">Currency Settings</a></li> --}}
                    {{--                            <li><a href="grouppermissions.html">Group Permissions</a></li> --}}
                    {{--                            <li><a href="taxrates.html">Tax Rates</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}
                    {{--                </ul> --}}
                </div>
            </div>
        </div>


        @yield('content')


    </div>




    @yield('js')
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
</body>

</html>
