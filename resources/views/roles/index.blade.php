@extends('layouts.main')
@section('title','Roles')
@section('content')
    @include( '../sweet_script')
    <div class="toolbar py-5 pb-lg-15" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-white fw-bold my-1 fs-3">Roles List</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                    <li class="breadcrumb-item text-white opacity-75">Roles</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            @if(session('success_message'))
                <div class="alert alert-success alert-dismissible fade show mx-5 d-flex justify-content-between" role="alert">
                    <strong>{{session('success_message')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-warning alert-dismissible fade show mx-5 d-flex justify-content-between" role="alert">
                    <strong>session('error')</strong>
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
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
                @foreach($roles as $key => $role)
                    <div class="col-md-4">
                        <div class="card card-flush h-md-100">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>{{$role->name}}</h2>
                                </div>
                            </div>
                            <div class="card-body pt-1">
                                <div class="fw-bold text-gray-600 mb-5">Total users with this role: {{$role->user_count}}</div>
                                <div class="d-flex flex-column text-gray-600">
                                    <!-- <div class="d-flex align-items-center py-2">
                                    <span class="bullet bg-primary me-3"></span>All Admin Controls</div>
                                    <div class="d-flex align-items-center py-2">
                                    <span class="bullet bg-primary me-3"></span>View and Edit Financial Summaries</div>
                                    <div class="d-flex align-items-center py-2">
                                    <span class="bullet bg-primary me-3"></span>Enabled Bulk Reports</div>
                                    <div class="d-flex align-items-center py-2">
                                    <span class="bullet bg-primary me-3"></span>View and Edit Payouts</div>
                                    <div class="d-flex align-items-center py-2">
                                    <span class="bullet bg-primary me-3"></span>View and Edit Disputes</div>
                                    <div class='d-flex align-items-center py-2'>
                                        <span class='bullet bg-primary me-3'></span>
                                        <em>and 7 more...</em>
                                    </div> -->
                                </div>
                            </div>
                            <div class="card-footer flex-wrap pt-0 d-flex gap-2">
                                <button type="button" class="btn btn-light btn-active-light-primary my-1 edit-role-button" data-role-id="{{$role->id}}" data-role-name="{{$role->name}}" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">Edit Role</button>
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light btn-active-light-primary my-1">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="ol-md-4">
                    <div class="card h-md-100">
                        <div class="card-body d-flex flex-center">
                            <button type="button" class="btn btn-clear d-flex flex-column flex-center" data-bs-toggle="modal" data-bs-target="#kt_modal_add_role">
                                <img src="assets/media/illustrations/sigma-1/4.png" alt="" class="mw-100 mh-150px mb-7" />
                                <div class="fw-bold fs-3 text-gray-600 text-hover-primary">Add New Role</div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="kt_modal_add_role" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-750px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="fw-bold">Add a Role</h2>
                        </div>
                        <div class="modal-body scroll-y mx-lg-5 my-7">
                            <form id="role_form" class="form" action="#">
                                @csrf
                                <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_role_header" data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px">
                                    <div class="fv-row mb-10">
                                        <label class="fs-5 fw-bold form-label mb-2">
                                            <span class="required">Role name</span>
                                        </label>
                                        <input name="action" type="hidden" value="store" />
                                        <input class="form-control form-control-solid" placeholder="Enter a role name" name="name" />
                                    </div>
                                    <div class="fv-row">
                                        <label class="fs-5 fw-bold form-label mb-2 required">Role Permissions</label>
                                        <div class="table-responsive">
                                            <!-- <table class="table align-middle table-row-dashed fs-6 gy-5">
                                                <tbody class="text-gray-600 fw-semibold">
                                                    <tr>
                                                        <td class="text-gray-800">Administrator Access 
                                                        <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Allows a full access to the system">
                                                            <i class="ki-duotone ki-information fs-7">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>
                                                        </span></td>
                                                        <td>
                                                            <label class="form-check form-check-custom form-check-solid me-9">
                                                                <input class="form-check-input" type="checkbox" value="" id="kt_roles_select_all" />
                                                                <span class="form-check-label" for="kt_roles_select_all">Select all</span>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table> -->

                                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                                <!-- <tr>
                                                    <td class="text-gray-800">Administrator Access 
                                                    <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Allows a full access to the system">
                                                        <i class="ki-duotone ki-information fs-7">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                    </span></td>
                                                    <td>
                                                        <label class="form-check form-check-custom form-check-solid me-9">
                                                            <input class="form-check-input" type="checkbox" value="" id="kt_roles_select_all" />
                                                            <span class="form-check-label" for="kt_roles_select_all">Select all</span>
                                                        </label>
                                                    </td>
                                                </tr> -->
                                                <tr>
                                                    <th></th>
                                                    <th><span class="form-check-label">List / Show</span></th>
                                                    <th><span class="form-check-label">Create / Store</span></th>
                                                    <th><span class="form-check-label">Edit / Update</span></th>
                                                    <th><span class="form-check-label">Delete</span></th>
                                                </tr>
                                                <?php   
                                                        $i=0;
                                                        $val = $permissions[0]['name'];
                                                        $explodedFirstValue = explode("-", $val);
                                                        $firstVal = $explodedFirstValue[0];  // exploded permission name
                                                ?>
                                                <tr>
                                                    <td> {{ ucfirst($firstVal)}}</td>
                                                    <?php
                                                        foreach($permissions as $value){
                                                            $currentVal = $value->name;
                                                         
                                                            $explodedLastValue = explode("-", $currentVal);
                                                            $LastVal = $explodedLastValue[0];
                                                            if( $firstVal == $LastVal){ ?>
                                                                
                                                                        
                                                    <td>
                                                        <div class="checkbox-inline">
                                                            <div class="d-flex">
                                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                    <input class="form-check-input permission_check" type="checkbox" value="{{$value->id}}" name="permission[]" />
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <?php }else{
                                                            $firstVal = $LastVal;
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td> <label>{{ ucfirst($firstVal)}}</label></td>
                                                    <td>
                                                        <div class="checkbox-inline">
                                                            <div class="d-flex">
                                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                    <input class="form-check-input" type="checkbox" value="{{$value->id}}" name="permission[]" />
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <?php }} ?>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center pt-15">
                                    <button type="reset" class="btn btn-light me-3" data-kt-roles-modal-action="cancel">Discard</button>
                                    <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
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
                <div class="modal-dialog modal-dialog-centered mw-750px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="fw-bold">Update Role</h2>
                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-roles-modal-action="close">
                                <i class="ki-duotone ki-cross fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                        </div>
                        <div class="modal-body scroll-y mx-5 my-7">
                            <form id="role_form_update" class="form" action="#">
                                @csrf
                                <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_role_header" data-kt-scroll-wrappers="#kt_modal_update_role_scroll" data-kt-scroll-offset="300px">
                                    <div class="fv-row mb-10">
                                        <label class="fs-5 fw-bold form-label mb-2">
                                            <span class="required">Role name</span>
                                        </label>
                                        <input type="hidden" id="role_id" name="role_id" value="">
                                        <input name="action" type="hidden" value="update" />
                                        <input class="form-control form-control-solid" placeholder="Enter a role name" name="name" value="" />
                                    </div>
                                    <div class="fv-row">
                                        <label class="fs-5 fw-bold form-label mb-2">Role Permissions</label>
                                        <div class="table-responsive">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                                <tbody class="text-gray-600 fw-semibold">
                                                    <tr>
                                                        <th></th>
                                                        <th><span class="form-check-label">List / Show</span></th>
                                                        <th><span class="form-check-label">Create / Store</span></th>
                                                        <th><span class="form-check-label">Edit / Update</span></th>
                                                        <th><span class="form-check-label">Delete</span></th>
                                                    </tr>
                                                    <?php   
                                                        $i=0;
                                                        $val = $permissions[0]['name'];
                                                        $explodedFirstValue = explode("-", $val);
                                                        $firstVal = $explodedFirstValue[0];  // exploded permission name
                                                    ?>
                                                    <tr>
                                                        <td> {{ ucfirst($firstVal)}}</td>
                                                        <?php
                                                        foreach($permissions as $permission){
                                                            $currentVal = $permission->name;
                                                            $explodedLastValue = explode("-", $currentVal);
                                                            $LastVal = $explodedLastValue[0];
                                                            if( $firstVal == $LastVal){ ?>
                                                                <td>
                                                                    <div class="checkbox-inline">
                                                                        <div class="d-flex">
                                                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                                <input class="form-check-input permission-checkbox" type="checkbox" value="{{$permission->id}}" name="permission[]" />
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            <?php } else {
                                                                $firstVal = $LastVal;
                                                                ?>
                                                                </tr>
                                                                <tr>
                                                                    <td> <label>{{ ucfirst($firstVal)}}</label></td>
                                                                    <td>
                                                                        <div class="checkbox-inline">
                                                                            <div class="d-flex">
                                                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                                    <input class="form-check-input permission-checkbox" type="checkbox" value="{{$permission->id}}" name="permission[]" />
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                            <?php }} ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center pt-15">
                                    <button type="reset" class="btn btn-light me-3" data-kt-roles-modal-action="cancel">Discard</button>
                                    <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
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
    <br>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript">
        $('#role_form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('roles.store') }}",
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


        document.addEventListener('DOMContentLoaded', function() {
            // Get all elements with the class "edit-role-button"
            const editRoleButtons = document.querySelectorAll('.edit-role-button');

            $('#role_form_update').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('roles.update.custom') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        if(data.success){
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
                        var txt = '';
                        console.log(data.responseJSON.errors[0])
                        for (var key in data.responseJSON.errors) {
                            txt += data.responseJSON.errors[key];
                            txt +='<br>';
                        }
                        toastr.error(txt);
                    }
                });
            });

            // Add click event listener to each "Edit Role" button
            editRoleButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    // Extract the role ID and name from the button's data attributes
                    const roleId = this.getAttribute('data-role-id');
                    const roleName = this.getAttribute('data-role-name');

                    // Get the modal's hidden input field for role_id
                    const roleIdInput = document.querySelector('#kt_modal_update_role input[name="role_id"]');
                    // Get the modal's input field for role_name
                    const roleNameInput = document.querySelector('#kt_modal_update_role input[name="name"]');

                    // Update the value of the hidden input field with the role ID
                    roleIdInput.value = roleId;

                    // Update the value of the input field for role name with the role name
                    roleNameInput.value = roleName;

                    const role_check = {!! json_encode($roles) !!};

                    role_check.forEach(role => {
                        if (roleId == role.id) {
                            const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');

                            // Uncheck all checkboxes before checking the relevant ones
                            permissionCheckboxes.forEach(checkbox => {
                                checkbox.checked = false;
                            });

                            const arr = role.permission_ids.split(',').map(Number);
                            const obj = {};

                            arr.forEach(num => {
                                // Iterate over each checkbox
                                permissionCheckboxes.forEach(checkbox => {
                                    if (checkbox.value == num) {
                                        checkbox.checked = true; // Set checked attribute to true
                                    }
                                });
                            });
                        }
                    });

                });
            });

        });

    </script>

@endsection
