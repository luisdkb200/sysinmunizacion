<html>
<head>
	<title>SISTEMA PARA EL CONTROL DE ENTREGA DE BIOLOGICOS</title> 
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="shortcut icon" type="image/ico" href="{{asset('dist/img/logogsrb2.png')}}" />
<!--===============================================================================================-->

<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/animate/animate.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-02.jpg" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="POST" action="{{ route('login')}}">
                    {{ csrf_field() }}
					<span class="login100-form-title">
						SISTEMA PARA EL CONTROL DE ENTREGA DE BIOLOGICOS
					</span>

					<div class="wrap-input100 {{ $errors->has('email') ? 'has-error' : '' }} ">
						<input class="input100" type="text" name="email" placeholder="Email" value="{{old ('email')}}" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
                            <i class="fa fa-id-card" aria-hidden="true"></i>
							{{-- <i class="fa fa-envelope" aria-hidden="true"></i> --}}
						</span>
					</div>
                    {!! $errors->first('email', '<span class="help-block text-danger"
                        style ="font-size: 1em">:message </span>') !!}

					<div class="wrap-input100 {{ $errors->has('password') ? 'has-error' : '' }} ">
						<input class="input100" type="password" name="password" placeholder="Contraseña" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
                    {!! $errors->first('password', '<span class="help-block text-danger"
                    style ="font-size: 1em">:message </span>') !!}
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							ENTRAR
						</button>
					</div>

					{{-- <div class="text-center p-t-12">
						<span class="txt1">
							Olvidaste
						</span>
						<a class="txt2" href="#">
							Nombre de Usuario / Contraseña?
						</a>
					</div> --}}

					{{-- <div class="text-center p-t-136">
						<a class="txt2" href="#">
							Crear una cuenta
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div> --}}
				</form>
			</div>
		</div>
	</div>




<!--===============================================================================================-->
	<script src="{{asset('vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('vendor/tilt/tilt.jquery.min.js')}}"></script>


<!--===============================================================================================-->
	<script src="{{asset('js/main.js')}}"></script>

</body>
</html>
