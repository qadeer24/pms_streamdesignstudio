@extends('layouts.main')
@section('title','Users')
@section('content')
@include( '../sweet_script')
<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
<div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row flex-column-fluid">
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            @if(session('success_message'))
                <div class="alert alert-success alert-dismissible fade show mx-5 d-flex justify-content-between" role="alert">
                    <strong>{{ session('success_message') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-warning alert-dismissible fade show mx-5 d-flex justify-content-between" role="alert">
                    <strong>{{ session('error') }}</strong>
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
            <div class="toolbar py-5 pb-lg-15" id="kt_toolbar">
                <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
                    <div class="page-title d-flex flex-column me-3">
                        <h1 class="d-flex text-white fw-bold my-1 fs-3">View User Details</h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                            <li class="breadcrumb-item text-white opacity-75">Users</li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-white opacity-75">View User</li>
                        </ul>
                    </div>
                    <div>
                        <form action="{{ route('users.destroy', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn bg-body btn-active-color-primary">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
                <div class="content flex-row-fluid" id="kt_content">
                    <div class="d-flex flex-column flex-lg-row">
                        <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
                            <div class="card mb-5 mb-xl-8">
                                <div class="card-body">
                                    <div class="d-flex flex-center flex-column py-5">
                                        <div class="symbol symbol-100px symbol-circle mb-7">
                                            @if(isset($user->profile_pic) || $user->profile_pic != "")
                                                <img src="{{asset('uploads/users/'.$user->profile_pic)}}" alt="image" style="object-fit: cover;"/>
                                            @else
                                                <img src="{{asset('uploads/no_image1.png')}}" alt="image" style="object-fit: cover;"/>
                                            @endif
                                        </div>
                                        <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">{{$user->name}}</a>
                                        <div class="mb-9">
                                            <div class="badge badge-lg badge-light-primary d-inline">{{$user->roles[0]->name}}</div>
                                        </div>
                                        <div class="fw-bold mb-3">Assigned tasks 
                                        <span class="ms-2" ddata-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Number of support tickets assigned, closed and pending this week.">
                                            <i class="ki-duotone ki-information fs-7">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </span></div>
                                        <div class="d-flex flex-wrap flex-center">
                                            <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                                                <div class="fs-4 fw-bold text-gray-700">
                                                    <span class="w-75px">243</span>
                                                    <i class="ki-duotone ki-arrow-up fs-3 text-success">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </div>
                                                <div class="fw-semibold text-muted">Total</div>
                                            </div>
                                            <div class="border border-gray-300 border-dashed rounded py-3 px-3 mx-4 mb-3">
                                                <div class="fs-4 fw-bold text-gray-700">
                                                    <span class="w-50px">56</span>
                                                    <i class="ki-duotone ki-arrow-down fs-3 text-danger">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </div>
                                                <div class="fw-semibold text-muted">Solved</div>
                                            </div>
                                            <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                                                <div class="fs-4 fw-bold text-gray-700">
                                                    <span class="w-50px">188</span>
                                                    <i class="ki-duotone ki-arrow-up fs-3 text-success">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </div>
                                                <div class="fw-semibold text-muted">Open</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-stack fs-4 py-3">
                                        <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details" role="button" aria-expanded="false" aria-controls="kt_user_view_details">Details 
                                        <span class="ms-2 rotate-180">
                                            <i class="ki-duotone ki-down fs-3"></i>
                                        </span></div>
                                        <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit user details">
                                            <a href="#" class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_update_details">Edit</a>
                                        </span>
                                    </div>
                                    <div class="separator"></div>
                                    <div id="kt_user_view_details" class="collapse show">
                                        <div class="pb-5 fs-6">
                                            <div class="fw-bold mt-5">Account ID</div>
                                            <div class="text-gray-600">ID-{{$user->id}}</div>
                                            <div class="fw-bold mt-5">Email</div>
                                            <div class="text-gray-600">
                                                <a href="#" class="text-gray-600 text-hover-primary">{{$user->email}}</a>
                                            </div>
                                            <div class="fw-bold mt-5">Last Login</div>
                                            <div class="text-gray-600">20 Jun 2024, 10:10 pm</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex-lg-row-fluid ms-lg-15">
                            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_user_view_overview_tab">Overview</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#kt_user_view_overview_security">Security</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">
                                    
                                    <div class="card card-flush mb-6 mb-xl-9">
                                        <div class="card-header mt-6">
                                            <div class="card-title flex-column">
                                                <h2 class="mb-1">User's Tasks</h2>
                                                <div class="fs-6 fw-semibold text-muted">Total 25 tasks in backlog</div>
                                            </div>
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex align-items-center position-relative mb-7">
                                                <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                                                <div class="fw-semibold ms-5">
                                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary">Create FureStibe branding logo</a>
                                                    <div class="fs-7 text-muted">Due in 1 day 
                                                    <a href="#">Karina Clark</a></div>
                                                </div>
                                                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" data-kt-menu-id="kt-users-tasks">
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center position-relative mb-7">
                                                <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                                                <div class="fw-semibold ms-5">
                                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary">Schedule a meeting with FireBear CTO John</a>
                                                    <div class="fs-7 text-muted">Due in 3 days 
                                                    <a href="#">Rober Doe</a></div>
                                                </div>
                                                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" data-kt-menu-id="kt-users-tasks">
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center position-relative mb-7">
                                                <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                                                <div class="fw-semibold ms-5">
                                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary">9 Degree Project Estimation</a>
                                                    <div class="fs-7 text-muted">Due in 1 week 
                                                    <a href="#">Neil Owen</a></div>
                                                </div>
                                                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" data-kt-menu-id="kt-users-tasks">
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center position-relative mb-7">
                                                <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                                                <div class="fw-semibold ms-5">
                                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary">Dashboard UI & UX for Leafr CRM</a>
                                                    <div class="fs-7 text-muted">Due in 1 week 
                                                    <a href="#">Olivia Wild</a></div>
                                                </div>
                                                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" data-kt-menu-id="kt-users-tasks">
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center position-relative">
                                                <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                                                <div class="fw-semibold ms-5">
                                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary">Mivy App R&D, Meeting with clients</a>
                                                    <div class="fs-7 text-muted">Due in 2 weeks 
                                                    <a href="#">Sean Bean</a></div>
                                                </div>
                                                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" data-kt-menu-id="kt-users-tasks">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="kt_user_view_overview_security" role="tabpanel">
                                    <div class="card pt-4 mb-6 mb-xl-9">
                                        <div class="card-header border-0">
                                            <div class="card-title">
                                                <h2>Profile</h2>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0 pb-5">
                                            <div class="table-responsive">
                                                <table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
                                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                                        <tr>
                                                            <td>Email</td>
                                                            <td>{{$user->email}}</td>
                                                            <td class="text-end">
                                                                <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_update_email">
                                                                    <i class="ki-duotone ki-pencil fs-3">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Password</td>
                                                            <td>******</td>
                                                            <td class="text-end">
                                                                <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_update_password">
                                                                    <i class="ki-duotone ki-pencil fs-3">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                </button>
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
                    </div>
                    <div class="modal fade" id="kt_modal_update_details" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <div class="modal-content">
                                <div class="modal-header" id="kt_modal_add_user_header">
                                    <h2 class="fw-bold">Update User</h2>
                                    <!-- <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                                        <i class="ki-duotone ki-cross fs-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div> -->
                                </div>
                                <form id="form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#" enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px" style="max-height: 307px;">
                                        <div class="fv-row mb-7">
                                            <input type="hidden" name="invited_by" value="{{Auth::user()->id}}">
                                            <input type="hidden" name="user_id" value="{{$user->id}}">
                                            <input type="hidden" name="action" value="update">
                                            <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
                                            <div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
                                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url('{{asset("uploads/users/".$user->profile_pic)}}');"></div>
                                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar" data-bs-original-title="Change avatar" data-kt-initialized="1">
                                                    <i class="ki-duotone ki-pencil fs-7">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                    <input type="file" name="profile_pic" accept=".png, .jpg, .jpeg">
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
                                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                        </div>
                                        <div class="fv-row mb-7 fv-plugins-icon-container">
                                            <label class="required fw-semibold fs-6 mb-2">Full Name</label>
                                            <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="{{$user->name}}" value="{{$user->name}}">
                                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                        <div class="fv-row mb-7 fv-plugins-icon-container">
                                            <label class="required fw-semibold fs-6 mb-2">Email</label>
                                            <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="{{$user->email}}" value="{{$user->email}}">
                                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                        <div class="fv-row mb-7 fv-plugins-icon-container">
                                            <label class="fw-semibold fs-6 mb-2">Contact No</label>
                                            <input type="number" name="contact_no" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="{{$user->contact_no}}" value="{{$user->contact_no}}">
                                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                        <div class="fv-row mb-7 fv-plugins-icon-container">
                                            <label class="required fw-semibold fs-6 mb-2">Password</label>
                                            <input type="password" name="password" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="********">
                                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                        <div class="fv-row mb-7 fv-plugins-icon-container">
                                            <label class="fw-semibold fs-6 mb-2">Description</label>
                                            <textarea name="description" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="{{$user->description}}">{{$user->description}}</textarea>
                                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                        <div class="mb-5">
                                            <label class="required fw-semibold fs-6 mb-5">Role</label>
                                            @foreach($roles as $key => $role)
                                                <div class="d-flex fv-row">
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input me-3" @if(isset($user->role) && $key == $user->role) checked @elseif($key == $user->roles[0]->id) checked="checked" @endif name="roles" type="radio" value="{{$role}}" id="kt_modal_update_role_option_{{$role}}">
                                                        <label class="form-check-label" for="kt_modal_update_role_option_{{$role}}">
                                                            <div class="fw-bold text-gray-800">{{$role}}</div>
                                                        </label>
                                                    </div>
                                                </div>
                                            <div class="separator separator-dashed my-5"></div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="text-center py-10">
                                        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
                                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                            <span class="indicator-label">Submit</span>
                                            <span class="indicator-progress">Please wait... 
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="kt_modal_update_email" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="fw-bold">Update Email Address</h2>
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                                        <i class="ki-duotone ki-cross fs-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                    <form id="kt_modal_update_email_form" class="form" action="#">
                                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                                            <i class="ki-duotone ki-information fs-2tx text-primary me-4">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            <div class="d-flex flex-stack flex-grow-1">
                                                <div class="fw-semibold">
                                                    <div class="fs-6 text-gray-700">Please note that a valid email address is required to complete the email verification.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span class="required">Email Address</span>
                                            </label>
                                            <input class="form-control form-control-solid" placeholder="" name="profile_email" value="smith@kpmg.com" />
                                        </div>
                                        <div class="text-center pt-15">
                                            <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
                                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                                <span class="indicator-label">Submit</span>
                                                <span class="indicator-progress">Please wait... 
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="kt_modal_update_password" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="fw-bold">Update Password</h2>
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                                        <i class="ki-duotone ki-cross fs-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                    <form id="kt_modal_update_password_form" class="form" action="#">
                                        <div class="fv-row mb-10">
                                            <label class="required form-label fs-6 mb-2">Current Password</label>
                                            <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="current_password" autocomplete="off" />
                                        </div>
                                        <div class="mb-10 fv-row" data-kt-password-meter="true">
                                            <div class="mb-1">
                                                <label class="form-label fw-semibold fs-6 mb-2">New Password</label>
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="new_password" autocomplete="off" />
                                                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                                        <i class="ki-duotone ki-eye-slash fs-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                        </i>
                                                        <i class="ki-duotone ki-eye d-none fs-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                    </span>
                                                </div>
                                                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                                </div>
                                            </div>
                                            <div class="text-muted">Use 8 or more characters with a mix of letters, numbers & symbols.</div>
                                        </div>
                                        <div class="fv-row mb-10">
                                            <label class="form-label fw-semibold fs-6 mb-2">Confirm New Password</label>
                                            <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="confirm_password" autocomplete="off" />
                                        </div>
                                        <div class="text-center pt-15">
                                            <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
                                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                                <span class="indicator-label">Submit</span>
                                                <span class="indicator-progress">Please wait... 
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="kt_modal_update_role" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="fw-bold">Update User Role</h2>
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                                        <i class="ki-duotone ki-cross fs-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                    <form id="kt_modal_update_role_form" class="form" action="#">
                                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                                            <i class="ki-duotone ki-information fs-2tx text-primary me-4">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            <div class="d-flex flex-stack flex-grow-1">
                                                <div class="fw-semibold">
                                                    <div class="fs-6 text-gray-700">Please note that reducing a user role rank, that user will lose all priviledges that was assigned to the previous role.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-semibold form-label mb-5">
                                                <span class="required">Select a user role</span>
                                            </label>
                                            <div class="d-flex">
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input me-3" name="user_role" type="radio" value="0" id="kt_modal_update_role_option_0" checked='checked' />
                                                    <label class="form-check-label" for="kt_modal_update_role_option_0">
                                                        <div class="fw-bold text-gray-800">Administrator</div>
                                                        <div class="text-gray-600">Best for business owners and company administrators</div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class='separator separator-dashed my-5'></div>
                                            <div class="d-flex">
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input me-3" name="user_role" type="radio" value="1" id="kt_modal_update_role_option_1" />
                                                    <label class="form-check-label" for="kt_modal_update_role_option_1">
                                                        <div class="fw-bold text-gray-800">Developer</div>
                                                        <div class="text-gray-600">Best for developers or people primarily using the API</div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class='separator separator-dashed my-5'></div>
                                            <div class="d-flex">
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input me-3" name="user_role" type="radio" value="2" id="kt_modal_update_role_option_2" />
                                                    <label class="form-check-label" for="kt_modal_update_role_option_2">
                                                        <div class="fw-bold text-gray-800">Analyst</div>
                                                        <div class="text-gray-600">Best for people who need full access to analytics data, but don't need to update business settings</div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class='separator separator-dashed my-5'></div>
                                            <div class="d-flex">
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input me-3" name="user_role" type="radio" value="3" id="kt_modal_update_role_option_3" />
                                                    <label class="form-check-label" for="kt_modal_update_role_option_3">
                                                        <div class="fw-bold text-gray-800">Support</div>
                                                        <div class="text-gray-600">Best for employees who regularly refund payments and respond to disputes</div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class='separator separator-dashed my-5'></div>
                                            <div class="d-flex">
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input me-3" name="user_role" type="radio" value="4" id="kt_modal_update_role_option_4" />
                                                    <label class="form-check-label" for="kt_modal_update_role_option_4">
                                                        <div class="fw-bold text-gray-800">Trial</div>
                                                        <div class="text-gray-600">Best for people who need to preview content data, but don't need to make any updates</div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center pt-15">
                                            <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
                                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                                <span class="indicator-label">Submit</span>
                                                <span class="indicator-progress">Please wait... 
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="kt_modal_add_auth_app" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="fw-bold">Add Authenticator App</h2>
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                                        <i class="ki-duotone ki-cross fs-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                    <div class="fw-bold d-flex flex-column justify-content-center mb-5">
                                        <div class="text-center mb-5" data-kt-add-auth-action="qr-code-label">Download the 
                                        <a href="#">Authenticator app</a>, add a new account, then scan this barcode to set up your account.</div>
                                        <div class="text-center mb-5 d-none" data-kt-add-auth-action="text-code-label">Download the 
                                        <a href="#">Authenticator app</a>, add a new account, then enter this code to set up your account.</div>
                                        <div class="d-flex flex-center" data-kt-add-auth-action="qr-code">
                                            <img src="assets/media/misc/qr.png" alt="Scan this QR code" />
                                        </div>
                                        <div class="border rounded p-5 d-flex flex-center d-none" data-kt-add-auth-action="text-code">
                                            <div class="fs-1">gi2kdnb54is709j</div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-center">
                                        <div class="btn btn-light-primary" data-kt-add-auth-action="text-code-button">Enter code manually</div>
                                        <div class="btn btn-light-primary d-none" data-kt-add-auth-action="qr-code-button">Scan barcode instead</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="kt_modal_add_one_time_password" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="fw-bold">Enable One Time Password</h2>
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                                        <i class="ki-duotone ki-cross fs-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                    <form class="form" id="kt_modal_add_one_time_password_form">
                                        <div class="fw-bold mb-9">Enter the new phone number to receive an SMS to when you log in.</div>
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span class="required">Mobile number</span>
                                                <span class="ms-2" data-bs-toggle="tooltip" title="A valid mobile number is required to receive the one-time password to validate your account login.">
                                                    <i class="ki-duotone ki-information fs-7">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" name="otp_mobile_number" placeholder="+6123 456 789" value="" />
                                        </div>
                                        <div class="separator saperator-dashed my-5"></div>
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span class="required">Email</span>
                                            </label>
                                            <input type="email" class="form-control form-control-solid" name="otp_email" value="smith@kpmg.com" readonly="readonly" />
                                        </div>
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span class="required">Confirm password</span>
                                            </label>
                                            <input type="password" class="form-control form-control-solid" name="otp_confirm_password" value="" />
                                        </div>
                                        <div class="text-center pt-15">
                                            <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Cancel</button>
                                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                                <span class="indicator-label">Submit</span>
                                                <span class="indicator-progress">Please wait... 
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                    </form>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript">
    $('#form').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "{{ route('users.custom_update',$user->id) }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                if(data.success){
                    // this.reset();
                    toastr.success(data.success);
                }else{
                    if (typeof (data.error) !== 'undefined') {
                        toastr.error(data.error);
                    }
                }
            },
            error: function(data) {
                var txt         = '';
                // console.log(data.responseJSON.errors[0])
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
