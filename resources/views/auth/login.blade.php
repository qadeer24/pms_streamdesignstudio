@extends('layouts.app')

@section('content')	
	<body id="kt_body" class="auth-bg bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
		<div class="d-flex flex-column flex-root">
			<div class="d-flex flex-column flex-column-fluid flex-lg-row">
				<div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
					<div class="d-flex flex-center flex-lg-start flex-column">
						<a href="index.html" class="mb-7">
							<img alt="Logo" src="{{asset('assets/media/logos/stream_logo.png')}}" />
						</a>
						<h2 class="text-white fw-normal m-0">Branding tools designed for your business</h2>
					</div>
				</div>
				<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
					<div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
						<div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
							<form class="form w-100" id="kt_sign_in_form" method="post" action="{{ route('login') }}">
                                @csrf
								<div class="text-center mb-11">
									<h1 class="text-gray-900 fw-bolder mb-3">Sign In</h1>
									@if(session('success_message'))
                                    	<span class="d-block mt-3" role="alert">
                                            <h5><strong class="text-success">{{ session('success_message') }}</strong></h5>
                                        </span>
                                    @endif
								</div>
								<div class="fv-row mb-8">
									<input type="email" placeholder="Email" name="email" required autocomplete="off" class="form-control bg-transparent" />
                                    @error('email')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <h5><strong class="text-danger">{{ $message }}</strong></h5>
                                        </span>
                                    @enderror
                                </div>
								<div class="fv-row mb-3">
									<input type="password" placeholder="Password" name="password" required autocomplete="off" class="form-control bg-transparent" />
                                    @error('password')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <h4><strong>{{ $message }}</strong></h4>
                                        </span>
                                    @enderror
								</div>
								<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
									<div></div>
									<a href="{{route('reset_pass')}}" class="link-primary">Forgot Password ?</a>
								</div>
								<div class="d-grid mb-10">
									<button type="submit" class="btn btn-primary">
										<span class="indicator-label">Sign In</span>
										<span class="indicator-progress">Please wait... 
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									</button>
								</div>
								<div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet? 
								<a href="{{route('register')}}" class="link-primary">Sign up</a></div>
							</form>
						</div>
						<div class="d-flex flex-stack px-lg-10">
							<div class="d-flex fw-semibold text-primary fs-base gap-5">
								<a href="pages/team.html" target="_blank">Terms</a>
								<a href="pages/contact.html" target="_blank">Contact Us</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>var hostUrl = "assets/";</script>
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<script src="assets/js/custom/authentication/sign-up/general.js"></script>
	</body>
@endsection