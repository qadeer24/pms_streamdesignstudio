<!DOCTYPE html>
<html lang="en">
<head>
<base href="../../../" />
	<title>@yield('title') - {{ config('app.name') }}</title>
	<meta charset="utf-8" />
	<meta name="description" content="The most advanced Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions. Grab your copy now and get life-time updates for free." />
	<meta name="keywords" content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="Metronic - The World's #1 Selling Bootstrap Admin Template by KeenThemes" />
	<meta property="og:url" content="https://keenthemes.com/metronic" />
	<meta property="og:site_name" content="Metronic by Keenthemes" />
	<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
	<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
	<!--begin::Fonts(mandatory for all pages)-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Vendor Stylesheets(used for this page only)-->
	<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<!--end::Vendor Stylesheets-->
	<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
	<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Global Stylesheets Bundle-->
	<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
</head>
@if(isset($project->project_img))
    <body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled" style="background-image: url('{{ asset('uploads/projects/' . $project->project_img) }}'); background-size: 100% 300px; background-position: top center;">
@else
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
@endif
	<div id="kt_header" class="header align-items-stretch mb-5 mb-lg-10 p-4" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
		<div class="container-xxl d-flex align-items-center">
			<div class="d-flex topbar align-items-center d-lg-none ms-n2 me-3" title="Show aside menu">
				<div class="btn btn-icon btn-active-light-primary btn-custom w-30px h-30px w-md-40px h-md-40px" id="kt_header_menu_mobile_toggle">
					<i class="ki-duotone ki-abstract-14 fs-1">
						<span class="path1"></span>
						<span class="path2"></span>
					</i>
				</div>
			</div>
			<div class="header-logo me-5 me-md-10 flex-grow-1 flex-lg-grow-0">
				<a href="{{route('home')}}">
					<img alt="Logo" src="assets/media/logos/stream_logo.png" class="logo-default h-45px" />
					<img alt="Logo" src="assets/media/logos/stream_logo.png" class="logo-sticky h-45px" />
				</a>
			</div>
			<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
				<div class="d-flex align-items-stretch" id="kt_header_nav">
					<div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
						<div class="menu menu-rounded menu-column menu-lg-row menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-500 fw-semibold my-5 my-lg-0 align-items-stretch px-2 px-lg-0" id="#kt_header_menu" data-kt-menu="true">
							<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
								<span class="menu-link py-3">
									<span class="menu-title">Dashboards</span>
									<span class="menu-arrow d-lg-none"></span>
								</span>
								<div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown p-0">
									<div class="menu-state-bg menu-extended overflow-hidden overflow-lg-visible" data-kt-menu-dismiss="true">
										<div class="row">
											<div class="col-lg-12 mb-3 mb-lg-0 py-3 px-3 py-lg-6 px-lg-6">
												<div class="row">
													<div class="col-lg-12 mb-3">
														<div class="menu-item p-0 m-0">
															<a href="{{route('home')}}" class="menu-link">
																<span class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3">
																	<i class="ki-duotone ki-element-11 text-primary fs-1">
																		<span class="path1"></span>
																		<span class="path2"></span>
																		<span class="path3"></span>
																		<span class="path4"></span>
																	</i>
																</span>
																<span class="d-flex flex-column">
																	<span class="fs-6 fw-bold text-gray-800">Home</span>
																	<span class="fs-7 fw-semibold text-muted">Reports & statistics</span>
																</span>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
								<span class="menu-link py-3">
									<span class="menu-title">Apps</span>
									<span class="menu-arrow d-lg-none"></span>
								</span>
								<div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-250px">
									<div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
										@can('projects-list')
											<a class="menu-link py-3 @if(Request::is('projects')) {{'active'}} @endif" href="{{route('projects.index')}}">	
												<span class="menu-link py-3">
													<span class="menu-icon">
														<i class="ki-duotone ki-rocket fs-2">
															<span class="path1"></span>
															<span class="path2"></span>
														</i>
													</span>
													<span class="menu-title">Projects</span>
												</span>
											</a>
										@endcan
										@can('user-list')
											<a class="menu-link py-3 @if(Request::is('users')) {{'active'}} @endif" href="{{route('users.index')}}">	
												<span class="menu-link py-3">
													<span class="menu-icon">
														<i class="ki-duotone ki-shield-tick fs-2">
															<span class="path1"></span>
															<span class="path2"></span>
														</i>
													</span>
													<span class="menu-title">User Management</span>
												</span>
											</a>
										@endcan
										@can('categories-list')
											<a class="menu-link py-3 @if(Request::is('categories')) {{'active'}} @endif" href="{{route('categories.index')}}">	
												<span class="menu-link py-3">
													<span class="menu-icon">
														<i class="ki-duotone ki-chart fs-2">
															<span class="path1"></span>
															<span class="path2"></span>
														</i>
													</span>
													<span class="menu-title">Categories</span>
												</span>
											</a>
										@endcan
										@can('frameworks-list')
											<a class="menu-link py-3 @if(Request::is('frameworks')) {{'active'}} @endif" href="{{route('frameworks.index')}}">	
												<span class="menu-link py-3">
													<span class="menu-icon">
														<i class="ki-duotone ki-code fs-2">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
															<span class="path4"></span>
														</i>
													</span>
													<span class="menu-title">Frameworks</span>
												</span>
											</a>
										@endcan
										@can('role-list')
											<a class="menu-link py-3 @if(Request::is('roles')) {{'active'}} @endif" href="{{route('roles.index')}}">	
												<span class="menu-link py-3">
													<span class="menu-icon">
														<i class="ki-duotone ki-user fs-2">
															<span class="path1"></span>
															<span class="path2"></span>
														</i>
													</span>
													<span class="menu-title">Roles</span>
												</span>
											</a>
										@endcan
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="topbar d-flex align-items-stretch flex-shrink-0">
					<div class="d-flex align-items-stretch ms-1 ms-lg-3">
						<div id="kt_header_search" class="header-search d-flex align-items-stretch" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-menu-trigger="auto" data-kt-menu-overflow="false" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end">
							<div class="d-flex align-items-center" data-kt-search-element="toggle" id="kt_header_search_toggle">
								<div class="btn btn-icon btn-active-light-primary btn-custom w-30px h-30px w-md-40px h-md-40px">
									<i class="ki-duotone ki-magnifier fs-1">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
								</div>
							</div>
							<div data-kt-search-element="content" class="menu menu-sub menu-sub-dropdown p-7 w-325px w-md-375px">
								<div data-kt-search-element="wrapper">
									<form data-kt-search-element="form" class="w-100 position-relative mb-3" autocomplete="off">
										<i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-0">
											<span class="path1"></span>
											<span class="path2"></span>
										</i>
										<input type="text" class="search-input form-control form-control-flush ps-10" name="search" value="" placeholder="Search..." data-kt-search-element="input" />
										<span class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-1" data-kt-search-element="spinner">
											<span class="spinner-border h-15px w-15px align-middle text-gray-500"></span>
										</span>
										<span class="search-reset btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none" data-kt-search-element="clear">
											<i class="ki-duotone ki-cross fs-2 fs-lg-1 me-0">
												<span class="path1"></span>
												<span class="path2"></span>
											</i>
										</span>
										<div class="position-absolute top-50 end-0 translate-middle-y" data-kt-search-element="toolbar">
											<div data-kt-search-element="preferences-show" class="btn btn-icon w-20px btn-sm btn-active-color-primary me-1" data-bs-toggle="tooltip" title="Show search preferences">
												<i class="ki-duotone ki-setting-2 fs-2">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
											</div>
											<div data-kt-search-element="advanced-options-form-show" class="btn btn-icon w-20px btn-sm btn-active-color-primary" data-bs-toggle="tooltip" title="Show more search options">
												<i class="ki-duotone ki-down fs-2"></i>
											</div>
										</div>
									</form>
									<div class="separator border-gray-200 mb-6"></div>
									<div data-kt-search-element="results" class="d-none">
										<div class="scroll-y mh-200px mh-lg-350px">
											<h3 class="fs-5 text-muted m-0 pb-5" data-kt-search-element="category-title">Users</h3>
											<a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
												<div class="symbol symbol-40px me-4">
													<img src="assets/media/avatars/300-6.jpg" alt="" />
												</div>
												<div class="d-flex flex-column justify-content-start fw-semibold">
													<span class="fs-6 fw-semibold">Karina Clark</span>
													<span class="fs-7 fw-semibold text-muted">Marketing Manager</span>
												</div>
											</a>
											<a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
												<div class="symbol symbol-40px me-4">
													<img src="assets/media/avatars/300-2.jpg" alt="" />
												</div>
												<div class="d-flex flex-column justify-content-start fw-semibold">
													<span class="fs-6 fw-semibold">Olivia Bold</span>
													<span class="fs-7 fw-semibold text-muted">Software Engineer</span>
												</div>
											</a>
											<a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
												<div class="symbol symbol-40px me-4">
													<img src="assets/media/avatars/300-9.jpg" alt="" />
												</div>
												<div class="d-flex flex-column justify-content-start fw-semibold">
													<span class="fs-6 fw-semibold">Ana Clark</span>
													<span class="fs-7 fw-semibold text-muted">UI/UX Designer</span>
												</div>
											</a>
											<a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
												<div class="symbol symbol-40px me-4">
													<img src="assets/media/avatars/300-14.jpg" alt="" />
												</div>
												<div class="d-flex flex-column justify-content-start fw-semibold">
													<span class="fs-6 fw-semibold">Nick Pitola</span>
													<span class="fs-7 fw-semibold text-muted">Art Director</span>
												</div>
											</a>
											<a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
												<div class="symbol symbol-40px me-4">
													<img src="assets/media/avatars/300-11.jpg" alt="" />
												</div>
												<div class="d-flex flex-column justify-content-start fw-semibold">
													<span class="fs-6 fw-semibold">Edward Kulnic</span>
													<span class="fs-7 fw-semibold text-muted">System Administrator</span>
												</div>
											</a>
											<h3 class="fs-5 text-muted m-0 pt-5 pb-5" data-kt-search-element="category-title">Customers</h3>
											<a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
												<div class="symbol symbol-40px me-4">
													<span class="symbol-label bg-light">
														<img class="w-20px h-20px" src="assets/media/svg/brand-logos/volicity-9.svg" alt="" />
													</span>
												</div>
												<div class="d-flex flex-column justify-content-start fw-semibold">
													<span class="fs-6 fw-semibold">Company Rbranding</span>
													<span class="fs-7 fw-semibold text-muted">UI Design</span>
												</div>
											</a>
											<a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
												<div class="symbol symbol-40px me-4">
													<span class="symbol-label bg-light">
														<img class="w-20px h-20px" src="assets/media/svg/brand-logos/tvit.svg" alt="" />
													</span>
												</div>
												<div class="d-flex flex-column justify-content-start fw-semibold">
													<span class="fs-6 fw-semibold">Company Re-branding</span>
													<span class="fs-7 fw-semibold text-muted">Web Development</span>
												</div>
											</a>
											<a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
												<div class="symbol symbol-40px me-4">
													<span class="symbol-label bg-light">
														<img class="w-20px h-20px" src="assets/media/svg/misc/infography.svg" alt="" />
													</span>
												</div>
												<div class="d-flex flex-column justify-content-start fw-semibold">
													<span class="fs-6 fw-semibold">Business Analytics App</span>
													<span class="fs-7 fw-semibold text-muted">Administration</span>
												</div>
											</a>
											<a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
												<div class="symbol symbol-40px me-4">
													<span class="symbol-label bg-light">
														<img class="w-20px h-20px" src="assets/media/svg/brand-logos/leaf.svg" alt="" />
													</span>
												</div>
												<div class="d-flex flex-column justify-content-start fw-semibold">
													<span class="fs-6 fw-semibold">EcoLeaf App Launch</span>
													<span class="fs-7 fw-semibold text-muted">Marketing</span>
												</div>
											</a>
											<a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
												<div class="symbol symbol-40px me-4">
													<span class="symbol-label bg-light">
														<img class="w-20px h-20px" src="assets/media/svg/brand-logos/tower.svg" alt="" />
													</span>
												</div>
												<div class="d-flex flex-column justify-content-start fw-semibold">
													<span class="fs-6 fw-semibold">Tower Group Website</span>
													<span class="fs-7 fw-semibold text-muted">Google Adwords</span>
												</div>
											</a>
											<h3 class="fs-5 text-muted m-0 pt-5 pb-5" data-kt-search-element="category-title">Projects</h3>
											<a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
												<div class="symbol symbol-40px me-4">
													<span class="symbol-label bg-light">
														<i class="ki-duotone ki-notepad fs-2 text-primary">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
															<span class="path4"></span>
															<span class="path5"></span>
														</i>
													</span>
												</div>
												<div class="d-flex flex-column">
													<span class="fs-6 fw-semibold">Si-Fi Project by AU Themes</span>
													<span class="fs-7 fw-semibold text-muted">#45670</span>
												</div>
											</a>
											<a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
												<div class="symbol symbol-40px me-4">
													<span class="symbol-label bg-light">
														<i class="ki-duotone ki-frame fs-2 text-primary">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
															<span class="path4"></span>
														</i>
													</span>
												</div>
												<div class="d-flex flex-column">
													<span class="fs-6 fw-semibold">Shopix Mobile App Planning</span>
													<span class="fs-7 fw-semibold text-muted">#45690</span>
												</div>
											</a>
											<a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
												<div class="symbol symbol-40px me-4">
													<span class="symbol-label bg-light">
														<i class="ki-duotone ki-message-text-2 fs-2 text-primary">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
														</i>
													</span>
												</div>
												<div class="d-flex flex-column">
													<span class="fs-6 fw-semibold">Finance Monitoring SAAS Discussion</span>
													<span class="fs-7 fw-semibold text-muted">#21090</span>
												</div>
											</a>
											<a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
												<div class="symbol symbol-40px me-4">
													<span class="symbol-label bg-light">
														<i class="ki-duotone ki-profile-circle fs-2 text-primary">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
														</i>
													</span>
												</div>
												<div class="d-flex flex-column">
													<span class="fs-6 fw-semibold">Dashboard Analitics Launch</span>
													<span class="fs-7 fw-semibold text-muted">#34560</span>
												</div>
											</a>
										</div>
									</div>
									<div class="mb-5" data-kt-search-element="main">
										<div class="d-flex flex-stack fw-semibold mb-4">
											<span class="text-muted fs-6 me-2">Recently Searched:</span>
										</div>
										<div class="scroll-y mh-200px mh-lg-325px">
											<div class="d-flex align-items-center mb-5">
												<div class="symbol symbol-40px me-4">
													<span class="symbol-label bg-light">
														<i class="ki-duotone ki-laptop fs-2 text-primary">
															<span class="path1"></span>
															<span class="path2"></span>
														</i>
													</span>
												</div>
												<div class="d-flex flex-column">
													<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold">BoomApp by Keenthemes</a>
													<span class="fs-7 text-muted fw-semibold">#45789</span>
												</div>
											</div>
											<div class="d-flex align-items-center mb-5">
												<div class="symbol symbol-40px me-4">
													<span class="symbol-label bg-light">
														<i class="ki-duotone ki-chart-simple fs-2 text-primary">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
															<span class="path4"></span>
														</i>
													</span>
												</div>
												<div class="d-flex flex-column">
													<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold">"Kept API Project Meeting</a>
													<span class="fs-7 text-muted fw-semibold">#84050</span>
												</div>
											</div>
											<div class="d-flex align-items-center mb-5">
												<div class="symbol symbol-40px me-4">
													<span class="symbol-label bg-light">
														<i class="ki-duotone ki-chart fs-2 text-primary">
															<span class="path1"></span>
															<span class="path2"></span>
														</i>
													</span>
												</div>
												<div class="d-flex flex-column">
													<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold">"KPI Monitoring App Launch</a>
													<span class="fs-7 text-muted fw-semibold">#84250</span>
												</div>
											</div>
											<div class="d-flex align-items-center mb-5">
												<div class="symbol symbol-40px me-4">
													<span class="symbol-label bg-light">
														<i class="ki-duotone ki-chart-line-down fs-2 text-primary">
															<span class="path1"></span>
															<span class="path2"></span>
														</i>
													</span>
												</div>
												<div class="d-flex flex-column">
													<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold">Project Reference FAQ</a>
													<span class="fs-7 text-muted fw-semibold">#67945</span>
												</div>
											</div>
											<div class="d-flex align-items-center mb-5">
												<div class="symbol symbol-40px me-4">
													<span class="symbol-label bg-light">
														<i class="ki-duotone ki-sms fs-2 text-primary">
															<span class="path1"></span>
															<span class="path2"></span>
														</i>
													</span>
												</div>
												<div class="d-flex flex-column">
													<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold">"FitPro App Development</a>
													<span class="fs-7 text-muted fw-semibold">#84250</span>
												</div>
											</div>
											<div class="d-flex align-items-center mb-5">
												<div class="symbol symbol-40px me-4">
													<span class="symbol-label bg-light">
														<i class="ki-duotone ki-bank fs-2 text-primary">
															<span class="path1"></span>
															<span class="path2"></span>
														</i>
													</span>
												</div>
												<div class="d-flex flex-column">
													<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold">Shopix Mobile App</a>
													<span class="fs-7 text-muted fw-semibold">#45690</span>
												</div>
											</div>
											<div class="d-flex align-items-center mb-5">
												<div class="symbol symbol-40px me-4">
													<span class="symbol-label bg-light">
														<i class="ki-duotone ki-chart-line-down fs-2 text-primary">
															<span class="path1"></span>
															<span class="path2"></span>
														</i>
													</span>
												</div>
												<div class="d-flex flex-column">
													<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold">"Landing UI Design" Launch</a>
													<span class="fs-7 text-muted fw-semibold">#24005</span>
												</div>
											</div>
										</div>
									</div>
									<div data-kt-search-element="empty" class="text-center d-none">
										<div class="pt-10 pb-10">
											<i class="ki-duotone ki-search-list fs-4x opacity-50">
												<span class="path1"></span>
												<span class="path2"></span>
												<span class="path3"></span>
											</i>
										</div>
										<div class="pb-15 fw-semibold">
											<h3 class="text-gray-600 fs-5 mb-2">No result found</h3>
											<div class="text-muted fs-7">Please try again with a different query</div>
										</div>
									</div>
								</div>
								<form data-kt-search-element="advanced-options-form" class="pt-1 d-none">
									<h3 class="fw-semibold text-gray-900 mb-7">Advanced Search</h3>
									<div class="mb-5">
										<input type="text" class="form-control form-control-sm form-control-solid" placeholder="Contains the word" name="query" />
									</div>
									<div class="mb-5">
										<div class="nav-group nav-group-fluid">
											<label>
												<input type="radio" class="btn-check" name="type" value="has" checked="checked" />
												<span class="btn btn-sm btn-color-muted btn-active btn-active-primary">All</span>
											</label>
											<label>
												<input type="radio" class="btn-check" name="type" value="users" />
												<span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Users</span>
											</label>
											<label>
												<input type="radio" class="btn-check" name="type" value="orders" />
												<span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Orders</span>
											</label>
											<label>
												<input type="radio" class="btn-check" name="type" value="projects" />
												<span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Projects</span>
											</label>
										</div>
									</div>
									<div class="mb-5">
										<input type="text" name="assignedto" class="form-control form-control-sm form-control-solid" placeholder="Assigned to" value="" />
									</div>
									<div class="mb-5">
										<input type="text" name="collaborators" class="form-control form-control-sm form-control-solid" placeholder="Collaborators" value="" />
									</div>
									<div class="mb-5">
										<div class="nav-group nav-group-fluid">
											<label>
												<input type="radio" class="btn-check" name="attachment" value="has" checked="checked" />
												<span class="btn btn-sm btn-color-muted btn-active btn-active-primary">Has attachment</span>
											</label>
											<label>
												<input type="radio" class="btn-check" name="attachment" value="any" />
												<span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Any</span>
											</label>
										</div>
									</div>
									<div class="mb-5">
										<select name="timezone" aria-label="Select a Timezone" data-control="select2" data-dropdown-parent="#kt_header_search" data-placeholder="date_period" class="form-select form-select-sm form-select-solid">
											<option value="next">Within the next</option>
											<option value="last">Within the last</option>
											<option value="between">Between</option>
											<option value="on">On</option>
										</select>
									</div>
									<div class="row mb-8">
										<div class="col-6">
											<input type="number" name="date_number" class="form-control form-control-sm form-control-solid" placeholder="Lenght" value="" />
										</div>
										<div class="col-6">
											<select name="date_typer" aria-label="Select a Timezone" data-control="select2" data-dropdown-parent="#kt_header_search" data-placeholder="Period" class="form-select form-select-sm form-select-solid">
												<option value="days">Days</option>
												<option value="weeks">Weeks</option>
												<option value="months">Months</option>
												<option value="years">Years</option>
											</select>
										</div>
									</div>
									<div class="d-flex justify-content-end">
										<button type="reset" class="btn btn-sm btn-light fw-bold btn-active-light-primary me-2" data-kt-search-element="advanced-options-form-cancel">Cancel</button>
										<a href="utilities/search/horizontal.html" class="btn btn-sm fw-bold btn-primary" data-kt-search-element="advanced-options-form-search">Search</a>
									</div>
								</form>
								<form data-kt-search-element="preferences" class="pt-1 d-none">
									<h3 class="fw-semibold text-gray-900 mb-7">Search Preferences</h3>
									<div class="pb-4 border-bottom">
										<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
											<span class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Projects</span>
											<input class="form-check-input" type="checkbox" value="1" checked="checked" />
										</label>
									</div>
									<div class="py-4 border-bottom">
										<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
											<span class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Targets</span>
											<input class="form-check-input" type="checkbox" value="1" checked="checked" />
										</label>
									</div>
									<div class="py-4 border-bottom">
										<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
											<span class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Affiliate Programs</span>
											<input class="form-check-input" type="checkbox" value="1" />
										</label>
									</div>
									<div class="py-4 border-bottom">
										<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
											<span class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Referrals</span>
											<input class="form-check-input" type="checkbox" value="1" checked="checked" />
										</label>
									</div>
									<div class="py-4 border-bottom">
										<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
											<span class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Users</span>
											<input class="form-check-input" type="checkbox" value="1" />
										</label>
									</div>
									<div class="d-flex justify-content-end pt-7">
										<button type="reset" class="btn btn-sm btn-light fw-bold btn-active-light-primary me-2" data-kt-search-element="preferences-dismiss">Cancel</button>
										<button type="submit" class="btn btn-sm fw-bold btn-primary">Save Changes</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="d-flex align-items-center ms-1 ms-lg-3">
						<a href="#" class="btn btn-icon btn-active-light-primary btn-custom w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
							<i class="ki-duotone ki-night-day theme-light-show fs-1">
								<span class="path1"></span>
								<span class="path2"></span>
								<span class="path3"></span>
								<span class="path4"></span>
								<span class="path5"></span>
								<span class="path6"></span>
								<span class="path7"></span>
								<span class="path8"></span>
								<span class="path9"></span>
								<span class="path10"></span>
							</i>
							<i class="ki-duotone ki-moon theme-dark-show fs-1">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
						</a>
						<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
							<div class="menu-item px-3 my-0">
								<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
									<span class="menu-icon" data-kt-element="icon">
										<i class="ki-duotone ki-night-day fs-2">
											<span class="path1"></span>
											<span class="path2"></span>
											<span class="path3"></span>
											<span class="path4"></span>
											<span class="path5"></span>
											<span class="path6"></span>
											<span class="path7"></span>
											<span class="path8"></span>
											<span class="path9"></span>
											<span class="path10"></span>
										</i>
									</span>
									<span class="menu-title">Light</span>
								</a>
							</div>
							<div class="menu-item px-3 my-0">
								<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
									<span class="menu-icon" data-kt-element="icon">
										<i class="ki-duotone ki-moon fs-2">
											<span class="path1"></span>
											<span class="path2"></span>
										</i>
									</span>
									<span class="menu-title">Dark</span>
								</a>
							</div>
							<div class="menu-item px-3 my-0">
								<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
									<span class="menu-icon" data-kt-element="icon">
										<i class="ki-duotone ki-screen fs-2">
											<span class="path1"></span>
											<span class="path2"></span>
											<span class="path3"></span>
											<span class="path4"></span>
										</i>
									</span>
									<span class="menu-title">System</span>
								</a>
							</div>
						</div>
					</div>
					<div class="d-flex align-items-center me-lg-n2 ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
						<div class="btn btn-icon btn-active-light-primary btn-custom w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
							<img class="h-30px w-30px rounded" src="assets/media/avatars/300-2.jpg" alt="" />
						</div>
						<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
							<div class="menu-item px-3">
								<div class="menu-content d-flex align-items-center px-3">
									<div class="symbol symbol-50px me-5">
										<img alt="Logo" src="assets/media/avatars/300-2.jpg" />
									</div>
									<div class="d-flex flex-column">
										<div class="fw-bold d-flex align-items-center fs-5">{{Auth::user()->name}} 
										<span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span></div>
										<a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{Auth::user()->email}} </a>
									</div>
								</div>
							</div>
							<div class="separator my-2"></div>
							<div class="menu-item px-5">
								<a href="account/overview.html" class="menu-link px-5">My Profile</a>
							</div>
							<div class="menu-item px-5">
								<a href="apps/projects/list.html" class="menu-link px-5">
									<span class="menu-text">My Projects</span>
									<span class="menu-badge">
										<span class="badge badge-light-danger badge-circle fw-bold fs-7">3</span>
									</span>
								</a>
							</div>
							<div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
								<a href="#" class="menu-link px-5">
									<span class="menu-title">My Subscription</span>
									<span class="menu-arrow"></span>
								</a>
								<div class="menu-sub menu-sub-dropdown w-175px py-4">
									<div class="menu-item px-3">
										<a href="account/referrals.html" class="menu-link px-5">Referrals</a>
									</div>
									<div class="menu-item px-3">
										<a href="account/billing.html" class="menu-link px-5">Billing</a>
									</div>
									<div class="menu-item px-3">
										<a href="account/statements.html" class="menu-link px-5">Payments</a>
									</div>
									<div class="menu-item px-3">
										<a href="account/statements.html" class="menu-link d-flex flex-stack px-5">Statements 
										<span class="ms-2 lh-0" data-bs-toggle="tooltip" title="View your statements">
											<i class="ki-duotone ki-information-5 fs-5">
												<span class="path1"></span>
												<span class="path2"></span>
												<span class="path3"></span>
											</i>
										</span></a>
									</div>
									<div class="separator my-2"></div>
									<div class="menu-item px-3">
										<div class="menu-content px-3">
											<label class="form-check form-switch form-check-custom form-check-solid">
												<input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications" />
												<span class="form-check-label text-muted fs-7">Notifications</span>
											</label>
										</div>
									</div>
								</div>
							</div>
							<div class="menu-item px-5">
								<a href="account/statements.html" class="menu-link px-5">My Statements</a>
							</div>
							<div class="separator my-2"></div>
							<div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
								<a href="#" class="menu-link px-5">
									<span class="menu-title position-relative">Language 
									<span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">English 
									<img class="w-15px h-15px rounded-1 ms-2" src="assets/media/flags/united-states.svg" alt="" /></span></span>
								</a>
								<div class="menu-sub menu-sub-dropdown w-175px py-4">
									<div class="menu-item px-3">
										<a href="account/settings.html" class="menu-link d-flex px-5 active">
										<span class="symbol symbol-20px me-4">
											<img class="rounded-1" src="assets/media/flags/united-states.svg" alt="" />
										</span>English</a>
									</div>
									<div class="menu-item px-3">
										<a href="account/settings.html" class="menu-link d-flex px-5">
										<span class="symbol symbol-20px me-4">
											<img class="rounded-1" src="assets/media/flags/spain.svg" alt="" />
										</span>Spanish</a>
									</div>
									<div class="menu-item px-3">
										<a href="account/settings.html" class="menu-link d-flex px-5">
										<span class="symbol symbol-20px me-4">
											<img class="rounded-1" src="assets/media/flags/germany.svg" alt="" />
										</span>German</a>
									</div>
									<div class="menu-item px-3">
										<a href="account/settings.html" class="menu-link d-flex px-5">
										<span class="symbol symbol-20px me-4">
											<img class="rounded-1" src="assets/media/flags/japan.svg" alt="" />
										</span>Japanese</a>
									</div>
									<div class="menu-item px-3">
										<a href="account/settings.html" class="menu-link d-flex px-5">
										<span class="symbol symbol-20px me-4">
											<img class="rounded-1" src="assets/media/flags/france.svg" alt="" />
										</span>French</a>
									</div>
								</div>
							</div>
							<div class="menu-item px-5 my-1">
								<a href="account/settings.html" class="menu-link px-5">Account Settings</a>
							</div>
							<div class="menu-item px-5">
								<a class="menu-link px-5" href="{{ route('logout') }}"
									onclick="event.preventDefault();
													document.getElementById('logout-form').submit();">
									<i class="nav-icon fas fa-power-off"></i>
									{{ __('Logout') }}
								</a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									@csrf
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@yield('content')

	<script>var hostUrl = "assets/";</script>
    <script src="assets/js/scripts.bundle.js"></script>
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="assets/js/custom/utilities/modals/create-app.js"></script>

    <script src="assets/plugins/global/plugins.bundle.js"></script>
</body>
</html>