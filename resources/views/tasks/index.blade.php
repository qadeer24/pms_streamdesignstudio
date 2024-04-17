@extends('layouts.main')
@section('title','Tasks')
@section('content')	
<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
<div class="d-flex flex-column flex-root">
	<div class="page d-flex flex-row flex-column-fluid">
		<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
			<div class="toolbar py-5 pb-lg-15" id="kt_toolbar">
				<div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
					<div class="page-title d-flex flex-column me-3">
						<h1 class="d-flex text-white fw-bold my-1 fs-3">Project Tasks</h1>
						<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
							<li class="breadcrumb-item text-white opacity-75">
								<a href="index.html" class="text-white text-hover-primary">Home</a>
							</li>
							<li class="breadcrumb-item">
								<span class="bullet bg-white opacity-75 w-5px h-2px"></span>
							</li>
							<li class="breadcrumb-item text-white opacity-75">Apps</li>
							<li class="breadcrumb-item">
								<span class="bullet bg-white opacity-75 w-5px h-2px"></span>
							</li>
							<li class="breadcrumb-item text-white opacity-75">Projects</li>
							<li class="breadcrumb-item">
								<span class="bullet bg-white opacity-75 w-5px h-2px"></span>
							</li>
							<li class="breadcrumb-item text-white opacity-75">Targets</li>
						</ul>
					</div>
					<div class="d-flex align-items-center py-3 py-md-1">
						<a href="#" data-bs-theme="light" class="btn bg-body btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_task" id="kt_toolbar_primary_button">Create</a>
					</div>
				</div>
			</div>
			<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
				<div class="content flex-row-fluid" id="kt_content">
					@if(session('success'))
						<div class="alert alert-success alert-dismissible fade show mx-5 d-flex justify-content-between" role="alert">
						  	<strong>{{ session('success') }}</strong>
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
					<div class="tab-content">
						<div id="kt_project_targets_card_pane" class="tab-pane fade show active">
							<div class="row g-9">
								@foreach($tasks as $key => $task)
									<div class="col-md-4 col-lg-12 col-xl-4">
										<div class="card mb-6 mb-xl-9">
											<div class="card-body">
												<div class="mb-2 d-flex justify-content-between align-items-center">
													<a href="#" class="fs-4 fw-bold mb-1 text-gray-900 text-hover-primary">{{$task->name}}</a>
													<div class="d-flex">
														<a href="#" class="btn bg-body btn-active-color-primary" data-bs-toggle="modal" data-task-id="{{$task->id}}" data-task-name="{{$task->name}}" data-task-desc="{{$task->description}}" data-task-deadline="{{$task->deadline}}" data-bs-theme="light" data-bs-target="#kt_modal_update_task" id="edit_specific_task">Edit</a>
														<form action="{{ route('tasks.destroy', $task) }}" method="POST">
															@csrf
						    								@method('DELETE')
															<button type="submit" class="btn bg-body btn-active-color-primary">Delete</button>
														</form>
													</div>
												</div>
												<div class="fs-6 fw-semibold text-gray-600 mb-5">{{$task->description}}</div>
												<div class="d-flex flex-stack flex-wrapr">
													<div class="symbol-group symbol-hover my-1">
														@foreach($users as $key => $user)
															@if(in_array($user->id, $task->assigned_to))
																<div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="{{$user->name}}">
																	@if($user->profile_pic)
																		<img alt="Pic" src="{{asset('uploads/users/'.$user->profile_pic)}}" />
																	@else
																		<img src="{{asset('uploads/no_image1.png')}}" alt="image" style="object-fit: cover;"/>
																	@endif
																</div>
															@endif
														@endforeach
													</div>
													<div class="border border-dashed border-gray-300 rounded d-flex align-items-center py-2 px-3">
														<span class="ms-1 fs-7 fw-bold text-gray-600">Deadline: </span>
														<div class="badge badge-light">{{$task->deadline}}</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>
						<div id="kt_project_targets_table_pane" class="tab-pane fade">
							<div class="card card-flush">
								<div class="card-body pt-3">
									<table id="kt_profile_overview_table" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
										<thead class="fs-7 text-gray-500 text-uppercase">
											<tr>
												<th class="min-w-250px">Target</th>
												<th class="min-w-90px">Section</th>
												<th class="min-w-150px">Due Date</th>
												<th class="min-w-90px">Members</th>
												<th class="min-w-90px">Status</th>
												<th class="min-w-50px"></th>
											</tr>
										</thead>
										<tbody class="fs-6">
											<tr>
												<td class="fw-bold">
													<a href="#" class="text-gray-900 text-hover-primary">Meeting with customer</a>
												</td>
												<td>
													<span class="badge badge-light fw-semibold me-auto">UI Design</span>
												</td>
												<td>May 3, 2020</td>
												<td>
													<div class="symbol-group symbol-hover fs-8">
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Melody Macy">
															<img alt="Pic" src="assets/media/avatars/300-2.jpg" />
														</div>
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="John Mixin">
															<img alt="Pic" src="assets/media/avatars/300-14.jpg" />
														</div>
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Susan Redwood">
															<span class="symbol-label bg-primary text-inverse-primary fw-bold">S</span>
														</div>
													</div>
												</td>
												<td>
													<span class="badge badge-light-primary fw-bold me-auto">In Progress</span>
												</td>
												<td class="text-end">
													<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
												</td>
											</tr>
											<tr>
												<td class="fw-bold">
													<a href="#" class="text-gray-900 text-hover-primary">User Module Testing</a>
												</td>
												<td>
													<span class="badge badge-light fw-semibold me-auto">Phase 2.6 QA</span>
												</td>
												<td>Jun 25, 2020</td>
												<td>
													<div class="symbol-group symbol-hover fs-8">
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Alan Warden">
															<span class="symbol-label bg-warning text-inverse-warning fw-bold">A</span>
														</div>
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Robin Watterman">
															<span class="symbol-label bg-success text-inverse-success fw-bold">R</span>
														</div>
													</div>
												</td>
												<td>
													<span class="badge badge-light-success fw-bold me-auto">Completed</span>
												</td>
												<td class="text-end">
													<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
												</td>
											</tr>
											<tr>
												<td class="fw-bold">
													<a href="#" class="text-gray-900 text-hover-primary">Sales report page</a>
												</td>
												<td>
													<span class="badge badge-light fw-semibold me-auto">QA</span>
												</td>
												<td>Mar 6, 2020</td>
												<td>
													<div class="symbol-group symbol-hover fs-8">
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Melody Macy">
															<img alt="Pic" src="assets/media/avatars/300-2.jpg" />
														</div>
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Kristen Goodwin">
															<img alt="Pic" src="assets/media/avatars/300-9.jpg" />
														</div>
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Mikaela Collins">
															<span class="symbol-label bg-info text-inverse-info fw-bold">M</span>
														</div>
													</div>
												</td>
												<td>
													<span class="badge badge-light fw-bold me-auto">Yet to start</span>
												</td>
												<td class="text-end">
													<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
												</td>
											</tr>
											<tr>
												<td class="fw-bold">
													<a href="#" class="text-gray-900 text-hover-primary">Meeting with customer</a>
												</td>
												<td>
													<span class="badge badge-light fw-semibold me-auto">Prototype</span>
												</td>
												<td>Jan 22, 2020</td>
												<td>
													<div class="symbol-group symbol-hover fs-8">
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Robin Watterman">
															<span class="symbol-label bg-success text-inverse-success fw-bold">R</span>
														</div>
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Brian Cox">
															<img alt="Pic" src="assets/media/avatars/300-5.jpg" />
														</div>
													</div>
												</td>
												<td>
													<span class="badge badge-light-success fw-bold me-auto">Completed</span>
												</td>
												<td class="text-end">
													<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
												</td>
											</tr>
											<tr>
												<td class="fw-bold">
													<a href="#" class="text-gray-900 text-hover-primary">Design main Dashboard</a>
												</td>
												<td>
													<span class="badge badge-light fw-semibold me-auto">UI Design</span>
												</td>
												<td>Dec 26, 2020</td>
												<td>
													<div class="symbol-group symbol-hover fs-8">
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Melody Macy">
															<img alt="Pic" src="assets/media/avatars/300-2.jpg" />
														</div>
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Emma Smith">
															<img alt="Pic" src="assets/media/avatars/300-6.jpg" />
														</div>
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Lucy Matthews">
															<img alt="Pic" src="assets/media/avatars/300-21.jpg" />
														</div>
													</div>
												</td>
												<td>
													<span class="badge badge-light-success fw-bold me-auto">Completed</span>
												</td>
												<td class="text-end">
													<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
												</td>
											</tr>
											<tr>
												<td class="fw-bold">
													<a href="#" class="text-gray-900 text-hover-primary">User Module Testing</a>
												</td>
												<td>
													<span class="badge badge-light fw-semibold me-auto">Development</span>
												</td>
												<td>Mar 6, 2020</td>
												<td>
													<div class="symbol-group symbol-hover fs-8">
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Francis Mitcham">
															<img alt="Pic" src="assets/media/avatars/300-20.jpg" />
														</div>
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Deanna Taylor">
															<img alt="Pic" src="assets/media/avatars/300-23.jpg" />
														</div>
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Mikaela Collins">
															<span class="symbol-label bg-info text-inverse-info fw-bold">M</span>
														</div>
													</div>
												</td>
												<td>
													<span class="badge badge-light-primary fw-bold me-auto">In Progress</span>
												</td>
												<td class="text-end">
													<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
												</td>
											</tr>
											<tr>
												<td class="fw-bold">
													<a href="#" class="text-gray-900 text-hover-primary">To check User Management</a>
												</td>
												<td>
													<span class="badge badge-light fw-semibold me-auto">Pahse 3.2</span>
												</td>
												<td>Feb 7, 2020</td>
												<td>
													<div class="symbol-group symbol-hover fs-8">
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Lucy Matthews">
															<img alt="Pic" src="assets/media/avatars/300-21.jpg" />
														</div>
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Kristen Goodwin">
															<img alt="Pic" src="assets/media/avatars/300-9.jpg" />
														</div>
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Michelle Swanston">
															<img alt="Pic" src="assets/media/avatars/300-7.jpg" />
														</div>
													</div>
												</td>
												<td>
													<span class="badge badge-light fw-bold me-auto">Yet to start</span>
												</td>
												<td class="text-end">
													<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
												</td>
											</tr>
											<tr>
												<td class="fw-bold">
													<a href="#" class="text-gray-900 text-hover-primary">Create Roles Module</a>
												</td>
												<td>
													<span class="badge badge-light fw-semibold me-auto">Branding</span>
												</td>
												<td>Jun 17, 2020</td>
												<td>
													<div class="symbol-group symbol-hover fs-8">
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Michelle Swanston">
															<img alt="Pic" src="assets/media/avatars/300-7.jpg" />
														</div>
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Robin Watterman">
															<span class="symbol-label bg-success text-inverse-success fw-bold">R</span>
														</div>
														<div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Alan Warden">
															<span class="symbol-label bg-warning text-inverse-warning fw-bold">A</span>
														</div>
													</div>
												</td>
												<td>
													<span class="badge badge-light fw-bold me-auto">Yet to start</span>
												</td>
												<td class="text-end">
													<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
												</td>
											</tr>
										</tbody>
									</table>
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
											<span>Task Description</span>
											<span class="ms-1" data-bs-toggle="tooltip" title="Specify your unique Task Description">
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
<div class="modal fade" id="kt_modal_update_task" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered mw-900px">
		<div class="modal-content">
			<div class="modal-header">
				<h2>Update Task</h2>
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
						<form class="form" id="form_task_update">
							<div class="current" data-kt-stepper-element="content">
								<div class="w-100">
									<div class="fv-row mb-10">
									@csrf
									<input type="hidden" name="action" value="update">
									<input type="hidden" name="project_id" value="{{$project->id}}">
									<input type="hidden" name="task_id" value="">
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
										<input type="text" class="form-control form-control-lg form-control-solid" name="name" id="task_name" placeholder="Navbar Menu" value="" />
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
										<textarea class="form-control form-control-lg form-control-solid" name="description" id="task_desc" /></textarea>
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
<script type="text/javascript">
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
				console.log(data.responseJSON.errors[0])
				for (var key in data.responseJSON.errors) {
					txt += data.responseJSON.errors[key];
					txt +='<br>';
				}
				toastr.error(txt);
			}
		});
	});

	$('#form_task_update').submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			type: 'POST',
			url: "{{ route('tasks.update.custom') }}",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: (data) => {
				if(data.success){
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

	const editRoleButtons = document.querySelectorAll('#edit_specific_task');

	// Add click event listener to each "Edit Role" button
    editRoleButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            // Extract the role ID and name from the button's data attributes
            const taskId 		= this.getAttribute('data-task-id');
            const taskName 		= this.getAttribute('data-task-name');
            const taskDesc 		= this.getAttribute('data-task-desc');
            const taskDeadline 	= this.getAttribute('data-task-deadline');

            const taskIdInput = document.querySelector('#kt_modal_update_task input[name="task_id"]');
            const taskNameInput = document.querySelector('#kt_modal_update_task input[name="name"]');
            const taskDescInput = document.querySelector('#kt_modal_update_task textarea[name="description"]');
            const taskDeadlineInput = document.querySelector('#kt_modal_update_task input[name="deadline"]');

            taskIdInput.value = taskId;

            taskNameInput.value = taskName;

            taskDescInput.value = taskDesc;

            taskDeadlineInput.value = taskDeadline;

        });
    });
</script>
@endsection