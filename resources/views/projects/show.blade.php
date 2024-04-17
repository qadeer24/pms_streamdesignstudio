@extends('layouts.main')
@section('title','Projects')
@section('image_url', $project->project_img)
@section('content')	
		<div class="d-flex flex-column flex-root">
			<div class="page d-flex flex-row flex-column-fluid">
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<div class="toolbar py-5 pb-lg-15" id="kt_toolbar">
						<div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
							<div class="page-title d-flex flex-column me-3">
								<h1 class="d-flex text-white fw-bold my-1 fs-3">View Project</h1>
								<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
									<li class="breadcrumb-item text-white opacity-75">Projects</li>
									<li class="breadcrumb-item">
										<span class="bullet bg-white opacity-75 w-5px h-2px"></span>
									</li>
									<li class="breadcrumb-item text-white opacity-75">View Project</li>
								</ul>
							</div>
							<div class="d-flex align-items-center py-3 py-md-1">
								<a href="#" data-bs-theme="light" class="btn bg-body btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app" id="kt_toolbar_primary_button">Edit Project</a>&nbsp;
								<form action="{{ route('projects.destroy', $project) }}" method="POST">
									@csrf
    								@method('DELETE')
									<button type="submit" class="btn bg-body btn-active-color-primary">Delete</button>
								</form>
							</div>
						</div>
					</div>
					<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
						<div class="content flex-row-fluid" id="kt_content">
							@if(session('permission'))
				                <div class="alert alert-danger alert-dismissible fade show mx-5 d-flex justify-content-between" role="alert">
				                    <strong>{{ session('permission') }}</strong>
				                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				                        <span aria-hidden="true">&times;</span>
				                    </button>
				                </div>
				            @endif
							<div class="card mb-6 mb-xl-9">
								<div class="card-body pt-9 pb-0">
									<div class="d-flex flex-wrap flex-sm-nowrap mb-6">
										<div class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
											<img class="mw-100px mw-lg-150px" src="{{asset('uploads/projects/'.$project->project_img)}}" alt="image" />
										</div>
										<div class="flex-grow-1">
											<div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
												<div class="d-flex flex-column">
													<div class="d-flex align-items-center mb-1">
														<a href="javascript:void(0)" class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">{{$project->name}}</a>
														<span class="badge badge-light-success me-auto">{{$project->project_status}}</span>
													</div>
													<div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-500">{{$project->description}}</div>
												</div>
												<div class="d-flex mb-4">
													<a href="#" class="btn btn-sm btn-bg-light btn-active-color-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_create_task">Add Task</a>
													<a href="#" class="btn btn-sm btn-bg-light btn-active-color-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_users_search">Add User</a>
												</div>
											</div>
											<div class="d-flex flex-wrap justify-content-start">
												<div class="d-flex flex-wrap">
													<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
														<div class="d-flex align-items-center">
															<div class="fs-4 fw-bold">{{$project->deadline}}</div>
														</div>
														<div class="fw-semibold fs-6 text-gray-500">Due Date</div>
													</div>
													<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
														<div class="d-flex align-items-center">
															<div class="fs-4 fw-bold" data-kt-countup="true" data-kt-countup-value="{{$tasks->active_count}}">0</div>
														</div>
														<div class="fw-semibold fs-6 text-gray-500">Open Tasks</div>
													</div>
													<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
														<div class="d-flex align-items-center">
															<div class="fs-4 fw-bold" data-kt-countup="true" data-kt-countup-value="{{$project->project_price}}" data-kt-countup-prefix="$">0</div>
														</div>
														<div class="fw-semibold fs-6 text-gray-500">Project Budget</div>
													</div>
												</div>
												<div class="symbol-group symbol-hover mb-3">
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
								</div>
							</div>
							<div class="row gx-6 gx-xl-9">
								<div class="col-lg-6">
									<div class="card card-flush h-lg-100">
										<div class="card-header mt-6">
											<div class="card-title flex-column">
												<h3 class="fw-bold mb-1">Tasks Summary</h3>
												<div class="fs-6 fw-semibold text-gray-500">{{$tasks->overdue_count}} Overdue Tasks</div>
											</div>
											<div class="card-toolbar">
												<a href="{{route('tasks',['id'=> $project->id])}}" class="btn btn-light btn-sm">View Tasks</a>
											</div>
										</div>
										<div class="card-body p-9 pt-5">
											<div class="d-flex flex-wrap">
												<div class="position-relative d-flex flex-center h-175px w-175px me-15 mb-7">
													<div class="position-absolute translate-middle start-50 top-50 d-flex flex-column flex-center">
														<span class="fs-2qx fw-bold">{{$tasks->total_count}}</span>
														<span class="fs-6 fw-semibold text-gray-500">Total Tasks</span>
													</div>
													<canvas id="project_overview_chart"></canvas>
												</div>
												<div class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5">
													<div class="d-flex fs-6 fw-semibold align-items-center mb-3">
														<div class="bullet bg-primary me-3"></div>
														<div class="text-gray-500">Active</div>
														<div class="ms-auto fw-bold text-gray-700">{{$tasks->active_count}}</div>
													</div>
													<div class="d-flex fs-6 fw-semibold align-items-center mb-3">
														<div class="bullet bg-success me-3"></div>
														<div class="text-gray-500">Completed</div>
														<div class="ms-auto fw-bold text-gray-700">{{$tasks->completed_count}}</div>
													</div>
													<div class="d-flex fs-6 fw-semibold align-items-center mb-3">
														<div class="bullet bg-danger me-3"></div>
														<div class="text-gray-500">Overdue</div>
														<div class="ms-auto fw-bold text-gray-700">{{$tasks->overdue_count}}</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="card card-flush h-lg-100">
										<div class="card-header mt-6">
											<div class="card-title flex-column">
												<h3 class="fw-bold mb-1">What's on the road?</h3>
												<div class="fs-6 text-gray-500">Total 482 participants</div>
											</div>
											<div class="card-toolbar">
												<select name="status" data-control="select2" data-hide-search="true" class="form-select form-select-solid form-select-sm fw-bold w-100px">
													<option value="1" selected="selected">Options</option>
													<option value="2">Option 1</option>
													<option value="3">Option 2</option>
													<option value="4">Option 3</option>
												</select>
											</div>
										</div>
										<div class="card-body p-9 pt-4">
											<ul class="nav nav-pills d-flex flex-nowrap hover-scroll-x py-2">
												<li class="nav-item me-1">
													<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_0">
														<span class="opacity-50 fs-7 fw-semibold">Su</span>
														<span class="fs-6 fw-bold">22</span>
													</a>
												</li>
												<li class="nav-item me-1">
													<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary active" data-bs-toggle="tab" href="#kt_schedule_day_1">
														<span class="opacity-50 fs-7 fw-semibold">Mo</span>
														<span class="fs-6 fw-bold">23</span>
													</a>
												</li>
												<li class="nav-item me-1">
													<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_2">
														<span class="opacity-50 fs-7 fw-semibold">Tu</span>
														<span class="fs-6 fw-bold">24</span>
													</a>
												</li>
												<li class="nav-item me-1">
													<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_3">
														<span class="opacity-50 fs-7 fw-semibold">We</span>
														<span class="fs-6 fw-bold">25</span>
													</a>
												</li>
												<li class="nav-item me-1">
													<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_4">
														<span class="opacity-50 fs-7 fw-semibold">Th</span>
														<span class="fs-6 fw-bold">26</span>
													</a>
												</li>
												<li class="nav-item me-1">
													<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_5">
														<span class="opacity-50 fs-7 fw-semibold">Fr</span>
														<span class="fs-6 fw-bold">27</span>
													</a>
												</li>
												<li class="nav-item me-1">
													<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_6">
														<span class="opacity-50 fs-7 fw-semibold">Sa</span>
														<span class="fs-6 fw-bold">28</span>
													</a>
												</li>
												<li class="nav-item me-1">
													<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_7">
														<span class="opacity-50 fs-7 fw-semibold">Su</span>
														<span class="fs-6 fw-bold">29</span>
													</a>
												</li>
												<li class="nav-item me-1">
													<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_8">
														<span class="opacity-50 fs-7 fw-semibold">Mo</span>
														<span class="fs-6 fw-bold">30</span>
													</a>
												</li>
												<li class="nav-item me-1">
													<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_9">
														<span class="opacity-50 fs-7 fw-semibold">Tu</span>
														<span class="fs-6 fw-bold">31</span>
													</a>
												</li>
											</ul>
											<div class="tab-content">
												<div id="kt_schedule_day_0" class="tab-pane fade show">
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">9:00 - 10:00 
															<span class="fs-7 text-gray-500 text-uppercase">am</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Committee Review Approvals</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Caleb Donaldson</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">10:00 - 11:00 
															<span class="fs-7 text-gray-500 text-uppercase">am</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Development Team Capacity Review</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Michael Walters</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">16:30 - 17:30 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Sales Pitch Proposal</a>
															<div class="text-gray-500">Lead by 
															<a href="#">David Stevenson</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
												</div>
												<div id="kt_schedule_day_1" class="tab-pane fade show active">
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">12:00 - 13:00 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Team Backlog Grooming Session</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Bob Harris</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">10:00 - 11:00 
															<span class="fs-7 text-gray-500 text-uppercase">am</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Project Review & Testing</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Walter White</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">14:30 - 15:30 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Dashboard UI/UX Design Review</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Sean Bean</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
												</div>
												<div id="kt_schedule_day_2" class="tab-pane fade show">
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">12:00 - 13:00 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">9 Degree Project Estimation Meeting</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Terry Robins</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">13:00 - 14:00 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Marketing Campaign Discussion</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Bob Harris</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">16:30 - 17:30 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Development Team Capacity Review</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Naomi Hayabusa</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
												</div>
												<div id="kt_schedule_day_3" class="tab-pane fade show">
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">14:30 - 15:30 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Team Backlog Grooming Session</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Naomi Hayabusa</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">10:00 - 11:00 
															<span class="fs-7 text-gray-500 text-uppercase">am</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Dashboard UI/UX Design Review</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Sean Bean</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">14:30 - 15:30 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Dashboard UI/UX Design Review</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Walter White</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
												</div>
												<div id="kt_schedule_day_4" class="tab-pane fade show">
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">13:00 - 14:00 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Development Team Capacity Review</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Sean Bean</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">12:00 - 13:00 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Creative Content Initiative</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Bob Harris</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">14:30 - 15:30 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Project Review & Testing</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Naomi Hayabusa</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
												</div>
												<div id="kt_schedule_day_5" class="tab-pane fade show">
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">14:30 - 15:30 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Marketing Campaign Discussion</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Yannis Gloverson</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">16:30 - 17:30 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Dashboard UI/UX Design Review</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Walter White</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">16:30 - 17:30 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Team Backlog Grooming Session</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Peter Marcus</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
												</div>
												<div id="kt_schedule_day_6" class="tab-pane fade show">
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">14:30 - 15:30 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Marketing Campaign Discussion</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Yannis Gloverson</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">13:00 - 14:00 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Dashboard UI/UX Design Review</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Karina Clarke</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">14:30 - 15:30 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Marketing Campaign Discussion</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Mark Randall</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
												</div>
												<div id="kt_schedule_day_7" class="tab-pane fade show">
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">10:00 - 11:00 
															<span class="fs-7 text-gray-500 text-uppercase">am</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Marketing Campaign Discussion</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Bob Harris</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">16:30 - 17:30 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Sales Pitch Proposal</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Mark Randall</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">12:00 - 13:00 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Development Team Capacity Review</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Terry Robins</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
												</div>
												<div id="kt_schedule_day_8" class="tab-pane fade show">
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">12:00 - 13:00 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Dashboard UI/UX Design Review</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Caleb Donaldson</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">11:00 - 11:45 
															<span class="fs-7 text-gray-500 text-uppercase">am</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Weekly Team Stand-Up</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Kendell Trevor</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">9:00 - 10:00 
															<span class="fs-7 text-gray-500 text-uppercase">am</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Sales Pitch Proposal</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Sean Bean</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
												</div>
												<div id="kt_schedule_day_9" class="tab-pane fade show">
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">12:00 - 13:00 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Creative Content Initiative</a>
															<div class="text-gray-500">Lead by 
															<a href="#">David Stevenson</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">13:00 - 14:00 
															<span class="fs-7 text-gray-500 text-uppercase">pm</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Team Backlog Grooming Session</a>
															<div class="text-gray-500">Lead by 
															<a href="#">David Stevenson</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
													<div class="d-flex flex-stack position-relative mt-8">
														<div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
														<div class="fw-semibold ms-5 text-gray-600">
															<div class="fs-5">11:00 - 11:45 
															<span class="fs-7 text-gray-500 text-uppercase">am</span></div>
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Project Review & Testing</a>
															<div class="text-gray-500">Lead by 
															<a href="#">Sean Bean</a></div>
														</div>
														<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="card card-flush h-lg-100">
										<div class="card-header mt-6">
											<div class="card-title flex-column">
												<h3 class="fw-bold mb-1">Latest Files</h3>
												<div class="fs-6 text-gray-500">Total 382 fiels, 2,6GB space usage</div>
											</div>
											<div class="card-toolbar">
												<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View All</a>
											</div>
										</div>
										<div class="card-body p-9 pt-3">
											<div class="d-flex flex-column mb-9">
												<div class="d-flex align-items-center mb-5">
													<div class="symbol symbol-30px me-5">
														<img alt="Icon" src="assets/media/svg/files/pdf.svg" />
													</div>
													<div class="fw-semibold">
														<a class="fs-6 fw-bold text-gray-900 text-hover-primary" href="#">Project tech requirements</a>
														<div class="text-gray-500">2 days ago 
														<a href="#">Karina Clark</a></div>
													</div>
													<button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-primary btn-active-light-primary ms-auto" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
														<i class="ki-duotone ki-element-plus fs-3">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
															<span class="path4"></span>
															<span class="path5"></span>
														</i>
													</button>
													<div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_65a108d926473">
														<div class="px-7 py-5">
															<div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
														</div>
														<div class="separator border-gray-200"></div>
														<div class="px-7 py-5">
															<div class="mb-10">
																<label class="form-label fw-semibold">Status:</label>
																<div>
																	<select class="form-select form-select-solid" multiple="multiple" data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option" data-dropdown-parent="#kt_menu_65a108d926473" data-allow-clear="true">
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
												</div>
												<div class="d-flex align-items-center mb-5">
													<div class="symbol symbol-30px me-5">
														<img alt="Icon" src="assets/media/svg/files/doc.svg" />
													</div>
													<div class="fw-semibold">
														<a class="fs-6 fw-bold text-gray-900 text-hover-primary" href="#">Create FureStibe branding proposal</a>
														<div class="text-gray-500">Due in 1 day 
														<a href="#">Marcus Blake</a></div>
													</div>
													<button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-primary btn-active-light-primary ms-auto" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
														<i class="ki-duotone ki-element-plus fs-3">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
															<span class="path4"></span>
															<span class="path5"></span>
														</i>
													</button>
													<div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_65a108d92647a">
														<div class="px-7 py-5">
															<div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
														</div>
														<div class="separator border-gray-200"></div>
														<div class="px-7 py-5">
															<div class="mb-10">
																<label class="form-label fw-semibold">Status:</label>
																<div>
																	<select class="form-select form-select-solid" multiple="multiple" data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option" data-dropdown-parent="#kt_menu_65a108d92647a" data-allow-clear="true">
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
												</div>
												<div class="d-flex align-items-center mb-5">
													<div class="symbol symbol-30px me-5">
														<img alt="Icon" src="assets/media/svg/files/css.svg" />
													</div>
													<div class="fw-semibold">
														<a class="fs-6 fw-bold text-gray-900 text-hover-primary" href="#">Completed Project Stylings</a>
														<div class="text-gray-500">Due in 1 day 
														<a href="#">Terry Barry</a></div>
													</div>
													<button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-primary btn-active-light-primary ms-auto" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
														<i class="ki-duotone ki-element-plus fs-3">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
															<span class="path4"></span>
															<span class="path5"></span>
														</i>
													</button>
													<div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_65a108d926481">
														<div class="px-7 py-5">
															<div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
														</div>
														<div class="separator border-gray-200"></div>
														<div class="px-7 py-5">
															<div class="mb-10">
																<label class="form-label fw-semibold">Status:</label>
																<div>
																	<select class="form-select form-select-solid" multiple="multiple" data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option" data-dropdown-parent="#kt_menu_65a108d926481" data-allow-clear="true">
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
												</div>
												<div class="d-flex align-items-center">
													<div class="symbol symbol-30px me-5">
														<img alt="Icon" src="assets/media/svg/files/ai.svg" />
													</div>
													<div class="fw-semibold">
														<a class="fs-6 fw-bold text-gray-900 text-hover-primary" href="#">Create Project Wireframes</a>
														<div class="text-gray-500">Due in 3 days 
														<a href="#">Roth Bloom</a></div>
													</div>
													<button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-primary btn-active-light-primary ms-auto" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
														<i class="ki-duotone ki-element-plus fs-3">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
															<span class="path4"></span>
															<span class="path5"></span>
														</i>
													</button>
													<div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_65a108d926487">
														<div class="px-7 py-5">
															<div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
														</div>
														<div class="separator border-gray-200"></div>
														<div class="px-7 py-5">
															<div class="mb-10">
																<label class="form-label fw-semibold">Status:</label>
																<div>
																	<select class="form-select form-select-solid" multiple="multiple" data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option" data-dropdown-parent="#kt_menu_65a108d926487" data-allow-clear="true">
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
												</div>
											</div>
											<div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6">
												<i class="ki-duotone ki-svg/files/upload.svg fs-2tx text-primary me-4"></i>
												<div class="d-flex flex-stack flex-grow-1">
													<div class="fw-semibold">
														<h4 class="text-gray-900 fw-bold">Quick file uploader</h4>
														<div class="fs-6 text-gray-700">Drag & Drop or choose files from computer</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="card card-flush h-lg-100">
										<div class="card-header mt-6">
											<div class="card-title flex-column">
												<h3 class="fw-bold mb-1">Comments</h3>
											</div>
											<div class="card-toolbar">
												<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View All</a>
											</div>
										</div>
										<div class="card-body d-flex flex-column p-9 pt-3 mb-9"  style="height: 400px; overflow-y: scroll;" id="commentsContainer">
										   	@foreach($comments as $key => $comment)
											    @if(isset($comment->user))
											        <div class="d-flex mb-5">
											            <div class="me-5 position-relative">
											                <div class="symbol symbol-35px symbol-circle">
											                    @if(isset($comment->user->profile_pic) || $comment->user->profile_pic != "")
											                        <img src="{{asset('uploads/users/'.$comment->user->profile_pic)}}" alt="image" style="object-fit: cover;"/>
											                    @else
											                        <img src="{{asset('uploads/no_image1.png')}}" alt="image" style="object-fit: cover;"/>
											                    @endif
											                    <div class="bg-success position-absolute h-8px w-8px rounded-circle translate-middle start-100 top-100 ms-n1 mt-n1"></div>
											                </div>
											            </div>
											            <div class="fw-semibold w-50 p-4" style="border-radius: 10px; background-color: #efefef;">
											                <a href="{{route('user.view',['user'=>$comment->user->id])}}" class="fs-5 fw-bold text-gray-900 text-hover-primary">@if(Auth::user()->name == $comment->user->name) You @else {{$comment->user->name}} @endif</a>
											                <div class="mt-2">
											                    {{$comment->comment}}
											                </div><br>
											                <div style="width: 100%;">
											                   	@if($comment->comment_file)
																    @if(preg_match('/\.(jpg|jpeg|png|gif)$/i', $comment->comment_file))
																        <img src="{{asset('uploads/comments/'.$comment->comment_file)}}" width="100%">
																    @else
																        <a href="{{asset('uploads/comments/'.$comment->comment_file)}}" target="_blank">Download ({{$comment->comment_file}})</a>
																    @endif
																@endif

											                </div>
											            </div>
											        </div>
											    @endif
											@endforeach
										</div>
										<form id="comment_module" enctype="multipart/form-data">
											@csrf
											<input type="hidden" name="project_id" value="{{$project->id}}">
											<div id="file_preview_container" class="ml-5" style="width:100px; border-radius: 20px;"></div>
										    <div class="d-flex align-items-baseline">
										        <label for="comment_file" class="position-relative">
										            <i class="fa fa-paperclip cursor-pointer" style="font-size: 18px; padding: 20px 10px 10px 10px;" aria-hidden="true"></i>
										            <input id="comment_file" type="file" name="comment_file" class="d-none" onchange="previewFile()">
										        </label>
										        <input type="name" id="comment_input" placeholder="Type your comment..." class="form-control" name="comment">
										        <button class="btn btn-primary ml-2">Send</button>
										    </div>
										</form>
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
		<div id="kt_activities" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="activities" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'lg': '900px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_activities_toggle" data-kt-drawer-close="#kt_activities_close">
			<div class="card shadow-none border-0 rounded-0">
				<div class="card-header" id="kt_activities_header">
					<h3 class="card-title fw-bold text-gray-900">Activity Logs</h3>
					<div class="card-toolbar">
						<button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="kt_activities_close">
							<i class="ki-duotone ki-cross fs-1">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
						</button>
					</div>
				</div>
				<div class="card-body position-relative" id="kt_activities_body">
					<div id="kt_activities_scroll" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_activities_body" data-kt-scroll-dependencies="#kt_activities_header, #kt_activities_footer" data-kt-scroll-offset="5px">
						<div class="timeline timeline-border-dashed">
							<div class="timeline-item">
								<div class="timeline-line"></div>
								<div class="timeline-icon">
									<i class="ki-duotone ki-message-text-2 fs-2 text-gray-500">
										<span class="path1"></span>
										<span class="path2"></span>
										<span class="path3"></span>
									</i>
								</div>
								<div class="timeline-content mb-10 mt-n1">
									<div class="pe-3 mb-5">
										<div class="fs-5 fw-semibold mb-2">There are 2 new tasks for you in “AirPlus Mobile App” project:</div>
										<div class="d-flex align-items-center mt-1 fs-6">
											<div class="text-muted me-2 fs-7">Added at 4:23 PM by</div>
											<div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip" data-bs-boundary="window" data-bs-placement="top" title="Nina Nilson">
												<img src="assets/media/avatars/300-14.jpg" alt="img" />
											</div>
										</div>
									</div>
									<div class="overflow-auto pb-5">
										<div class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-750px px-7 py-3 mb-5">
											<a href="apps/projects/project.html" class="fs-5 text-gray-900 text-hover-primary fw-semibold w-375px min-w-200px">Meeting with customer</a>
											<div class="min-w-175px pe-2">
												<span class="badge badge-light text-muted">Application Design</span>
											</div>
											<div class="symbol-group symbol-hover flex-nowrap flex-grow-1 min-w-100px pe-2">
												<div class="symbol symbol-circle symbol-25px">
													<img src="assets/media/avatars/300-2.jpg" alt="img" />
												</div>
												<div class="symbol symbol-circle symbol-25px">
													<img src="assets/media/avatars/300-14.jpg" alt="img" />
												</div>
												<div class="symbol symbol-circle symbol-25px">
													<div class="symbol-label fs-8 fw-semibold bg-primary text-inverse-primary">A</div>
												</div>
											</div>
											<div class="min-w-125px pe-2">
												<span class="badge badge-light-primary">In Progress</span>
											</div>
											<a href="apps/projects/project.html" class="btn btn-sm btn-light btn-active-light-primary">View</a>
										</div>
										<div class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-750px px-7 py-3 mb-0">
											<a href="apps/projects/project.html" class="fs-5 text-gray-900 text-hover-primary fw-semibold w-375px min-w-200px">Project Delivery Preparation</a>
											<div class="min-w-175px">
												<span class="badge badge-light text-muted">CRM System Development</span>
											</div>
											<div class="symbol-group symbol-hover flex-nowrap flex-grow-1 min-w-100px">
												<div class="symbol symbol-circle symbol-25px">
													<img src="assets/media/avatars/300-20.jpg" alt="img" />
												</div>
												<div class="symbol symbol-circle symbol-25px">
													<div class="symbol-label fs-8 fw-semibold bg-success text-inverse-primary">B</div>
												</div>
											</div>
											<div class="min-w-125px">
												<span class="badge badge-light-success">Completed</span>
											</div>
											<a href="apps/projects/project.html" class="btn btn-sm btn-light btn-active-light-primary">View</a>
										</div>
									</div>
								</div>
							</div>
							<div class="timeline-item">
								<div class="timeline-line"></div>
								<div class="timeline-icon me-4">
									<i class="ki-duotone ki-flag fs-2 text-gray-500">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
								</div>
								<div class="timeline-content mb-10 mt-n2">
									<div class="overflow-auto pe-3">
										<div class="fs-5 fw-semibold mb-2">Invitation for crafting engaging designs that speak human workshop</div>
										<div class="d-flex align-items-center mt-1 fs-6">
											<div class="text-muted me-2 fs-7">Sent at 4:23 PM by</div>
											<div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip" data-bs-boundary="window" data-bs-placement="top" title="Alan Nilson">
												<img src="assets/media/avatars/300-1.jpg" alt="img" />
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="timeline-item">
								<div class="timeline-line"></div>
								<div class="timeline-icon">
									<i class="ki-duotone ki-disconnect fs-2 text-gray-500">
										<span class="path1"></span>
										<span class="path2"></span>
										<span class="path3"></span>
										<span class="path4"></span>
										<span class="path5"></span>
									</i>
								</div>
								<div class="timeline-content mb-10 mt-n1">
									<div class="mb-5 pe-3">
										<a href="#" class="fs-5 fw-semibold text-gray-800 text-hover-primary mb-2">3 New Incoming Project Files:</a>
										<div class="d-flex align-items-center mt-1 fs-6">
											<div class="text-muted me-2 fs-7">Sent at 10:30 PM by</div>
											<div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip" data-bs-boundary="window" data-bs-placement="top" title="Jan Hummer">
												<img src="assets/media/avatars/300-23.jpg" alt="img" />
											</div>
										</div>
									</div>
									<div class="overflow-auto pb-5">
										<div class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-700px p-5">
											<div class="d-flex flex-aligns-center pe-10 pe-lg-20">
												<img alt="" class="w-30px me-3" src="assets/media/svg/files/pdf.svg" />
												<div class="ms-1 fw-semibold">
													<a href="apps/projects/project.html" class="fs-6 text-hover-primary fw-bold">Finance KPI App Guidelines</a>
													<div class="text-gray-500">1.9mb</div>
												</div>
											</div>
											<div class="d-flex flex-aligns-center pe-10 pe-lg-20">
												<img alt="apps/projects/project.html" class="w-30px me-3" src="assets/media/svg/files/doc.svg" />
												<div class="ms-1 fw-semibold">
													<a href="#" class="fs-6 text-hover-primary fw-bold">Client UAT Testing Results</a>
													<div class="text-gray-500">18kb</div>
												</div>
											</div>
											<div class="d-flex flex-aligns-center">
												<img alt="apps/projects/project.html" class="w-30px me-3" src="assets/media/svg/files/css.svg" />
												<div class="ms-1 fw-semibold">
													<a href="#" class="fs-6 text-hover-primary fw-bold">Finance Reports</a>
													<div class="text-gray-500">20mb</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="timeline-item">
								<div class="timeline-line"></div>
								<div class="timeline-icon">
									<i class="ki-duotone ki-abstract-26 fs-2 text-gray-500">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
								</div>
								<div class="timeline-content mb-10 mt-n1">
									<div class="pe-3 mb-5">
										<div class="fs-5 fw-semibold mb-2">Task 
										<a href="#" class="text-primary fw-bold me-1">#45890</a>merged with 
										<a href="#" class="text-primary fw-bold me-1">#45890</a>in “Ads Pro Admin Dashboard project:</div>
										<div class="d-flex align-items-center mt-1 fs-6">
											<div class="text-muted me-2 fs-7">Initiated at 4:23 PM by</div>
											<div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip" data-bs-boundary="window" data-bs-placement="top" title="Nina Nilson">
												<img src="assets/media/avatars/300-14.jpg" alt="img" />
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="timeline-item">
								<div class="timeline-line"></div>
								<div class="timeline-icon">
									<i class="ki-duotone ki-pencil fs-2 text-gray-500">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
								</div>
								<div class="timeline-content mb-10 mt-n1">
									<div class="pe-3 mb-5">
										<div class="fs-5 fw-semibold mb-2">3 new application design concepts added:</div>
										<div class="d-flex align-items-center mt-1 fs-6">
											<div class="text-muted me-2 fs-7">Created at 4:23 PM by</div>
											<div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip" data-bs-boundary="window" data-bs-placement="top" title="Marcus Dotson">
												<img src="assets/media/avatars/300-2.jpg" alt="img" />
											</div>
										</div>
									</div>
									<div class="overflow-auto pb-5">
										<div class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-700px p-7">
											<div class="overlay me-10">
												<div class="overlay-wrapper">
													<img alt="img" class="rounded w-150px" src="assets/media/stock/600x400/img-29.jpg" />
												</div>
												<div class="overlay-layer bg-dark bg-opacity-10 rounded">
													<a href="#" class="btn btn-sm btn-primary btn-shadow">Explore</a>
												</div>
											</div>
											<div class="overlay me-10">
												<div class="overlay-wrapper">
													<img alt="img" class="rounded w-150px" src="assets/media/stock/600x400/img-31.jpg" />
												</div>
												<div class="overlay-layer bg-dark bg-opacity-10 rounded">
													<a href="#" class="btn btn-sm btn-primary btn-shadow">Explore</a>
												</div>
											</div>
											<div class="overlay">
												<div class="overlay-wrapper">
													<img alt="img" class="rounded w-150px" src="assets/media/stock/600x400/img-40.jpg" />
												</div>
												<div class="overlay-layer bg-dark bg-opacity-10 rounded">
													<a href="#" class="btn btn-sm btn-primary btn-shadow">Explore</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="timeline-item">
								<div class="timeline-line"></div>
								<div class="timeline-icon">
									<i class="ki-duotone ki-sms fs-2 text-gray-500">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
								</div>
								<div class="timeline-content mb-10 mt-n1">
									<div class="pe-3 mb-5">
										<div class="fs-5 fw-semibold mb-2">New case 
										<a href="#" class="text-primary fw-bold me-1">#67890</a>is assigned to you in Multi-platform Database Design project</div>
										<div class="overflow-auto pb-5">
											<div class="d-flex align-items-center mt-1 fs-6">
												<div class="text-muted me-2 fs-7">Added at 4:23 PM by</div>
												<a href="#" class="text-primary fw-bold me-1">Alice Tan</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="timeline-item">
								<div class="timeline-line"></div>
								<div class="timeline-icon">
									<i class="ki-duotone ki-pencil fs-2 text-gray-500">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
								</div>
								<div class="timeline-content mb-10 mt-n1">
									<div class="pe-3 mb-5">
										<div class="fs-5 fw-semibold mb-2">You have received a new order:</div>
										<div class="d-flex align-items-center mt-1 fs-6">
											<div class="text-muted me-2 fs-7">Placed at 5:05 AM by</div>
											<div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip" data-bs-boundary="window" data-bs-placement="top" title="Robert Rich">
												<img src="assets/media/avatars/300-4.jpg" alt="img" />
											</div>
										</div>
									</div>
									<div class="overflow-auto pb-5">
										<div class="notice d-flex bg-light-primary rounded border-primary border border-dashed min-w-lg-600px flex-shrink-0 p-6">
											<i class="ki-duotone ki-devices-2 fs-2tx text-primary me-4">
												<span class="path1"></span>
												<span class="path2"></span>
												<span class="path3"></span>
											</i>
											<div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
												<div class="mb-3 mb-md-0 fw-semibold">
													<h4 class="text-gray-900 fw-bold">Database Backup Process Completed!</h4>
													<div class="fs-6 text-gray-700 pe-7">Login into Admin Dashboard to make sure the data integrity is OK</div>
												</div>
												<a href="#" class="btn btn-primary px-6 align-self-center text-nowrap">Proceed</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="timeline-item">
								<div class="timeline-line"></div>
								<div class="timeline-icon">
									<i class="ki-duotone ki-basket fs-2 text-gray-500">
										<span class="path1"></span>
										<span class="path2"></span>
										<span class="path3"></span>
										<span class="path4"></span>
									</i>
								</div>
								<div class="timeline-content mt-n1">
									<div class="pe-3 mb-5">
										<div class="fs-5 fw-semibold mb-2">New order 
										<a href="#" class="text-primary fw-bold me-1">#67890</a>is placed for Workshow Planning & Budget Estimation</div>
										<div class="d-flex align-items-center mt-1 fs-6">
											<div class="text-muted me-2 fs-7">Placed at 4:23 PM by</div>
											<a href="#" class="text-primary fw-bold me-1">Jimmy Bold</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer py-5 text-center" id="kt_activities_footer">
					<a href="pages/user-profile/activity.html" class="btn btn-bg-body text-primary">View All Activities 
					<i class="ki-duotone ki-arrow-right fs-3 text-primary">
						<span class="path1"></span>
						<span class="path2"></span>
					</i></a>
				</div>
			</div>
		</div>
		<div id="kt_drawer_chat" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="chat" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'md': '500px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_drawer_chat_toggle" data-kt-drawer-close="#kt_drawer_chat_close">
			<div class="card w-100 border-0 rounded-0" id="kt_drawer_chat_messenger">
				<div class="card-header pe-5" id="kt_drawer_chat_messenger_header">
					<div class="card-title">
						<div class="d-flex justify-content-center flex-column me-3">
							<a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1">Brian Cox</a>
							<div class="mb-0 lh-1">
								<span class="badge badge-success badge-circle w-10px h-10px me-1"></span>
								<span class="fs-7 fw-semibold text-muted">Active</span>
							</div>
						</div>
					</div>
					<div class="card-toolbar">
						<div class="me-0">
							<button class="btn btn-sm btn-icon btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
								<i class="ki-duotone ki-dots-square fs-2">
									<span class="path1"></span>
									<span class="path2"></span>
									<span class="path3"></span>
									<span class="path4"></span>
								</i>
							</button>
							<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
								<div class="menu-item px-3">
									<div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Contacts</div>
								</div>
								<div class="menu-item px-3">
									<a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_users_search">Add Contact</a>
								</div>
								<div class="menu-item px-3">
									<a href="#" class="menu-link flex-stack px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends">Invite Contacts 
									<span class="ms-2" data-bs-toggle="tooltip" title="Specify a contact email to send an invitation">
										<i class="ki-duotone ki-information fs-7">
											<span class="path1"></span>
											<span class="path2"></span>
											<span class="path3"></span>
										</i>
									</span></a>
								</div>
								<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
									<a href="#" class="menu-link px-3">
										<span class="menu-title">Groups</span>
										<span class="menu-arrow"></span>
									</a>
									<div class="menu-sub menu-sub-dropdown w-175px py-4">
										<div class="menu-item px-3">
											<a href="#" class="menu-link px-3" data-bs-toggle="tooltip" title="Coming soon">Create Group</a>
										</div>
										<div class="menu-item px-3">
											<a href="#" class="menu-link px-3" data-bs-toggle="tooltip" title="Coming soon">Invite Members</a>
										</div>
										<div class="menu-item px-3">
											<a href="#" class="menu-link px-3" data-bs-toggle="tooltip" title="Coming soon">Settings</a>
										</div>
									</div>
								</div>
								<div class="menu-item px-3 my-1">
									<a href="#" class="menu-link px-3" data-bs-toggle="tooltip" title="Coming soon">Settings</a>
								</div>
							</div>
						</div>
						<div class="btn btn-sm btn-icon btn-active-color-primary" id="kt_drawer_chat_close">
							<i class="ki-duotone ki-cross-square fs-2">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
						</div>
					</div>
				</div>
				<div class="card-body" id="kt_drawer_chat_messenger_body">
					<div class="scroll-y me-n5 pe-5" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_drawer_chat_messenger_header, #kt_drawer_chat_messenger_footer" data-kt-scroll-wrappers="#kt_drawer_chat_messenger_body" data-kt-scroll-offset="0px">
						<div class="d-flex justify-content-start mb-10">
							<div class="d-flex flex-column align-items-start">
								<div class="d-flex align-items-center mb-2">
									<div class="symbol symbol-35px symbol-circle">
										<img alt="Pic" src="assets/media/avatars/300-25.jpg" />
									</div>
									<div class="ms-3">
										<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
										<span class="text-muted fs-7 mb-1">2 mins</span>
									</div>
								</div>
								<div class="p-5 rounded bg-light-info text-gray-900 fw-semibold mw-lg-400px text-start" data-kt-element="message-text">How likely are you to recommend our company to your friends and family ?</div>
							</div>
						</div>
						<div class="d-flex justify-content-end mb-10">
							<div class="d-flex flex-column align-items-end">
								<div class="d-flex align-items-center mb-2">
									<div class="me-3">
										<span class="text-muted fs-7 mb-1">5 mins</span>
										<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
									</div>
									<div class="symbol symbol-35px symbol-circle">
										<img alt="Pic" src="assets/media/avatars/300-1.jpg" />
									</div>
								</div>
								<div class="p-5 rounded bg-light-primary text-gray-900 fw-semibold mw-lg-400px text-end" data-kt-element="message-text">Hey there, we’re just writing to let you know that you’ve been subscribed to a repository on GitHub.</div>
							</div>
						</div>
						<div class="d-flex justify-content-start mb-10">
							<div class="d-flex flex-column align-items-start">
								<div class="d-flex align-items-center mb-2">
									<div class="symbol symbol-35px symbol-circle">
										<img alt="Pic" src="assets/media/avatars/300-25.jpg" />
									</div>
									<div class="ms-3">
										<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
										<span class="text-muted fs-7 mb-1">1 Hour</span>
									</div>
								</div>
								<div class="p-5 rounded bg-light-info text-gray-900 fw-semibold mw-lg-400px text-start" data-kt-element="message-text">Ok, Understood!</div>
							</div>
						</div>
						<div class="d-flex justify-content-end mb-10">
							<div class="d-flex flex-column align-items-end">
								<div class="d-flex align-items-center mb-2">
									<div class="me-3">
										<span class="text-muted fs-7 mb-1">2 Hours</span>
										<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
									</div>
									<div class="symbol symbol-35px symbol-circle">
										<img alt="Pic" src="assets/media/avatars/300-1.jpg" />
									</div>
								</div>
								<div class="p-5 rounded bg-light-primary text-gray-900 fw-semibold mw-lg-400px text-end" data-kt-element="message-text">You’ll receive notifications for all issues, pull requests!</div>
							</div>
						</div>
						<div class="d-flex justify-content-start mb-10">
							<div class="d-flex flex-column align-items-start">
								<div class="d-flex align-items-center mb-2">
									<div class="symbol symbol-35px symbol-circle">
										<img alt="Pic" src="assets/media/avatars/300-25.jpg" />
									</div>
									<div class="ms-3">
										<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
										<span class="text-muted fs-7 mb-1">3 Hours</span>
									</div>
								</div>
								<div class="p-5 rounded bg-light-info text-gray-900 fw-semibold mw-lg-400px text-start" data-kt-element="message-text">You can unwatch this repository immediately by clicking here: 
								<a href="https://keenthemes.com">Keenthemes.com</a></div>
							</div>
						</div>
						<div class="d-flex justify-content-end mb-10">
							<div class="d-flex flex-column align-items-end">
								<div class="d-flex align-items-center mb-2">
									<div class="me-3">
										<span class="text-muted fs-7 mb-1">4 Hours</span>
										<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
									</div>
									<div class="symbol symbol-35px symbol-circle">
										<img alt="Pic" src="assets/media/avatars/300-1.jpg" />
									</div>
								</div>
								<div class="p-5 rounded bg-light-primary text-gray-900 fw-semibold mw-lg-400px text-end" data-kt-element="message-text">Most purchased Business courses during this sale!</div>
							</div>
						</div>
						<div class="d-flex justify-content-start mb-10">
							<div class="d-flex flex-column align-items-start">
								<div class="d-flex align-items-center mb-2">
									<div class="symbol symbol-35px symbol-circle">
										<img alt="Pic" src="assets/media/avatars/300-25.jpg" />
									</div>
									<div class="ms-3">
										<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
										<span class="text-muted fs-7 mb-1">5 Hours</span>
									</div>
								</div>
								<div class="p-5 rounded bg-light-info text-gray-900 fw-semibold mw-lg-400px text-start" data-kt-element="message-text">Company BBQ to celebrate the last quater achievements and goals. Food and drinks provided</div>
							</div>
						</div>
						<div class="d-flex justify-content-end mb-10 d-none" data-kt-element="template-out">
							<div class="d-flex flex-column align-items-end">
								<div class="d-flex align-items-center mb-2">
									<div class="me-3">
										<span class="text-muted fs-7 mb-1">Just now</span>
										<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
									</div>
									<div class="symbol symbol-35px symbol-circle">
										<img alt="Pic" src="assets/media/avatars/300-1.jpg" />
									</div>
								</div>
								<div class="p-5 rounded bg-light-primary text-gray-900 fw-semibold mw-lg-400px text-end" data-kt-element="message-text"></div>
							</div>
						</div>
						<div class="d-flex justify-content-start mb-10 d-none" data-kt-element="template-in">
							<div class="d-flex flex-column align-items-start">
								<div class="d-flex align-items-center mb-2">
									<div class="symbol symbol-35px symbol-circle">
										<img alt="Pic" src="assets/media/avatars/300-25.jpg" />
									</div>
									<div class="ms-3">
										<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
										<span class="text-muted fs-7 mb-1">Just now</span>
									</div>
								</div>
								<div class="p-5 rounded bg-light-info text-gray-900 fw-semibold mw-lg-400px text-start" data-kt-element="message-text">Right before vacation season we have the next Big Deal for you.</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer pt-4" id="kt_drawer_chat_messenger_footer">
					<textarea class="form-control form-control-flush mb-3" rows="1" data-kt-element="input" placeholder="Type a message"></textarea>
					<div class="d-flex flex-stack">
						<div class="d-flex align-items-center me-2">
							<button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" title="Coming soon">
								<i class="ki-duotone ki-paper-clip fs-3"></i>
							</button>
							<button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" title="Coming soon">
								<i class="ki-duotone ki-cloud-add fs-3">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
							</button>
						</div>
						<button class="btn btn-primary" type="button" data-kt-element="send">Send</button>
					</div>
				</div>
			</div>
		</div>
		<div id="kt_shopping_cart" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="cart" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'md': '500px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_drawer_shopping_cart_toggle" data-kt-drawer-close="#kt_drawer_shopping_cart_close">
			<div class="card card-flush w-100 rounded-0">
				<div class="card-header">
					<h3 class="card-title text-gray-900 fw-bold">Shopping Cart</h3>
					<div class="card-toolbar">
						<div class="btn btn-sm btn-icon btn-active-light-primary" id="kt_drawer_shopping_cart_close">
							<i class="ki-duotone ki-cross fs-2">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
						</div>
					</div>
				</div>
				<div class="card-body hover-scroll-overlay-y h-400px pt-5">
					<div class="d-flex flex-stack">
						<div class="d-flex flex-column me-3">
							<div class="mb-3">
								<a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fs-4 fw-bold">Iblender</a>
								<span class="text-gray-500 fw-semibold d-block">The best kitchen gadget in 2022</span>
							</div>
							<div class="d-flex align-items-center">
								<span class="fw-bold text-gray-800 fs-5">$ 350</span>
								<span class="text-muted mx-2">for</span>
								<span class="fw-bold text-gray-800 fs-5 me-3">5</span>
								<a href="#" class="btn btn-sm btn-light-success btn-icon-success btn-icon w-25px h-25px me-2">
									<i class="ki-duotone ki-minus fs-4"></i>
								</a>
								<a href="#" class="btn btn-sm btn-light-success btn-icon w-25px h-25px">
									<i class="ki-duotone ki-plus fs-4"></i>
								</a>
							</div>
						</div>
						<div class="symbol symbol-70px symbol-2by3 flex-shrink-0">
							<img src="assets/media/stock/600x400/img-1.jpg" alt="" />
						</div>
					</div>
					<div class="separator separator-dashed my-6"></div>
					<div class="d-flex flex-stack">
						<div class="d-flex flex-column me-3">
							<div class="mb-3">
								<a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fs-4 fw-bold">SmartCleaner</a>
								<span class="text-gray-500 fw-semibold d-block">Smart tool for cooking</span>
							</div>
							<div class="d-flex align-items-center">
								<span class="fw-bold text-gray-800 fs-5">$ 650</span>
								<span class="text-muted mx-2">for</span>
								<span class="fw-bold text-gray-800 fs-5 me-3">4</span>
								<a href="#" class="btn btn-sm btn-light-success btn-icon-success btn-icon w-25px h-25px me-2">
									<i class="ki-duotone ki-minus fs-4"></i>
								</a>
								<a href="#" class="btn btn-sm btn-light-success btn-icon w-25px h-25px">
									<i class="ki-duotone ki-plus fs-4"></i>
								</a>
							</div>
						</div>
						<div class="symbol symbol-70px symbol-2by3 flex-shrink-0">
							<img src="assets/media/stock/600x400/img-3.jpg" alt="" />
						</div>
					</div>
					<div class="separator separator-dashed my-6"></div>
					<div class="d-flex flex-stack">
						<div class="d-flex flex-column me-3">
							<div class="mb-3">
								<a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fs-4 fw-bold">CameraMaxr</a>
								<span class="text-gray-500 fw-semibold d-block">Professional camera for edge</span>
							</div>
							<div class="d-flex align-items-center">
								<span class="fw-bold text-gray-800 fs-5">$ 150</span>
								<span class="text-muted mx-2">for</span>
								<span class="fw-bold text-gray-800 fs-5 me-3">3</span>
								<a href="#" class="btn btn-sm btn-light-success btn-icon-success btn-icon w-25px h-25px me-2">
									<i class="ki-duotone ki-minus fs-4"></i>
								</a>
								<a href="#" class="btn btn-sm btn-light-success btn-icon w-25px h-25px">
									<i class="ki-duotone ki-plus fs-4"></i>
								</a>
							</div>
						</div>
						<div class="symbol symbol-70px symbol-2by3 flex-shrink-0">
							<img src="assets/media/stock/600x400/img-8.jpg" alt="" />
						</div>
					</div>
					<div class="separator separator-dashed my-6"></div>
					<div class="d-flex flex-stack">
						<div class="d-flex flex-column me-3">
							<div class="mb-3">
								<a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fs-4 fw-bold">$D Printer</a>
								<span class="text-gray-500 fw-semibold d-block">Manfactoring unique objekts</span>
							</div>
							<div class="d-flex align-items-center">
								<span class="fw-bold text-gray-800 fs-5">$ 1450</span>
								<span class="text-muted mx-2">for</span>
								<span class="fw-bold text-gray-800 fs-5 me-3">7</span>
								<a href="#" class="btn btn-sm btn-light-success btn-icon-success btn-icon w-25px h-25px me-2">
									<i class="ki-duotone ki-minus fs-4"></i>
								</a>
								<a href="#" class="btn btn-sm btn-light-success btn-icon w-25px h-25px">
									<i class="ki-duotone ki-plus fs-4"></i>
								</a>
							</div>
						</div>
						<div class="symbol symbol-70px symbol-2by3 flex-shrink-0">
							<img src="assets/media/stock/600x400/img-26.jpg" alt="" />
						</div>
					</div>
					<div class="separator separator-dashed my-6"></div>
					<div class="d-flex flex-stack">
						<div class="d-flex flex-column me-3">
							<div class="mb-3">
								<a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fs-4 fw-bold">MotionWire</a>
								<span class="text-gray-500 fw-semibold d-block">Perfect animation tool</span>
							</div>
							<div class="d-flex align-items-center">
								<span class="fw-bold text-gray-800 fs-5">$ 650</span>
								<span class="text-muted mx-2">for</span>
								<span class="fw-bold text-gray-800 fs-5 me-3">7</span>
								<a href="#" class="btn btn-sm btn-light-success btn-icon-success btn-icon w-25px h-25px me-2">
									<i class="ki-duotone ki-minus fs-4"></i>
								</a>
								<a href="#" class="btn btn-sm btn-light-success btn-icon w-25px h-25px">
									<i class="ki-duotone ki-plus fs-4"></i>
								</a>
							</div>
						</div>
						<div class="symbol symbol-70px symbol-2by3 flex-shrink-0">
							<img src="assets/media/stock/600x400/img-21.jpg" alt="" />
						</div>
					</div>
					<div class="separator separator-dashed my-6"></div>
					<div class="d-flex flex-stack">
						<div class="d-flex flex-column me-3">
							<div class="mb-3">
								<a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fs-4 fw-bold">Samsung</a>
								<span class="text-gray-500 fw-semibold d-block">Profile info,Timeline etc</span>
							</div>
							<div class="d-flex align-items-center">
								<span class="fw-bold text-gray-800 fs-5">$ 720</span>
								<span class="text-muted mx-2">for</span>
								<span class="fw-bold text-gray-800 fs-5 me-3">6</span>
								<a href="#" class="btn btn-sm btn-light-success btn-icon-success btn-icon w-25px h-25px me-2">
									<i class="ki-duotone ki-minus fs-4"></i>
								</a>
								<a href="#" class="btn btn-sm btn-light-success btn-icon w-25px h-25px">
									<i class="ki-duotone ki-plus fs-4"></i>
								</a>
							</div>
						</div>
						<div class="symbol symbol-70px symbol-2by3 flex-shrink-0">
							<img src="assets/media/stock/600x400/img-34.jpg" alt="" />
						</div>
					</div>
					<div class="separator separator-dashed my-6"></div>
					<div class="d-flex flex-stack">
						<div class="d-flex flex-column me-3">
							<div class="mb-3">
								<a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fs-4 fw-bold">$D Printer</a>
								<span class="text-gray-500 fw-semibold d-block">Manfactoring unique objekts</span>
							</div>
							<div class="d-flex align-items-center">
								<span class="fw-bold text-gray-800 fs-5">$ 430</span>
								<span class="text-muted mx-2">for</span>
								<span class="fw-bold text-gray-800 fs-5 me-3">8</span>
								<a href="#" class="btn btn-sm btn-light-success btn-icon-success btn-icon w-25px h-25px me-2">
									<i class="ki-duotone ki-minus fs-4"></i>
								</a>
								<a href="#" class="btn btn-sm btn-light-success btn-icon w-25px h-25px">
									<i class="ki-duotone ki-plus fs-4"></i>
								</a>
							</div>
						</div>
						<div class="symbol symbol-70px symbol-2by3 flex-shrink-0">
							<img src="assets/media/stock/600x400/img-27.jpg" alt="" />
						</div>
					</div>
				</div>
				<div class="card-footer">
					<div class="d-flex flex-stack">
						<span class="fw-bold text-gray-600">Total</span>
						<span class="text-gray-800 fw-bolder fs-5">$ 1840.00</span>
					</div>
					<div class="d-flex flex-stack">
						<span class="fw-bold text-gray-600">Sub total</span>
						<span class="text-primary fw-bolder fs-5">$ 246.35</span>
					</div>
					<div class="d-flex justify-content-end mt-9">
						<a href="#" class="btn btn-primary d-flex justify-content-end">Pleace Order</a>
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
		<div class="modal fade" id="kt_modal_upgrade_plan" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-xl">
				<div class="modal-content rounded">
					<div class="modal-header justify-content-end border-0 pb-0">
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<i class="ki-duotone ki-cross fs-1">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
						</div>
					</div>
					<div class="modal-body pt-0 pb-15 px-5 px-xl-20">
						<div class="mb-13 text-center">
							<h1 class="mb-3">Upgrade a Plan</h1>
							<div class="text-muted fw-semibold fs-5">If you need more info, please check 
							<a href="#" class="link-primary fw-bold">Pricing Guidelines</a>.</div>
						</div>
						<div class="d-flex flex-column">
							<div class="nav-group nav-group-outline mx-auto" data-kt-buttons="true">
								<button class="btn btn-color-gray-500 btn-active btn-active-secondary px-6 py-3 me-2 active" data-kt-plan="month">Monthly</button>
								<button class="btn btn-color-gray-500 btn-active btn-active-secondary px-6 py-3" data-kt-plan="annual">Annual</button>
							</div>
							<div class="row mt-10">
								<div class="col-lg-6 mb-10 mb-lg-0">
									<div class="nav flex-column">
										<label class="nav-link btn btn-outline btn-outline-dashed btn-color-dark btn-active btn-active-primary d-flex flex-stack text-start p-6 active mb-6" data-bs-toggle="tab" data-bs-target="#kt_upgrade_plan_startup">
											<div class="d-flex align-items-center me-2">
												<div class="form-check form-check-custom form-check-solid form-check-success flex-shrink-0 me-6">
													<input class="form-check-input" type="radio" name="plan" checked="checked" value="startup" />
												</div>
												<div class="flex-grow-1">
													<div class="d-flex align-items-center fs-2 fw-bold flex-wrap">Startup</div>
													<div class="fw-semibold opacity-75">Best for startups</div>
												</div>
											</div>
											<div class="ms-5">
												<span class="mb-2">$</span>
												<span class="fs-3x fw-bold" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">39</span>
												<span class="fs-7 opacity-50">/ 
												<span data-kt-element="period">Mon</span></span>
											</div>
										</label>
										<label class="nav-link btn btn-outline btn-outline-dashed btn-color-dark btn-active btn-active-primary d-flex flex-stack text-start p-6 mb-6" data-bs-toggle="tab" data-bs-target="#kt_upgrade_plan_advanced">
											<div class="d-flex align-items-center me-2">
												<div class="form-check form-check-custom form-check-solid form-check-success flex-shrink-0 me-6">
													<input class="form-check-input" type="radio" name="plan" value="advanced" />
												</div>
												<div class="flex-grow-1">
													<div class="d-flex align-items-center fs-2 fw-bold flex-wrap">Advanced</div>
													<div class="fw-semibold opacity-75">Best for 100+ team size</div>
												</div>
											</div>
											<div class="ms-5">
												<span class="mb-2">$</span>
												<span class="fs-3x fw-bold" data-kt-plan-price-month="339" data-kt-plan-price-annual="3399">339</span>
												<span class="fs-7 opacity-50">/ 
												<span data-kt-element="period">Mon</span></span>
											</div>
										</label>
										<label class="nav-link btn btn-outline btn-outline-dashed btn-color-dark btn-active btn-active-primary d-flex flex-stack text-start p-6 mb-6" data-bs-toggle="tab" data-bs-target="#kt_upgrade_plan_enterprise">
											<div class="d-flex align-items-center me-2">
												<div class="form-check form-check-custom form-check-solid form-check-success flex-shrink-0 me-6">
													<input class="form-check-input" type="radio" name="plan" value="enterprise" />
												</div>
												<div class="flex-grow-1">
													<div class="d-flex align-items-center fs-2 fw-bold flex-wrap">Enterprise 
													<span class="badge badge-light-success ms-2 py-2 px-3 fs-7">Popular</span></div>
													<div class="fw-semibold opacity-75">Best value for 1000+ team</div>
												</div>
											</div>
											<div class="ms-5">
												<span class="mb-2">$</span>
												<span class="fs-3x fw-bold" data-kt-plan-price-month="999" data-kt-plan-price-annual="9999">999</span>
												<span class="fs-7 opacity-50">/ 
												<span data-kt-element="period">Mon</span></span>
											</div>
										</label>
										<label class="nav-link btn btn-outline btn-outline-dashed btn-color-dark btn-active btn-active-primary d-flex flex-stack text-start p-6 mb-6" data-bs-toggle="tab" data-bs-target="#kt_upgrade_plan_custom">
											<div class="d-flex align-items-center me-2">
												<div class="form-check form-check-custom form-check-solid form-check-success flex-shrink-0 me-6">
													<input class="form-check-input" type="radio" name="plan" value="custom" />
												</div>
												<div class="flex-grow-1">
													<div class="d-flex align-items-center fs-2 fw-bold flex-wrap">Custom</div>
													<div class="fw-semibold opacity-75">Requet a custom license</div>
												</div>
											</div>
											<div class="ms-5">
												<a href="#" class="btn btn-sm btn-success">Contact Us</a>
											</div>
										</label>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="tab-content rounded h-100 bg-light p-10">
										<div class="tab-pane fade show active" id="kt_upgrade_plan_startup">
											<div class="pb-5">
												<h2 class="fw-bold text-gray-900">What’s in Startup Plan?</h2>
												<div class="text-muted fw-semibold">Optimal for 10+ team size and new startup</div>
											</div>
											<div class="pt-1">
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Up to 10 Active Users</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Up to 30 Project Integrations</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Analytics Module</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-muted flex-grow-1">Finance Module</span>
													<i class="ki-duotone ki-cross-circle fs-1">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-muted flex-grow-1">Accounting Module</span>
													<i class="ki-duotone ki-cross-circle fs-1">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-muted flex-grow-1">Network Platform</span>
													<i class="ki-duotone ki-cross-circle fs-1">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center">
													<span class="fw-semibold fs-5 text-muted flex-grow-1">Unlimited Cloud Space</span>
													<i class="ki-duotone ki-cross-circle fs-1">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="kt_upgrade_plan_advanced">
											<div class="pb-5">
												<h2 class="fw-bold text-gray-900">What’s in Startup Plan?</h2>
												<div class="text-muted fw-semibold">Optimal for 100+ team size and grown company</div>
											</div>
											<div class="pt-1">
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Up to 10 Active Users</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Up to 30 Project Integrations</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Analytics Module</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Finance Module</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Accounting Module</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-muted flex-grow-1">Network Platform</span>
													<i class="ki-duotone ki-cross-circle fs-1">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center">
													<span class="fw-semibold fs-5 text-muted flex-grow-1">Unlimited Cloud Space</span>
													<i class="ki-duotone ki-cross-circle fs-1">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="kt_upgrade_plan_enterprise">
											<div class="pb-5">
												<h2 class="fw-bold text-gray-900">What’s in Startup Plan?</h2>
												<div class="text-muted fw-semibold">Optimal for 1000+ team and enterpise</div>
											</div>
											<div class="pt-1">
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Up to 10 Active Users</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Up to 30 Project Integrations</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Analytics Module</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Finance Module</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Accounting Module</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Network Platform</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Unlimited Cloud Space</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="kt_upgrade_plan_custom">
											<div class="pb-5">
												<h2 class="fw-bold text-gray-900">What’s in Startup Plan?</h2>
												<div class="text-muted fw-semibold">Optimal for corporations</div>
											</div>
											<div class="pt-1">
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Unlimited Users</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Unlimited Project Integrations</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Analytics Module</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Finance Module</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Accounting Module</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center mb-7">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Network Platform</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
												<div class="d-flex align-items-center">
													<span class="fw-semibold fs-5 text-gray-700 flex-grow-1">Unlimited Cloud Space</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="d-flex flex-center flex-row-fluid pt-12">
							<button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary" id="kt_modal_upgrade_plan_btn">
								<span class="indicator-label">Upgrade Plan</span>
								<span class="indicator-progress">Please wait... 
								<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="kt_modal_users_search" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered mw-650px">
				<div class="modal-content">
					<div class="modal-header pb-0 border-0 justify-content-end">
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<i class="ki-duotone ki-cross fs-1">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
						</div>
					</div>
					<div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
						<div class="text-center mb-13">
							<h1 class="mb-3">Search Users</h1>
							<div class="text-muted fw-semibold fs-5">Invite Collaborators To Your Project</div>
						</div>
						<div id="kt_modal_users_search_handler" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="inline">
							<form data-kt-search-element="form" id="search_form" class="w-100 position-relative mb-5" autocomplete="off">
								@csrf
								<input type="hidden" />
								<i class="ki-duotone ki-magnifier fs-2 fs-lg-1 text-gray-500 position-absolute top-50 ms-5 translate-middle-y">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
								<input type="text" class="form-control form-control-lg form-control-solid px-15" name="keyword" id="keyword" value="" placeholder="Search by username, full name or email..." data-kt-search-element="input" />
								<span class="position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5" data-kt-search-element="spinner">
									<span class="spinner-border h-15px w-15px align-middle text-muted"></span>
								</span>
								<span class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 me-5 d-none" data-kt-search-element="clear">
									<i class="ki-duotone ki-cross fs-2 fs-lg-1 me-0">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
								</span>
							</form>
							<div class="py-5">
								<div data-kt-search-element="suggestions">
									<h3 class="fw-semibold mb-5">Recently searched:</h3>
									<div class="mh-375px scroll-y me-n7 pe-7">
										@foreach($users as $key => $user)
											<a href="#" class="d-flex align-items-center p-3 rounded bg-state-light bg-state-opacity-50 mb-1">
												<div class="symbol symbol-35px symbol-circle me-5">
													@if(isset($user->profile_pic) || $user->profile_pic != "")
                                                        <img src="{{asset('uploads/users/'.$user->profile_pic)}}" alt="image" style="object-fit: cover;"/>
                                                    @else
                                                        <img src="{{asset('uploads/no_image1.png')}}" alt="image" style="object-fit: cover;"/>
                                                    @endif
												</div>
												<div class="fw-semibold">
													<span class="fs-6 text-gray-800 me-2">{{$user->name}}</span>
													<span class="badge badge-light">{{$user->roles[0]->name}}</span>
												</div>
											</a>
										@endforeach
									</div>
								</div>
								<div data-kt-search-element="results" class="d-none">
									<div class="mh-375px scroll-y me-n7 pe-7">
										<div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="0">
											<div class="d-flex align-items-center">
												<label class="form-check form-check-custom form-check-solid me-5">
													<input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='0']" value="0" />
												</label>
												<div class="symbol symbol-35px symbol-circle">
													<img alt="Pic" src="assets/media/avatars/300-6.jpg" />
												</div>
												<div class="ms-5">
													<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Emma Smith</a>
													<div class="fw-semibold text-muted">smith@kpmg.com</div>
												</div>
											</div>
											<div class="ms-2 w-100px">
												<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
													<option value="1">Guest</option>
													<option value="2" selected="selected">Owner</option>
													<option value="3">Can Edit</option>
												</select>
											</div>
										</div>
										<div class="border-bottom border-gray-300 border-bottom-dashed"></div>
										<div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="1">
											<div class="d-flex align-items-center">
												<label class="form-check form-check-custom form-check-solid me-5">
													<input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='1']" value="1" />
												</label>
												<div class="symbol symbol-35px symbol-circle">
													<span class="symbol-label bg-light-danger text-danger fw-semibold">M</span>
												</div>
												<div class="ms-5">
													<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Melody Macy</a>
													<div class="fw-semibold text-muted">melody@altbox.com</div>
												</div>
											</div>
											<div class="ms-2 w-100px">
												<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
													<option value="1" selected="selected">Guest</option>
													<option value="2">Owner</option>
													<option value="3">Can Edit</option>
												</select>
											</div>
										</div>
										<div class="border-bottom border-gray-300 border-bottom-dashed"></div>
										<div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="2">
											<div class="d-flex align-items-center">
												<label class="form-check form-check-custom form-check-solid me-5">
													<input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='2']" value="2" />
												</label>
												<div class="symbol symbol-35px symbol-circle">
													<img alt="Pic" src="assets/media/avatars/300-1.jpg" />
												</div>
												<div class="ms-5">
													<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Max Smith</a>
													<div class="fw-semibold text-muted">max@kt.com</div>
												</div>
											</div>
											<div class="ms-2 w-100px">
												<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
													<option value="1">Guest</option>
													<option value="2">Owner</option>
													<option value="3" selected="selected">Can Edit</option>
												</select>
											</div>
										</div>
										<div class="border-bottom border-gray-300 border-bottom-dashed"></div>
										<div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="3">
											<div class="d-flex align-items-center">
												<label class="form-check form-check-custom form-check-solid me-5">
													<input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='3']" value="3" />
												</label>
												<div class="symbol symbol-35px symbol-circle">
													<img alt="Pic" src="assets/media/avatars/300-5.jpg" />
												</div>
												<div class="ms-5">
													<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Sean Bean</a>
													<div class="fw-semibold text-muted">sean@dellito.com</div>
												</div>
											</div>
											<div class="ms-2 w-100px">
												<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
													<option value="1">Guest</option>
													<option value="2" selected="selected">Owner</option>
													<option value="3">Can Edit</option>
												</select>
											</div>
										</div>
										<div class="border-bottom border-gray-300 border-bottom-dashed"></div>
										<div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="4">
											<div class="d-flex align-items-center">
												<label class="form-check form-check-custom form-check-solid me-5">
													<input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='4']" value="4" />
												</label>
												<div class="symbol symbol-35px symbol-circle">
													<img alt="Pic" src="assets/media/avatars/300-25.jpg" />
												</div>
												<div class="ms-5">
													<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Brian Cox</a>
													<div class="fw-semibold text-muted">brian@exchange.com</div>
												</div>
											</div>
											<div class="ms-2 w-100px">
												<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
													<option value="1">Guest</option>
													<option value="2">Owner</option>
													<option value="3" selected="selected">Can Edit</option>
												</select>
											</div>
										</div>
										<div class="border-bottom border-gray-300 border-bottom-dashed"></div>
										<div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="5">
											<div class="d-flex align-items-center">
												<label class="form-check form-check-custom form-check-solid me-5">
													<input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='5']" value="5" />
												</label>
												<div class="symbol symbol-35px symbol-circle">
													<span class="symbol-label bg-light-warning text-warning fw-semibold">C</span>
												</div>
												<div class="ms-5">
													<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Mikaela Collins</a>
													<div class="fw-semibold text-muted">mik@pex.com</div>
												</div>
											</div>
											<div class="ms-2 w-100px">
												<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
													<option value="1">Guest</option>
													<option value="2" selected="selected">Owner</option>
													<option value="3">Can Edit</option>
												</select>
											</div>
										</div>
										<div class="border-bottom border-gray-300 border-bottom-dashed"></div>
										<div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="6">
											<div class="d-flex align-items-center">
												<label class="form-check form-check-custom form-check-solid me-5">
													<input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='6']" value="6" />
												</label>
												<div class="symbol symbol-35px symbol-circle">
													<img alt="Pic" src="assets/media/avatars/300-9.jpg" />
												</div>
												<div class="ms-5">
													<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Francis Mitcham</a>
													<div class="fw-semibold text-muted">f.mit@kpmg.com</div>
												</div>
											</div>
											<div class="ms-2 w-100px">
												<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
													<option value="1">Guest</option>
													<option value="2">Owner</option>
													<option value="3" selected="selected">Can Edit</option>
												</select>
											</div>
										</div>
										<div class="border-bottom border-gray-300 border-bottom-dashed"></div>
										<div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="7">
											<div class="d-flex align-items-center">
												<label class="form-check form-check-custom form-check-solid me-5">
													<input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='7']" value="7" />
												</label>
												<div class="symbol symbol-35px symbol-circle">
													<span class="symbol-label bg-light-danger text-danger fw-semibold">O</span>
												</div>
												<div class="ms-5">
													<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Olivia Wild</a>
													<div class="fw-semibold text-muted">olivia@corpmail.com</div>
												</div>
											</div>
											<div class="ms-2 w-100px">
												<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
													<option value="1">Guest</option>
													<option value="2" selected="selected">Owner</option>
													<option value="3">Can Edit</option>
												</select>
											</div>
										</div>
										<div class="border-bottom border-gray-300 border-bottom-dashed"></div>
										<div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="8">
											<div class="d-flex align-items-center">
												<label class="form-check form-check-custom form-check-solid me-5">
													<input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='8']" value="8" />
												</label>
												<div class="symbol symbol-35px symbol-circle">
													<span class="symbol-label bg-light-primary text-primary fw-semibold">N</span>
												</div>
												<div class="ms-5">
													<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Neil Owen</a>
													<div class="fw-semibold text-muted">owen.neil@gmail.com</div>
												</div>
											</div>
											<div class="ms-2 w-100px">
												<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
													<option value="1" selected="selected">Guest</option>
													<option value="2">Owner</option>
													<option value="3">Can Edit</option>
												</select>
											</div>
										</div>
										<div class="border-bottom border-gray-300 border-bottom-dashed"></div>
										<div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="9">
											<div class="d-flex align-items-center">
												<label class="form-check form-check-custom form-check-solid me-5">
													<input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='9']" value="9" />
												</label>
												<div class="symbol symbol-35px symbol-circle">
													<img alt="Pic" src="assets/media/avatars/300-23.jpg" />
												</div>
												<div class="ms-5">
													<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Dan Wilson</a>
													<div class="fw-semibold text-muted">dam@consilting.com</div>
												</div>
											</div>
											<div class="ms-2 w-100px">
												<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
													<option value="1">Guest</option>
													<option value="2">Owner</option>
													<option value="3" selected="selected">Can Edit</option>
												</select>
											</div>
										</div>
										<div class="border-bottom border-gray-300 border-bottom-dashed"></div>
										<div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="10">
											<div class="d-flex align-items-center">
												<label class="form-check form-check-custom form-check-solid me-5">
													<input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='10']" value="10" />
												</label>
												<div class="symbol symbol-35px symbol-circle">
													<span class="symbol-label bg-light-danger text-danger fw-semibold">E</span>
												</div>
												<div class="ms-5">
													<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Emma Bold</a>
													<div class="fw-semibold text-muted">emma@intenso.com</div>
												</div>
											</div>
											<div class="ms-2 w-100px">
												<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
													<option value="1">Guest</option>
													<option value="2" selected="selected">Owner</option>
													<option value="3">Can Edit</option>
												</select>
											</div>
										</div>
										<div class="border-bottom border-gray-300 border-bottom-dashed"></div>
										<div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="11">
											<div class="d-flex align-items-center">
												<label class="form-check form-check-custom form-check-solid me-5">
													<input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='11']" value="11" />
												</label>
												<div class="symbol symbol-35px symbol-circle">
													<img alt="Pic" src="assets/media/avatars/300-12.jpg" />
												</div>
												<div class="ms-5">
													<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Ana Crown</a>
													<div class="fw-semibold text-muted">ana.cf@limtel.com</div>
												</div>
											</div>
											<div class="ms-2 w-100px">
												<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
													<option value="1" selected="selected">Guest</option>
													<option value="2">Owner</option>
													<option value="3">Can Edit</option>
												</select>
											</div>
										</div>
										<div class="border-bottom border-gray-300 border-bottom-dashed"></div>
										<div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="12">
											<div class="d-flex align-items-center">
												<label class="form-check form-check-custom form-check-solid me-5">
													<input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='12']" value="12" />
												</label>
												<div class="symbol symbol-35px symbol-circle">
													<span class="symbol-label bg-light-info text-info fw-semibold">A</span>
												</div>
												<div class="ms-5">
													<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Robert Doe</a>
													<div class="fw-semibold text-muted">robert@benko.com</div>
												</div>
											</div>
											<div class="ms-2 w-100px">
												<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
													<option value="1">Guest</option>
													<option value="2">Owner</option>
													<option value="3" selected="selected">Can Edit</option>
												</select>
											</div>
										</div>
										<div class="border-bottom border-gray-300 border-bottom-dashed"></div>
										<div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="13">
											<div class="d-flex align-items-center">
												<label class="form-check form-check-custom form-check-solid me-5">
													<input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='13']" value="13" />
												</label>
												<div class="symbol symbol-35px symbol-circle">
													<img alt="Pic" src="assets/media/avatars/300-13.jpg" />
												</div>
												<div class="ms-5">
													<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">John Miller</a>
													<div class="fw-semibold text-muted">miller@mapple.com</div>
												</div>
											</div>
											<div class="ms-2 w-100px">
												<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
													<option value="1">Guest</option>
													<option value="2">Owner</option>
													<option value="3" selected="selected">Can Edit</option>
												</select>
											</div>
										</div>
										<div class="border-bottom border-gray-300 border-bottom-dashed"></div>
										<div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="14">
											<div class="d-flex align-items-center">
												<label class="form-check form-check-custom form-check-solid me-5">
													<input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='14']" value="14" />
												</label>
												<div class="symbol symbol-35px symbol-circle">
													<span class="symbol-label bg-light-success text-success fw-semibold">L</span>
												</div>
												<div class="ms-5">
													<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Lucy Kunic</a>
													<div class="fw-semibold text-muted">lucy.m@fentech.com</div>
												</div>
											</div>
											<div class="ms-2 w-100px">
												<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
													<option value="1">Guest</option>
													<option value="2" selected="selected">Owner</option>
													<option value="3">Can Edit</option>
												</select>
											</div>
										</div>
										<div class="border-bottom border-gray-300 border-bottom-dashed"></div>
										<div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="15">
											<div class="d-flex align-items-center">
												<label class="form-check form-check-custom form-check-solid me-5">
													<input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='15']" value="15" />
												</label>
												<div class="symbol symbol-35px symbol-circle">
													<img alt="Pic" src="assets/media/avatars/300-21.jpg" />
												</div>
												<div class="ms-5">
													<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Ethan Wilder</a>
													<div class="fw-semibold text-muted">ethan@loop.com.au</div>
												</div>
											</div>
											<div class="ms-2 w-100px">
												<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
													<option value="1" selected="selected">Guest</option>
													<option value="2">Owner</option>
													<option value="3">Can Edit</option>
												</select>
											</div>
										</div>
										<div class="border-bottom border-gray-300 border-bottom-dashed"></div>
										<div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="16">
											<div class="d-flex align-items-center">
												<label class="form-check form-check-custom form-check-solid me-5">
													<input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='16']" value="16" />
												</label>
												<div class="symbol symbol-35px symbol-circle">
													<span class="symbol-label bg-light-primary text-primary fw-semibold">N</span>
												</div>
												<div class="ms-5">
													<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Neil Owen</a>
													<div class="fw-semibold text-muted">owen.neil@gmail.com</div>
												</div>
											</div>
											<div class="ms-2 w-100px">
												<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
													<option value="1">Guest</option>
													<option value="2">Owner</option>
													<option value="3" selected="selected">Can Edit</option>
												</select>
											</div>
										</div>
									</div>
									<div class="d-flex flex-center mt-15">
										<button type="reset" id="kt_modal_users_search_reset" data-bs-dismiss="modal" class="btn btn-active-light me-3">Cancel</button>
										<button type="submit" id="kt_modal_users_search_submit" class="btn btn-primary">Add Selected Users</button>
									</div>
								</div>
								<div data-kt-search-element="empty" class="text-center d-none">
									<div class="fw-semibold py-10">
										<div class="text-gray-600 fs-3 mb-2">No users found</div>
										<div class="text-muted fs-6">Try to search by username, full name or email...</div>
									</div>
									<div class="text-center px-5">
										<img src="assets/media/illustrations/sigma-1/1.png" alt="" class="w-100 h-200px h-sm-325px" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="kt_modal_invite_friends" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog mw-650px">
				<div class="modal-content">
					<div class="modal-header pb-0 border-0 justify-content-end">
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<i class="ki-duotone ki-cross fs-1">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
						</div>
					</div>
					<div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
						<div class="text-center mb-13">
							<h1 class="mb-3">Invite a Friend</h1>
							<div class="text-muted fw-semibold fs-5">If you need more info, please check out 
							<a href="#" class="link-primary fw-bold">FAQ Page</a>.</div>
						</div>
						<div class="btn btn-light-primary fw-bold w-100 mb-8">
						<img alt="Logo" src="assets/media/svg/brand-logos/google-icon.svg" class="h-20px me-3" />Invite Gmail Contacts</div>
						<div class="separator d-flex flex-center mb-8">
							<span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">or</span>
						</div>
						<textarea class="form-control form-control-solid mb-8" rows="3" placeholder="Type or paste emails here"></textarea>
						<div class="mb-10">
							<div class="fs-6 fw-semibold mb-2">Your Invitations</div>
							<div class="mh-300px scroll-y me-n7 pe-7">
								<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-35px symbol-circle">
											<img alt="Pic" src="assets/media/avatars/300-6.jpg" />
										</div>
										<div class="ms-5">
											<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Emma Smith</a>
											<div class="fw-semibold text-muted">smith@kpmg.com</div>
										</div>
									</div>
									<div class="ms-2 w-100px">
										<select class="form-select form-select-solid form-select-sm" data-control="select2" data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
											<option value="1">Guest</option>
											<option value="2" selected="selected">Owner</option>
											<option value="3">Can Edit</option>
										</select>
									</div>
								</div>
								<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-35px symbol-circle">
											<span class="symbol-label bg-light-danger text-danger fw-semibold">M</span>
										</div>
										<div class="ms-5">
											<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Melody Macy</a>
											<div class="fw-semibold text-muted">melody@altbox.com</div>
										</div>
									</div>
									<div class="ms-2 w-100px">
										<select class="form-select form-select-solid form-select-sm" data-control="select2" data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
											<option value="1" selected="selected">Guest</option>
											<option value="2">Owner</option>
											<option value="3">Can Edit</option>
										</select>
									</div>
								</div>
								<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-35px symbol-circle">
											<img alt="Pic" src="assets/media/avatars/300-1.jpg" />
										</div>
										<div class="ms-5">
											<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Max Smith</a>
											<div class="fw-semibold text-muted">max@kt.com</div>
										</div>
									</div>
									<div class="ms-2 w-100px">
										<select class="form-select form-select-solid form-select-sm" data-control="select2" data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
											<option value="1">Guest</option>
											<option value="2">Owner</option>
											<option value="3" selected="selected">Can Edit</option>
										</select>
									</div>
								</div>
								<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-35px symbol-circle">
											<img alt="Pic" src="assets/media/avatars/300-5.jpg" />
										</div>
										<div class="ms-5">
											<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Sean Bean</a>
											<div class="fw-semibold text-muted">sean@dellito.com</div>
										</div>
									</div>
									<div class="ms-2 w-100px">
										<select class="form-select form-select-solid form-select-sm" data-control="select2" data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
											<option value="1">Guest</option>
											<option value="2" selected="selected">Owner</option>
											<option value="3">Can Edit</option>
										</select>
									</div>
								</div>
								<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-35px symbol-circle">
											<img alt="Pic" src="assets/media/avatars/300-25.jpg" />
										</div>
										<div class="ms-5">
											<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Brian Cox</a>
											<div class="fw-semibold text-muted">brian@exchange.com</div>
										</div>
									</div>
									<div class="ms-2 w-100px">
										<select class="form-select form-select-solid form-select-sm" data-control="select2" data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
											<option value="1">Guest</option>
											<option value="2">Owner</option>
											<option value="3" selected="selected">Can Edit</option>
										</select>
									</div>
								</div>
								<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-35px symbol-circle">
											<span class="symbol-label bg-light-warning text-warning fw-semibold">C</span>
										</div>
										<div class="ms-5">
											<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Mikaela Collins</a>
											<div class="fw-semibold text-muted">mik@pex.com</div>
										</div>
									</div>
									<div class="ms-2 w-100px">
										<select class="form-select form-select-solid form-select-sm" data-control="select2" data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
											<option value="1">Guest</option>
											<option value="2" selected="selected">Owner</option>
											<option value="3">Can Edit</option>
										</select>
									</div>
								</div>
								<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-35px symbol-circle">
											<img alt="Pic" src="assets/media/avatars/300-9.jpg" />
										</div>
										<div class="ms-5">
											<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Francis Mitcham</a>
											<div class="fw-semibold text-muted">f.mit@kpmg.com</div>
										</div>
									</div>
									<div class="ms-2 w-100px">
										<select class="form-select form-select-solid form-select-sm" data-control="select2" data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
											<option value="1">Guest</option>
											<option value="2">Owner</option>
											<option value="3" selected="selected">Can Edit</option>
										</select>
									</div>
								</div>
								<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-35px symbol-circle">
											<span class="symbol-label bg-light-danger text-danger fw-semibold">O</span>
										</div>
										<div class="ms-5">
											<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Olivia Wild</a>
											<div class="fw-semibold text-muted">olivia@corpmail.com</div>
										</div>
									</div>
									<div class="ms-2 w-100px">
										<select class="form-select form-select-solid form-select-sm" data-control="select2" data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
											<option value="1">Guest</option>
											<option value="2" selected="selected">Owner</option>
											<option value="3">Can Edit</option>
										</select>
									</div>
								</div>
								<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-35px symbol-circle">
											<span class="symbol-label bg-light-primary text-primary fw-semibold">N</span>
										</div>
										<div class="ms-5">
											<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Neil Owen</a>
											<div class="fw-semibold text-muted">owen.neil@gmail.com</div>
										</div>
									</div>
									<div class="ms-2 w-100px">
										<select class="form-select form-select-solid form-select-sm" data-control="select2" data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
											<option value="1" selected="selected">Guest</option>
											<option value="2">Owner</option>
											<option value="3">Can Edit</option>
										</select>
									</div>
								</div>
								<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-35px symbol-circle">
											<img alt="Pic" src="assets/media/avatars/300-23.jpg" />
										</div>
										<div class="ms-5">
											<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Dan Wilson</a>
											<div class="fw-semibold text-muted">dam@consilting.com</div>
										</div>
									</div>
									<div class="ms-2 w-100px">
										<select class="form-select form-select-solid form-select-sm" data-control="select2" data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
											<option value="1">Guest</option>
											<option value="2">Owner</option>
											<option value="3" selected="selected">Can Edit</option>
										</select>
									</div>
								</div>
								<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-35px symbol-circle">
											<span class="symbol-label bg-light-danger text-danger fw-semibold">E</span>
										</div>
										<div class="ms-5">
											<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Emma Bold</a>
											<div class="fw-semibold text-muted">emma@intenso.com</div>
										</div>
									</div>
									<div class="ms-2 w-100px">
										<select class="form-select form-select-solid form-select-sm" data-control="select2" data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
											<option value="1">Guest</option>
											<option value="2" selected="selected">Owner</option>
											<option value="3">Can Edit</option>
										</select>
									</div>
								</div>
								<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-35px symbol-circle">
											<img alt="Pic" src="assets/media/avatars/300-12.jpg" />
										</div>
										<div class="ms-5">
											<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Ana Crown</a>
											<div class="fw-semibold text-muted">ana.cf@limtel.com</div>
										</div>
									</div>
									<div class="ms-2 w-100px">
										<select class="form-select form-select-solid form-select-sm" data-control="select2" data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
											<option value="1" selected="selected">Guest</option>
											<option value="2">Owner</option>
											<option value="3">Can Edit</option>
										</select>
									</div>
								</div>
								<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-35px symbol-circle">
											<span class="symbol-label bg-light-info text-info fw-semibold">A</span>
										</div>
										<div class="ms-5">
											<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Robert Doe</a>
											<div class="fw-semibold text-muted">robert@benko.com</div>
										</div>
									</div>
									<div class="ms-2 w-100px">
										<select class="form-select form-select-solid form-select-sm" data-control="select2" data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
											<option value="1">Guest</option>
											<option value="2">Owner</option>
											<option value="3" selected="selected">Can Edit</option>
										</select>
									</div>
								</div>
								<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-35px symbol-circle">
											<img alt="Pic" src="assets/media/avatars/300-13.jpg" />
										</div>
										<div class="ms-5">
											<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">John Miller</a>
											<div class="fw-semibold text-muted">miller@mapple.com</div>
										</div>
									</div>
									<div class="ms-2 w-100px">
										<select class="form-select form-select-solid form-select-sm" data-control="select2" data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
											<option value="1">Guest</option>
											<option value="2">Owner</option>
											<option value="3" selected="selected">Can Edit</option>
										</select>
									</div>
								</div>
								<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-35px symbol-circle">
											<span class="symbol-label bg-light-success text-success fw-semibold">L</span>
										</div>
										<div class="ms-5">
											<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Lucy Kunic</a>
											<div class="fw-semibold text-muted">lucy.m@fentech.com</div>
										</div>
									</div>
									<div class="ms-2 w-100px">
										<select class="form-select form-select-solid form-select-sm" data-control="select2" data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
											<option value="1">Guest</option>
											<option value="2" selected="selected">Owner</option>
											<option value="3">Can Edit</option>
										</select>
									</div>
								</div>
								<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-35px symbol-circle">
											<img alt="Pic" src="assets/media/avatars/300-21.jpg" />
										</div>
										<div class="ms-5">
											<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Ethan Wilder</a>
											<div class="fw-semibold text-muted">ethan@loop.com.au</div>
										</div>
									</div>
									<div class="ms-2 w-100px">
										<select class="form-select form-select-solid form-select-sm" data-control="select2" data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
											<option value="1" selected="selected">Guest</option>
											<option value="2">Owner</option>
											<option value="3">Can Edit</option>
										</select>
									</div>
								</div>
								<div class="d-flex flex-stack py-4">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-35px symbol-circle">
											<img alt="Pic" src="assets/media/avatars/300-12.jpg" />
										</div>
										<div class="ms-5">
											<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Ana Crown</a>
											<div class="fw-semibold text-muted">ana.cf@limtel.com</div>
										</div>
									</div>
									<div class="ms-2 w-100px">
										<select class="form-select form-select-solid form-select-sm" data-control="select2" data-dropdown-parent="#kt_modal_invite_friends" data-hide-search="true">
											<option value="1">Guest</option>
											<option value="2">Owner</option>
											<option value="3" selected="selected">Can Edit</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="d-flex flex-stack">
							<div class="me-5 fw-semibold">
								<label class="fs-6">Adding Users by Team Members</label>
								<div class="fs-7 text-muted">If you need more info, please check budget planning</div>
							</div>
							<label class="form-check form-switch form-check-custom form-check-solid">
								<input class="form-check-input" type="checkbox" value="1" checked="checked" />
								<span class="form-check-label fw-semibold text-muted">Allowed</span>
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="kt_modal_create_app" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered mw-900px">
				<div class="modal-content">
					<div class="modal-header">
						<h2>Update Project</h2>
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
												<div class="stepper-desc">Name your App</div>
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
												<div class="stepper-desc">Define your app framework</div>
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
												<div class="stepper-desc">Select the app database type</div>
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
											<input type="hidden" name="action" value="update">
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
												<input type="text" class="form-control form-control-lg form-control-solid" name="name" placeholder="Staffing in motion" value="{{$project->name}}" />
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
												<input type="number" class="form-control form-control-lg form-control-solid" name="price" min="1" placeholder="PKR." value="{{$project->project_price}}" />
											</div>

											<div class="fv-row mb-10">
												<label class="d-flex align-items-center fs-5 fw-semibold mb-2">
													<span class="required">Project Deadline</span>
													<span class="ms-1" data-bs-toggle="tooltip" title="Specify your Project Price">
														<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
														</i>
													</span>
												</label>
												<input type="date" class="form-control form-control-lg form-control-solid" name="deadline" />
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
												<textarea class="form-control form-control-lg form-control-solid" name="description" />{{$project->description}}</textarea>
											</div>

											<div class="fv-row">
												<div class="mb-10">
													<label class="d-flex align-items-center fs-5 fw-semibold mb-2">
														<span class="required">Assigned to</span>
													</label>
													<div>
														<select class="form-select form-select-solid" name="assigned_to[]" multiple="multiple" data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option" data-allow-clear="true">
															<option></option>
															<option value="1">Muhammad Raza</option>
															<option value="2">Muhammad Mustafa</option>
															<option value="3">Bilal Sohail</option>
															<option value="4">Mirza Muneed</option>
														</select>
													</div>
												</div>
											</div>

											<div class="fv-row" style="text-align:right">
												<div class="image-input image-input-outline" data-kt-image-input="true">
													<div class="image-input-wrapper w-125px h-125px" style="background-image: url('{{asset('uploads/projects/'.$project->project_img)}}');background-size: cover;background-position: center;"></div>
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
																<input class="form-check-input" type="radio" name="project_category" @if($value->id == $project->project_category) checked @endif value="{{$value->id}}" />
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
															<input class="form-check-input" type="radio" name="tech_stack" @if($value->id == $project->tech_stack) checked @endif value="{{$value->id}}" />
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
												<input type="text" class="form-control form-control-lg form-control-solid" name="db_name" value="{{$project->db_name}}" placeholder="master_db"  />
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
		<div class="modal fade" id="kt_modal_create_task" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered mw-900px">
				<div class="modal-content">
					<div class="modal-header">
						<h2>Add Task</h2>
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<i class="ki-duotone ki-cross fs-1">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
						</div>
					</div>
					<div class="modal-body py-lg-10 px-lg-10">
						<div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid" id="kt_modal_create_app_stepper">
							<div class="flex-row-fluid py-lg-5 px-lg-15">
								<form class="form" id="form_task">
									<div class="current" data-kt-stepper-element="content">
										<div class="w-100">
											<div class="fv-row mb-10">
											@csrf
											<input type="hidden" name="action" value="store">
											<input type="hidden" name="project_id" value="{{$project->id}}">
												<label class="d-flex align-items-center fs-5 fw-semibold mb-2">
													<span class="required">Task Name</span>
													<span class="ms-1" data-bs-toggle="tooltip" title="Specify your unique Task name">
														<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
														</i>
													</span>
												</label>
												<input type="text" class="form-control form-control-lg form-control-solid" name="name" placeholder="Navbar Menu" value="" />
											</div>

											<div class="fv-row mb-10">
												<label class="d-flex align-items-center fs-5 fw-semibold mb-2">
													<span class="required">Task Deadline</span>
													<span class="ms-1" data-bs-toggle="tooltip" title="Specify your Project Price">
														<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
														</i>
													</span>
												</label>
												<input type="date" class="form-control form-control-lg form-control-solid" name="deadline" />
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
													<label class="d-flex align-items-center fs-5 fw-semibold mb-2">
														<span class="required">Assigned to</span>
													</label>
													<div>
														<select class="form-select form-select-solid" name="assigned_to[]" multiple="multiple" data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option" data-allow-clear="true">
															@foreach($users as $key => $user)
																<option></option>
																<option value="{{$user->id}}">{{$user->name}}</option>
															@endforeach
														</select>
													</div>
												</div>
											</div>

											<div class="fv-row" style="text-align:left">
												<div class="image-input image-input-outline" data-kt-image-input="true">
													<div class="image-input-wrapper w-125px h-125px" style="background-image: url('assets/media/dummy-image-green.jpg');background-size: cover;background-position: center;"></div>
													<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar" data-bs-original-title="Change avatar" data-kt-initialized="1">
														<i class="ki-duotone ki-pencil fs-7">
															<span class="path1"></span>
															<span class="path2"></span>
														</i>
														<input type="file" name="task_img" accept=".png, .jpg, .jpeg">
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
										</div>
									</div>
									<div class="d-flex flex-stack pt-10 justify-content-end">
										<div>
											<button type="submit" class="btn btn-lg btn-primary">
												<span class="indicator-label">Submit 
												<i class="ki-duotone ki-arrow-right fs-3 ms-2 me-0">
													<span class="path1"></span>
													<span class="path2"></span>
												</i></span>
												<span class="indicator-progress">Please wait... 
												<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
											</button>
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
		$('#search_form').change(function(e) {
		    e.preventDefault();
		    var formData = new FormData(this);
		    var keyword = $('#keyword').val();
		    var url = "{{ route('projects.search_user', ':keyword') }}".replace(':keyword', keyword);
		    $.ajax({
		        type: 'POST',
		        url: url,
		        data: formData,
		        cache: false,
		        contentType: false,
		        processData: false,
		        success: (data) => {
		            console.log(data);
		        },
		        error: function(data) {
		            // var txt = '';
		            // console.log(data.responseJSON.errors[0])
		            // for (var key in data.responseJSON.errors) {
		            //     txt += data.responseJSON.errors[key];
		            //     txt += '<br>';
		            // }
		            // toastr.error(txt);
		        }
		    });
		});

		$('#form').submit(function(e) {
			e.preventDefault();
			var formData = new FormData(this);
			$.ajax({
				type: 'POST',
				url: "{{ route('projects.update',$project->id) }}",
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				success: (data) => {
					if(data.success){
						this.reset();
						toastr.success(data.success);
					}
					if (data.error) {
				        // Extract error message from the JSON response
				        txt = data.error;
				        toastr.error(txt);
				    } else {
				        // If no specific error message is provided, display a generic error message
				        txt = "An error occurred. Please try again later.";
				        toastr.error(txt);
				    }
				},
				error: function(data) {
				    console.log(data);
				    var txt = '';
				    if (data.responseJSON && data.responseJSON.error) {
				        // Extract error message from the JSON response
				        txt = data.responseJSON.error;
				    } else {
				        // If no specific error message is provided, display a generic error message
				        txt = "An error occurred. Please try again later.";
				    }
				    toastr.error(txt);
				}

			});
		});

		$('#form_task').submit(function(e) {
			e.preventDefault();
			var formData = new FormData(this);
			$.ajax({
				type: 'POST',
				url: "{{ route('tasks.store') }}",
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
					for (var key in data.responseJSON.errors) {
						txt += data.responseJSON.errors[key];
						txt +='<br>';
					}
					toastr.error(txt);
				}
			});
		});


		$('#comment_module').submit(function(e) {
		    e.preventDefault();
		    var formData = new FormData(this);
		    $.ajax({
		        type: 'POST',
		        url: "{{ route('comments.store') }}",
		        data: formData,
		        cache: false,
		        contentType: false,
		        processData: false,
		        success: (data) => {
		            if(data.success){
		                this.reset();
		                $('#file_preview_container').empty();
		                // Construct new comment HTML
		                console.log(data.profile_pic);
		               	var newComment = `
						    <div class="d-flex mb-5">
						        <div class="me-5 position-relative">
						            <div class="symbol symbol-35px symbol-circle">
						                <img src="${data.profile_pic ? 'uploads/users/' + data.profile_pic : 'uploads/no_image1.png'}" alt="image" style="object-fit: cover;"/>
						                <div class="bg-success position-absolute h-8px w-8px rounded-circle translate-middle start-100 top-100 ms-n1 mt-n1"></div>
						            </div>
						        </div>
						        <div class="fw-semibold w-50 p-4" style="border-radius: 10px; background-color: #efefef;">
						            <a href="{{route('user.view',['user'=>Auth::user()->id])}}" class="fs-5 fw-bold text-gray-900 text-hover-primary">You</a>
						            <div class="mt-2">
						                ${formData.get('comment')}
						            </div><br>
						            <div style="width: 100%;">
						                ${data.comment_file ? `
						                    ${isImage(data.comment_file) ? 
						                        '<img src="{{asset('uploads/comments/')}}/' + data.comment_file + '" width="100%">' :
						                        '<a href="{{asset('uploads/comments/')}}/' + data.comment_file + '" target="_blank">Download ' + "(" + data.comment_file + ")" + '</a>'
						                    }
						                ` : ''}
						            </div>
						        </div>
						    </div>
						`;

		                // Append new comment to comments container
		                $('#commentsContainer').append(newComment);
		                
		                $('#comment_input').css('border', 'auto');
		            }
		        },

		        error: function(data) {
				    console.log(data);
				    var errorMessage = JSON.parse(data.responseText).error;
				    $('#comment_input').css('border', '1px solid red');
				    toastr.error(errorMessage);
				}
		    });
		});

		// Function to check if the file is an image
		function isImage(filename) {
		    var ext = getExtension(filename);
		    return (ext == 'jpg' || ext == 'jpeg' || ext == 'png' || ext == 'gif');
		}

		// Function to get file extension
		function getExtension(filename) {
		    return filename.split('.').pop().toLowerCase();
		}



		var commentsContainer = document.getElementById('commentsContainer');
        commentsContainer.scrollTop = commentsContainer.scrollHeight;

		function previewFile() {
	        const previewContainer = document.getElementById('file_preview_container');
	        const fileInput = document.getElementById('comment_file');
	        const files = fileInput.files;

	        previewContainer.innerHTML = ''; // Clear previous previews

	        for (let i = 0; i < files.length; i++) {
	            const file = files[i];
	            const fileType = file.type;
	            
	            if (fileType.startsWith('image')) {
	                const reader = new FileReader();
	                reader.onload = function () {
	                    const imgElement = document.createElement('img');
	                    imgElement.src = reader.result;
	                    imgElement.classList.add('img-thumbnail');
	                    previewContainer.appendChild(imgElement);
	                };
	                reader.readAsDataURL(file);
	            } else {
	                const fileDetails = document.createElement('p');
	                fileDetails.textContent = `${file.name} (${(file.size / 1024).toFixed(2)} KB)`;
	                previewContainer.appendChild(fileDetails);
	            }
	        }
	    }

	</script>
@endsection