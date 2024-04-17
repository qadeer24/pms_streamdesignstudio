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
							<form class="form w-100" data-kt-redirect-url="{{route('home')}}" method="POST"  action="{{ route('register') }}">
								@csrf
								<div class="text-center mb-11">
									<h1 class="text-gray-900 fw-bolder mb-3">Sign Up</h1>
								</div>
								<div class="fv-row mb-8">
									<input type="text" placeholder="Name" name="name" autocomplete="off" class="form-control bg-transparent" />
									@error('name')
										<span class="invalid-feedback d-block" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
								<div class="fv-row mb-8">
									@if(session('user_register_email'))
										<input type="email" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" value="{{session('user_register_email')}}" />
										<input type="hidden" name="roles" value="{{session('user_register_role')}}" />
										<input type="hidden" name="user_id" value="{{session('user_register_id')}}" />
		                            @else
										<input type="email" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
									@endif
									@error('email')
										<span class="invalid-feedback d-block" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
								<div class="fv-row mb-8" data-kt-password-meter="true">
									<div class="mb-1">
										<div class="position-relative mb-3">
											<input class="form-control bg-transparent" type="password" placeholder="Password" name="password" autocomplete="off" />
											@error('password')
												<span class="invalid-feedback d-block" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
											<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
												<i class="ki-duotone ki-eye-slash fs-2"></i>
												<i class="ki-duotone ki-eye fs-2 d-none"></i>
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
								<div class="fv-row mb-8">
									<input placeholder="Repeat Password" name="password_confirmation" type="password" autocomplete="off" class="form-control bg-transparent" />
									@error('password')
										<span class="invalid-feedback d-block" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
								<div class="fv-row mb-8">
									<label class="form-check form-check-inline">
										<input class="form-check-input" type="checkbox" name="toc" value="1" />
										<span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">I Accept the 
										<a href="#" class="ms-1 link-primary">Terms</a></span>
									</label>
								</div>
								<div class="d-grid mb-10">
									<button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
										<span class="indicator-label">Sign up</span>
										<span class="indicator-progress">Please wait... 
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									</button>
								</div>
								<div class="text-gray-500 text-center fw-semibold fs-6">Already have an Account? 
								<a href="{{route('login')}}" class="link-primary fw-semibold">Sign in</a></div>
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