@extends('layouts.main')
@section('title','Users')
@section('content')
    @include( '../sweet_script')
    <script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
        <div class="d-flex flex-column flex-root">
            <div class="page d-flex flex-row flex-column-fluid">
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    <div class="toolbar py-5 pb-lg-15" id="kt_toolbar">
                        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
                            <div class="page-title d-flex flex-column me-3">
                                <h1 class="d-flex text-white fw-bold my-1 fs-3">Users</h1>
                                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                                    <li class="breadcrumb-item text-white opacity-75">Users</li>
                                </ul>
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
                            <div class="d-flex flex-wrap flex-stack pb-7">
                                <div class="d-flex flex-wrap align-items-center my-1">
                                    <h3 class="fw-bold me-5 my-1 text-white">Users ({{count($users)}})</h3>
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <input type="text" id="kt_filter_search" class="form-control form-control-sm border-body bg-body w-150px ps-10" placeholder="Search" />
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap my-1">
                                    <ul class="nav nav-pills me-6 mb-2 mb-sm-0">
                                        <li class="nav-item m-0">
                                            <a class="btn btn-sm btn-icon btn-light btn-color-muted btn-active-primary me-3 active" data-bs-toggle="tab" href="#kt_project_users_card_pane">
                                                <i class="ki-duotone ki-element-plus fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                </i>
                                            </a>
                                        </li>
                                        <li class="nav-item m-0">
                                            <a class="btn btn-sm btn-icon btn-light btn-color-muted btn-active-primary" data-bs-toggle="tab" href="#kt_project_users_table_pane">
                                                <i class="ki-duotone ki-row-horizontal fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="card-toolbar">
                                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                                            <i class="ki-duotone ki-plus fs-2"></i>Add User</button>
                                            &nbsp;
                                            &nbsp;
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_member">
                                            <i class="ki-duotone ki-plus fs-2"></i>Invite user</button>
                                        </div>
                                        <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                                <div class="modal-content">
                                                    <div class="modal-header" id="kt_modal_add_user_header">
                                                        <h2 class="fw-bold">Add User</h2>
                                                        <!-- <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                                                            <i class="ki-duotone ki-cross fs-1">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </div> -->
                                                    </div>
                                                    <div class="modal-body px-5 my-7">
                                                        <form id="form" autocomplete="off" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px" style="max-height: 307px;">
                                                                <div class="fv-row mb-7">
                                                                    <input type="hidden" name="invited_by" value="{{Auth::user()->id}}">
                                                                    <input type="hidden" name="action" value="store">
                                                                    <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
                                                                    <div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
                                                                        <div class="image-input-wrapper w-125px h-125px" style="background-image: url(assets/media/svg/files/blank-image.svg);"></div>
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
                                                                    <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Full name" value="">
                                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                                                <div class="fv-row mb-7 fv-plugins-icon-container">
                                                                    <label class="required fw-semibold fs-6 mb-2">Email</label>
                                                                    <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="example@domain.com" value="">
                                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                                                <div class="fv-row mb-7 fv-plugins-icon-container">
                                                                    <label class="fw-semibold fs-6 mb-2">Contact No</label>
                                                                    <input type="number" name="contact_no" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="03001234567" value="">
                                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                                                <div class="fv-row mb-7 fv-plugins-icon-container">
                                                                    <label class="required fw-semibold fs-6 mb-2">Password</label>
                                                                    <input type="password" name="password" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="********">
                                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                                                <div class="fv-row mb-7 fv-plugins-icon-container">
                                                                    <label class="fw-semibold fs-6 mb-2">Description</label>
                                                                    <textarea name="description" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Description"></textarea>
                                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                                                <div class="mb-5">
                                                                    <label class="required fw-semibold fs-6 mb-5">Role</label>
                                                                    @foreach($roles as $key => $role)
                                                                        <div class="d-flex fv-row">
                                                                            <div class="form-check form-check-custom form-check-solid">
                                                                                <input class="form-check-input me-3" name="roles" type="radio" value="{{$role}}" id="kt_modal_update_role_option_{{$role}}">
                                                                                <label class="form-check-label" for="kt_modal_update_role_option_{{$role}}">
                                                                                    <div class="fw-bold text-gray-800">{{$role}}</div>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    <div class="separator separator-dashed my-5"></div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="text-center pt-10">
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
                                        <div class="modal fade" id="kt_modal_add_member" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                                <div class="modal-content">
                                                    <div class="modal-header position-relative" id="kt_modal_add_user_header">
                                                        <h2 class="fw-bold">Invite Member</h2>
                                                        <!-- <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                                                            <i class="ki-duotone ki-cross fs-1">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </div> -->
                                                        <div id="loading" class="position-absolute" style="width: 50px; right: 20px; opacity: 0.8; display: none;">
                                                            <img src="{{asset('assets/media/svg/loading.gif')}}" style="width: 100%;height: 100px;object-fit: contain;">
                                                        </div>
                                                    </div>
                                                    <div class="modal-body px-5 my-7">
                                                        <form id="invite_member" autocomplete="off" class="form fv-plugins-bootstrap5 fv-plugins-framework position-relative" action="#" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px" style="max-height: 307px;">
                                                                <div class="fv-row mb-7 fv-plugins-icon-container">
                                                                    <label class="required fw-semibold fs-6 mb-2">Email to invite</label>
                                                                    <input type="text" name="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="example@mail.com" value="">
                                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                                                <div class="fv-row mb-7 fv-plugins-icon-container">
                                                                    <label class="required fw-semibold fs-6 mb-2">Short message for user</label>
                                                                    <textarea name="short_message" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="You are invited to..."></textarea>
                                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                                                <div class="mb-5">
                                                                    <label class="required fw-semibold fs-6 mb-5">Role</label>
                                                                    @foreach($member_roles as $key => $role)
                                                                        <div class="d-flex fv-row">
                                                                            <div class="form-check form-check-custom form-check-solid">
                                                                                <input class="form-check-input me-3" name="role" type="radio" value="{{$key}}" id="kt_modal_update_role_option_{{$role}}">
                                                                                <label class="form-check-label" for="kt_modal_update_role_option_{{$role}}">
                                                                                    <div class="fw-bold text-gray-800 ml-4">{{$role}}</div>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="separator separator-dashed my-5"></div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="text-center pt-10">
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
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div id="kt_project_users_card_pane" class="tab-pane fade show active">
                                    <div class="row g-6 g-xl-9">
                                        @foreach($users as $key => $user)
                                            <div class="col-md-6 col-xxl-4">
                                                <div class="card">
                                                    <div class="card-body d-flex flex-center flex-column pt-12 p-9">
                                                        <div class="symbol symbol-65px symbol-circle mb-5">
                                                            @if(isset($user->profile_pic) || $user->profile_pic != "")
                                                                <img src="{{asset('uploads/users/'.$user->profile_pic)}}" alt="image" style="object-fit: cover;"/>
                                                            @else
                                                                <img src="{{asset('uploads/no_image1.png')}}" alt="image" style="object-fit: cover;"/>
                                                            @endif
                                                            <div class="bg-success position-absolute border border-4 border-body h-15px w-15px rounded-circle translate-middle start-100 top-100 ms-n3 mt-n3"></div>
                                                        </div>
                                                        <a href="{{route('user.view',['user'=>$user->id])}}" class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">{{$user->name}}</a>
                                                        <div class="fw-semibold text-gray-500 mb-6">{{ucfirst($user->email)}}</div>
                                                        <div class="d-flex flex-center flex-wrap">
                                                            <div class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                                                <div class="fs-6 fw-bold text-gray-700">{{$user->roles[0]->name}}</div>
                                                                <div class="fw-semibold text-gray-500">Role</div>
                                                            </div>
                                                            <div class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                                                <div class="fs-6 fw-bold text-gray-700">$236,400</div>
                                                                <div class="fw-semibold text-gray-500">Salary</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div id="kt_project_users_table_pane" class="tab-pane fade">
                                    <div class="card card-flush">
                                        <div class="card-body pt-0">
                                            <div class="table-responsive">
                                                <h3 class="text-dark fw-bold my-5 fs-3">All Users</h3>
                                                <table id="kt_project_users_table" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
                                                    <thead class="fs-7 text-gray-500 text-uppercase">
                                                        <tr>
                                                            <th class="min-w-250px">Name</th>
                                                            <th class="min-w-150px">Date Created/Joined</th>
                                                            <th class="min-w-90px">Status</th>
                                                            <th class="min-w-50px text-end">Details</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="fs-6">
                                                        @foreach($users as $key => $user)
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="me-5 position-relative">
                                                                            <div class="symbol symbol-35px symbol-circle">
                                                                                @if(isset($user->profile_pic) || $user->profile_pic != "")
                                                                                    <img src="{{asset('uploads/users/'.$user->profile_pic)}}" alt="image" style="object-fit: cover;"/>
                                                                                @else
                                                                                    <img src="{{asset('uploads/no_image1.png')}}" alt="image" style="object-fit: cover;"/>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex flex-column justify-content-center">
                                                                            <a href="{{route('user.view',['user'=>$user->name])}}" class="mb-1 text-gray-800 text-hover-primary">{{$user->name}}</a>
                                                                            <div class="fw-semibold fs-6 text-gray-500">{{$user->email}}</div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>{{$user->created_at}}</td>
                                                                <td>
                                                                    @if($user->active == "Active")
                                                                        <span class="badge badge-light-success fw-bold px-4 py-3">{{$user->active}}</span>
                                                                    @else
                                                                        <span class="badge badge-light-danger fw-bold px-4 py-3">{{$user->active}}</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-end">
                                                                    <a href="#" class="btn btn-light btn-sm">View</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#form').submit(function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('users.store') }}",
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
                            // console.log(data.responseJSON.errors[0])
                            for (var key in data.responseJSON.errors) {
                                txt += data.responseJSON.errors[key];
                                txt +='<br>';
                            }
                            toastr.error(txt);
                        }
                    });
                });
                $('#invite_member').submit(function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('users.invite_member') }}",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function(){
                            $("#loading").show();
                        },
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: (data) => {
                            if(data.success){
                                this.reset();
                                toastr.success(data.success);
                            }
                        },
                        error: function(data) {
                            var errorMessage = '';

                            // Check if the response has validation errors
                            if (data.responseJSON && data.responseJSON.error) {
                                // Display the validation error message returned by Laravel
                                errorMessage = data.responseJSON.error;
                            } else {
                                // If no specific validation errors are returned, use a generic error message
                                errorMessage = 'An error occurred while processing your request.';
                            }

                            // Display the error message using Toastr
                            toastr.error(errorMessage);
                        }


                    });
                });
            });
        </script>
@endsection
