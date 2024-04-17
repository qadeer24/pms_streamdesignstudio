@extends('layouts.main')
@section('title','Categories')
@section('content')
    @include( '../sweet_script')
    <div class="toolbar py-5 pb-lg-15" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-white fw-bold my-1 fs-3">Category List</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                    <li class="breadcrumb-item text-white opacity-75">Categories</li>
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
               @foreach($categories as $key => $category)
                    <div class="col-md-4">
                        <div class="card card-flush h-md-100">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>{{$category->name}}</h2>
                                </div>
                            </div>
                            <div class="card-body pt-1">
                                <div class="fw-bold text-gray-600">{{$category->description}}</div>
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
                            <div class="card-footer flex-wrap pt-0 d-flex">
                                <button type="button" class="btn btn-light btn-active-light-primary my-1 edit-category-button" data-category-id="{{$category->id}}" data-category-name="{{$category->name}}" data-category-desc="{{$category->description}}" data-bs-toggle="modal" data-bs-target="#kt_modal_update_category">Edit Category</button>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn bg-body btn-active-color-primary">Delete</button>
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
                                <div class="fw-bold fs-3 text-gray-600 text-hover-primary">Add New Category</div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="kt_modal_add_role" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-750px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="fw-bold">Add a Category</h2>
                        </div>
                        <div class="modal-body scroll-y mx-lg-5 my-7">
                            <form id="category_form" method="post" class="form">
                                @csrf
                                <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll">
                                    <div class="fv-row mb-10">
                                        <label class="fs-5 fw-bold form-label mb-2">
                                            <span class="required">Category name</span>
                                        </label>
                                        <input name="action" type="hidden" value="store" />
                                        <input class="form-control form-control-solid" placeholder="Enter a category name" name="name" />
                                    </div>
                                    <div class="fv-row mb-10">
                                        <label class="fs-5 fw-bold form-label mb-2">
                                            <span>Description</span>
                                        </label>
                                        <textarea class="form-control form-control-solid" placeholder="description" name="description"></textarea>
                                    </div>
                                </div>
                                <div class="text-center pt-15">
                                    <button type="reset" class="btn btn-light me-3" data-kt-roles-modal-action="cancel">Discard</button>
                                    <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
                                        <span class="indicator-label">Submit</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="kt_modal_update_category" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-750px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="fw-bold">Update Category</h2>
                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-roles-modal-action="close">
                                <i class="ki-duotone ki-cross fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                        </div>
                        <div class="modal-body scroll-y mx-5 my-7">
                            <form id="category_form_update" class="form">
                                @csrf
                                <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll">
                                    <div class="fv-row mb-10">
                                        <label class="fs-5 fw-bold form-label mb-2">
                                            <span class="required">Category name</span>
                                        </label>
                                        <input name="action" type="hidden" value="store" />
                                        <input type="hidden" name="cat_id" id="cat_id" />
                                        <input class="form-control form-control-solid" placeholder="Enter a category name" name="name" />
                                    </div>
                                    <div class="fv-row mb-10">
                                        <label class="fs-5 fw-bold form-label mb-2">
                                            <span>Description</span>
                                        </label>
                                        <textarea class="form-control form-control-solid" placeholder="description" name="description"></textarea>
                                    </div>
                                </div>
                                <div class="text-center pt-15">
                                    <button type="reset" class="btn btn-light me-3" data-kt-roles-modal-action="cancel">Discard</button>
                                    <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
                                        <span class="indicator-label">Submit</span>
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
        $('#category_form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('categories.store') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    if(data.success){
                        this.reset();
                        location.reload();
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


        $('#category_form_update').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('categories.update_custom') }}",
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

        const editCatButtons = document.querySelectorAll('.edit-category-button');

        editCatButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                // Extract the role ID and name from the button's data attributes
                const categoryId = this.getAttribute('data-category-id');
                const categoryName = this.getAttribute('data-category-name');
                const categoryDesc = this.getAttribute('data-category-desc');

                
                const categoryIdInput = document.querySelector('#kt_modal_update_category input[name="cat_id"]');
                
                const categoryNameInput = document.querySelector('#kt_modal_update_category input[name="name"]');

                const categoryDescInput = document.querySelector('#kt_modal_update_category textarea[name="description"]');

                
                categoryIdInput.value = categoryId;

                categoryNameInput.value = categoryName;

                categoryDescInput.value = categoryDesc;

            });
        });

    </script>

@endsection
