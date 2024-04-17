@extends('layouts.main')
@section('title','Dashboard')
@section('content')
	<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
	<div class="d-flex flex-column flex-root">
		<div class="page d-flex flex-row flex-column-fluid">
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<div class="toolbar py-5 pb-lg-15" id="kt_toolbar">
					<div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
						<div class="page-title d-flex flex-column me-3">
							<h1 class="d-flex text-white fw-bold my-1 fs-3">Stream Design Studio | PMS Dashboard</h1>
							<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
								<li class="breadcrumb-item text-white opacity-75">
									<a href="index.html" class="text-white text-hover-primary">Home</a>
								</li>
								<li class="breadcrumb-item">
									<span class="bullet bg-white opacity-75 w-5px h-2px"></span>
								</li>
								<li class="breadcrumb-item text-white opacity-75">Dashboards</li>
							</ul>
						</div>
						<div class="d-flex align-items-center py-3 py-md-1">
							<!-- <div class="me-4">
								<a href="#" class="btn btn-custom btn-active-white btn-flex btn-color-white btn-active-color-white" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
								<i class="ki-duotone ki-filter fs-5 me-1">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>Filter</a>
								<div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_65a108d7082c4">
									<div class="px-7 py-5">
										<div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
									</div>
									<div class="separator border-gray-200"></div>
									<div class="px-7 py-5">
										<div class="mb-10">
											<label class="form-label fw-semibold">Status:</label>
											<div>
												<select class="form-select form-select-solid" multiple="multiple" data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option" data-dropdown-parent="#kt_menu_65a108d7082c4" data-allow-clear="true">
													<option></option>
													<option value="1">Approved</option>
													<option value="2">Pending</option>
													<option value="2">In Process</option>
													<option value="2">Rejected</option>
												</select>
											</div>
										</div>
										<div class="mb-10">
											<label class="form-label fw-semibold">Member Type:</label>
											<div class="d-flex">
												<label class="form-check form-check-sm form-check-custom form-check-solid me-5">
													<input class="form-check-input" type="checkbox" value="1" />
													<span class="form-check-label">Author</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid">
													<input class="form-check-input" type="checkbox" value="2" checked="checked" />
													<span class="form-check-label">Customer</span>
												</label>
											</div>
										</div>
										<div class="mb-10">
											<label class="form-label fw-semibold">Notifications:</label>
											<div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
												<input class="form-check-input" type="checkbox" value="" name="notifications" checked="checked" />
												<label class="form-check-label">Enabled</label>
											</div>
										</div>
										<div class="d-flex justify-content-end">
											<button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
											<button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
										</div>
									</div>
								</div>
							</div> -->
							<a href="#" data-bs-theme="light" class="btn bg-body btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app" id="kt_toolbar_primary_button">Create</a>
						</div>
					</div>
				</div>
				<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
					<div class="content flex-row-fluid" id="kt_content">
						 @if(session('success_message'))
                            <div class="alert alert-success alert-dismissible fade show mx-5 d-flex justify-content-between" role="alert">
                                <strong>{{ session('success_message') }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if(session('permission'))
                            <div class="alert alert-danger alert-dismissible fade show mx-5 d-flex justify-content-between" role="alert">
                                <strong>{{ session('permission') }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
						<div class="row g-5 g-xl-10 mb-xl-10">
							<div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
								<div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-center border-0 h-md-50 mb-5 mb-xl-10" style="background-color: #080655">
									<div class="card-header pt-5">
										<div class="card-title d-flex flex-column">
											<span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{$projects}}</span>
											<span class="text-white opacity-50 pt-1 fw-semibold fs-6">Active Projects</span>
										</div>
									</div>
									<div class="card-body d-flex align-items-end pt-0">
										<div class="d-flex align-items-center flex-column mt-3 w-100">
											<div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-50 w-100 mt-auto mb-2">
												<span>43 Pending</span>
												<span>72%</span>
											</div>
											<div class="h-8px mx-3 w-100 bg-light-danger rounded">
												<div class="bg-danger rounded h-8px" role="progressbar" style="width: 72%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="card card-flush h-md-50 mb-5 mb-xl-10">
									<div class="card-header pt-5">
										<div class="card-title d-flex flex-column">
											<span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">{{count($users)}}</span>
											<span class="text-gray-500 pt-1 fw-semibold fs-6">Professionals</span>
										</div>
									</div>
									<div class="card-body d-flex flex-column justify-content-end pe-0">
										<span class="fs-6 fw-bolder text-gray-800 d-block mb-2">Today’s Heroes</span>
										<div class="symbol-group symbol-hover flex-nowrap">
											@foreach($users as $key => $user)
												<div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="{{$user->name}}">
													@if($user->profile_pic)
														<img alt="Pic" src="{{asset('uploads/users/'.$user->profile_pic)}}" />
													@else
														<img src="{{asset('uploads/no_image1.png')}}" alt="image" style="object-fit: cover;"/>
													@endif
												</div>
											@endforeach
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
								<div class="card card-flush h-md-50 mb-5 mb-xl-10">
									<div class="card-header pt-5">
										<div class="card-title d-flex flex-column">
											<div class="d-flex align-items-center">
												<span class="fs-4 fw-semibold text-gray-500 me-1 align-self-start">Rs.</span>
												<span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">{{$project_price}}</span>
												<span class="badge badge-light-success fs-base">
												<i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>2.2%</span>
											</div>
											<span class="text-gray-500 pt-1 fw-semibold fs-6">Projects Earnings in April</span>
										</div>
									</div>
									<div class="card-body pt-2 pb-4 d-flex flex-wrap align-items-center">
										<div class="d-flex flex-center me-5 pt-2">
											<div id="kt_card_widget_17_chart" style="min-width: 70px; min-height: 70px" data-kt-size="70" data-kt-line="11"></div>
										</div>
										<div class="d-flex flex-column content-justify-center flex-row-fluid">
											<div class="d-flex fw-semibold align-items-center">
												<div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
												<div class="text-gray-500 flex-grow-1 me-4">Leaf CRM</div>
												<div class="fw-bolder text-gray-700 text-xxl-end">$7,660</div>
											</div>
											<div class="d-flex fw-semibold align-items-center my-3">
												<div class="bullet w-8px h-3px rounded-2 bg-primary me-3"></div>
												<div class="text-gray-500 flex-grow-1 me-4">Mivy App</div>
												<div class="fw-bolder text-gray-700 text-xxl-end">$2,820</div>
											</div>
											<div class="d-flex fw-semibold align-items-center">
												<div class="bullet w-8px h-3px rounded-2 me-3" style="background-color: #E4E6EF"></div>
												<div class="text-gray-500 flex-grow-1 me-4">Others</div>
												<div class="fw-bolder text-gray-700 text-xxl-end">$45,257</div>
											</div>
										</div>
									</div>
								</div>
								<div class="card card-flush h-lg-50">
									<div class="card-header pt-5">
										<h3 class="card-title text-gray-800">Highlights</h3>
										<div class="card-toolbar d-none">
											<div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left" class="btn btn-sm btn-light d-flex align-items-center px-4">
												<div class="text-gray-600 fw-bold">Loading date range...</div>
												<i class="ki-duotone ki-calendar-8 fs-1 ms-2 me-0">
													<span class="path1"></span>
													<span class="path2"></span>
													<span class="path3"></span>
													<span class="path4"></span>
													<span class="path5"></span>
													<span class="path6"></span>
												</i>
											</div>
										</div>
									</div>
									<div class="card-body pt-5">
										<div class="d-flex flex-stack">
											<div class="text-gray-700 fw-semibold fs-6 me-2">Avg. Client Rating</div>
											<div class="d-flex align-items-senter">
												<i class="ki-duotone ki-arrow-up-right fs-2 text-success me-2">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
												<span class="text-gray-900 fw-bolder fs-6">7.8</span>
												<span class="text-gray-500 fw-bold fs-6">/10</span>
											</div>
										</div>
										<div class="separator separator-dashed my-3"></div>
										<div class="d-flex flex-stack">
											<div class="text-gray-700 fw-semibold fs-6 me-2">Avg. Quotes</div>
											<div class="d-flex align-items-senter">
												<i class="ki-duotone ki-arrow-down-right fs-2 text-danger me-2">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
												<span class="text-gray-900 fw-bolder fs-6">730</span>
											</div>
										</div>
										<div class="separator separator-dashed my-3"></div>
										<div class="d-flex flex-stack">
											<div class="text-gray-700 fw-semibold fs-6 me-2">Avg. Agent Earnings</div>
											<div class="d-flex align-items-senter">
												<i class="ki-duotone ki-arrow-up-right fs-2 text-success me-2">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
												<span class="text-gray-900 fw-bolder fs-6">$2,309</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
					<div class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between">
						<div class="text-gray-900 order-2 order-md-1">
							<span class="text-muted fw-semibold me-1">2024&copy;</span>
							<a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Keenthemes</a>
						</div>
						<ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
							<li class="menu-item">
								<a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
							</li>
							<li class="menu-item">
								<a href="https://devs.keenthemes.com" target="_blank" class="menu-link px-2">Support</a>
							</li>
							<li class="menu-item">
								<a href="https://1.envato.market/EA4JP" target="_blank" class="menu-link px-2">Purchase</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
		<i class="ki-duotone ki-arrow-up">
			<span class="path1"></span>
			<span class="path2"></span>
		</i>
	</div>
	<div class="modal fade" id="kt_modal_create_app" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered mw-900px">
			<div class="modal-content">
				<div class="modal-header">
					<h2>Create Project</h2>
					<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</div>
				</div>
				<div class="modal-body py-lg-10 px-lg-10">
					<div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid" id="kt_modal_create_app_stepper">
						<div class="d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px">
							<div class="stepper-nav ps-lg-10">
								<div class="stepper-item current" data-kt-stepper-element="nav">
									<div class="stepper-wrapper">
										<div class="stepper-icon w-40px h-40px">
											<i class="ki-duotone ki-check stepper-check fs-2"></i>
											<span class="stepper-number">1</span>
										</div>
										<div class="stepper-label">
											<h3 class="stepper-title">Details</h3>
											<div class="stepper-desc">Name your Project</div>
										</div>
									</div>
									<div class="stepper-line h-40px"></div>
								</div>
								<div class="stepper-item" data-kt-stepper-element="nav">
									<div class="stepper-wrapper">
										<div class="stepper-icon w-40px h-40px">
											<i class="ki-duotone ki-check stepper-check fs-2"></i>
											<span class="stepper-number">2</span>
										</div>
										<div class="stepper-label">
											<h3 class="stepper-title">Frameworks</h3>
											<div class="stepper-desc">Define your Project framework</div>
										</div>
									</div>
									<div class="stepper-line h-40px"></div>
								</div>
								<div class="stepper-item" data-kt-stepper-element="nav">
									<div class="stepper-wrapper">
										<div class="stepper-icon w-40px h-40px">
											<i class="ki-duotone ki-check stepper-check fs-2"></i>
											<span class="stepper-number">3</span>
										</div>
										<div class="stepper-label">
											<h3 class="stepper-title">Database</h3>
											<div class="stepper-desc">Select the Project database type</div>
										</div>
									</div>
									<div class="stepper-line h-40px"></div>
								</div>
								<div class="stepper-item mark-completed" data-kt-stepper-element="nav">
									<div class="stepper-wrapper">
										<div class="stepper-icon w-40px h-40px">
											<i class="ki-duotone ki-check stepper-check fs-2"></i>
											<span class="stepper-number">4</span>
										</div>
										<div class="stepper-label">
											<h3 class="stepper-title">Completed</h3>
											<div class="stepper-desc">Review and Submit</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="flex-row-fluid py-lg-5 px-lg-15">
							<form class="form" id="form">
								<div class="current" data-kt-stepper-element="content">
									<div class="w-100">
										<div class="fv-row mb-10">
										@csrf
										<input type="hidden" name="action" value="store">
											<label class="d-flex align-items-center fs-5 fw-semibold mb-2">
												<span class="required">Project Name</span>
												<span class="ms-1" data-bs-toggle="tooltip" title="Specify your unique Project name">
													<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
													</i>
												</span>
											</label>
											<input type="text" class="form-control form-control-lg form-control-solid" name="name" placeholder="Staffing in motion" value="" />
										</div>

										<div class="fv-row mb-10">
											<label class="d-flex align-items-center fs-5 fw-semibold mb-2">
												<span class="required">Project Price</span>
												<span class="ms-1" data-bs-toggle="tooltip" title="Specify your Project Price">
													<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
													</i>
												</span>
											</label>
											<input type="number" class="form-control form-control-lg form-control-solid" name="price" min="1" placeholder="PKR." value="" />
										</div>

										<div class="fv-row mb-10">
											<label class="d-flex align-items-center fs-5 fw-semibold mb-2">
												<span>Project Description</span>
												<span class="ms-1" data-bs-toggle="tooltip" title="Specify your unique Project Description">
													<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
													</i>
												</span>
											</label>
											<textarea class="form-control form-control-lg form-control-solid" name="description" /></textarea>
										</div>

										<div class="fv-row">
											<div class="mb-10">
												<label class="form-label fw-semibold">Assign to team:</label>
												<div>
													<select class="form-select form-select-solid" name="assigned_to[]" multiple="multiple" data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option" data-allow-clear="true">
														<option></option>
														<option value="1">Approved</option>
														<option value="2">Pending</option>
														<option value="2">In Process</option>
														<option value="2">Rejected</option>
													</select>
												</div>
											</div>
										</div>

										<div class="fv-row" style="text-align:right">
											<div class="image-input image-input-outline" data-kt-image-input="true">
												<div class="image-input-wrapper w-125px h-125px" style="background-image: url('assets/media/dummy-image-green.jpg');background-size: cover;background-position: center;"></div>
												<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar" data-bs-original-title="Change avatar" data-kt-initialized="1">
													<i class="ki-duotone ki-pencil fs-7">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
													<input type="file" name="project_img" accept=".png, .jpg, .jpeg">
												</label>
												<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel avatar" data-bs-original-title="Cancel avatar" data-kt-initialized="1">
													<i class="ki-duotone ki-cross fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</span>
												<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove avatar" data-bs-original-title="Remove avatar" data-kt-initialized="1">
													<i class="ki-duotone ki-cross fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</span>
											</div>
										</div>

										<div class="fv-row">
											<label class="d-flex align-items-center fs-5 fw-semibold mb-4">
												<span class="required">Category</span>
												<span class="ms-1" data-bs-toggle="tooltip" title="Select your Project category">
													<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
													</i>
												</span>
											</label>
											<div class="fv-row">
												@foreach($categories as $key => $value)
													<label class="d-flex flex-stack mb-5 cursor-pointer">
														<span class="d-flex align-items-center me-2">
															<span class="symbol symbol-50px me-6">
																<span class="symbol-label bg-light-primary">
																	<i class="ki-duotone ki-compass fs-1 text-primary">
																		<span class="path1"></span>
																		<span class="path2"></span>
																	</i>
																</span>
															</span>
															<span class="d-flex flex-column">
																<span class="fw-bold fs-6">{{$value->name}}</span>
																<span class="fs-7 text-muted">{{$value->description}}</span>
															</span>
														</span>
														<span class="form-check form-check-custom form-check-solid">
															<input class="form-check-input" type="radio" name="project_category" value="{{$value->id}}" />
														</span>
													</label>
												@endforeach
											</div>
										</div>
									</div>
								</div>
								<div data-kt-stepper-element="content">
									<div class="w-100">
										<div class="fv-row">
											<label class="d-flex align-items-center fs-5 fw-semibold mb-4">
												<span class="required">Select Framework</span>
												<span class="ms-1" data-bs-toggle="tooltip" title="Specify your apps framework">
													<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
													</i>
												</span>
											</label>
											@foreach($framework as $key => $value)
												<label class="d-flex flex-stack cursor-pointer mb-5">
													<span class="d-flex align-items-center me-2">
														<span class="symbol symbol-50px me-6">
															<span class="symbol-label bg-light-warning">
																<i class="fa fa-code"></i>
															</span>
														</span>
														<span class="d-flex flex-column">
															<span class="fw-bold fs-6">{{$value->name}}</span>
															<span class="fs-7 text-muted">{{$value->description}}</span>
														</span>
													</span>
													<span class="form-check form-check-custom form-check-solid">
														<input class="form-check-input" type="radio" name="tech_stack" value="{{$value->id}}" />
													</span>
												</label>
											@endforeach
										</div>
									</div>
								</div>
								<div data-kt-stepper-element="content">
									<div class="w-100">
										<div class="fv-row mb-10">
											<label class="required fs-5 fw-semibold mb-2">Database Name</label>
											<input type="text" class="form-control form-control-lg form-control-solid" name="db_name" placeholder="master_db"  />
										</div>
									</div>
								</div>
								<div data-kt-stepper-element="content">
									<div class="w-100 text-center">
										<h1 class="fw-bold text-gray-900 mb-3">Release!</h1>
										<div class="text-muted fw-semibold fs-3">Submit your Project to kickstart your project.</div>
										<div class="text-center px-4 py-15">
											<img src="assets/media/illustrations/sigma-1/9.png" alt="" class="mw-100 mh-300px" />
										</div>
									</div>
								</div>
								<div class="d-flex flex-stack pt-10">
									<div class="me-2">
										<button type="button" class="btn btn-lg btn-light-primary me-3" data-kt-stepper-action="previous">
										<i class="ki-duotone ki-arrow-left fs-3 me-1">
											<span class="path1"></span>
											<span class="path2"></span>
										</i>Back</button>
									</div>
									<div>
										<button type="submit" class="btn btn-lg btn-primary" data-kt-stepper-action="submit">
											<span class="indicator-label">Submit 
											<i class="ki-duotone ki-arrow-right fs-3 ms-2 me-0">
												<span class="path1"></span>
												<span class="path2"></span>
											</i></span>
											<span class="indicator-progress">Please wait... 
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
										</button>
										<button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next">Continue 
										<i class="ki-duotone ki-arrow-right fs-3 ms-1 me-0">
											<span class="path1"></span>
											<span class="path2"></span>
										</i></button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script>
		$('#form').submit(function(e) {
			e.preventDefault();
			var formData = new FormData(this);
			$.ajax({
				type: 'POST',
				url: "{{ route('projects.store') }}",
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				success: (data) => {
					if(data.success){
						this.reset();
						toastr.success(data.success);
					}
				},
				error: function(data) {
					var txt         = '';
					console.log(data.responseJSON.errors[0])
					for (var key in data.responseJSON.errors) {
						txt += data.responseJSON.errors[key];
						txt +='<br>';
					}
					toastr.error(txt);
				}
			});
		});
	</script>
@endsection