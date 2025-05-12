<!--Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html lang="en">
<head>
<title>Clean Login Form a Flat Responsive Widget Template :: w3layouts</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Clean Login Form Responsive, Login Form Web Template, Flat Pricing Tables, Flat Drop-Downs, Sign-Up Web Templates, Flat Web Templates, Login Sign-up Responsive Web Template, Smartphone Compatible Web Template, Free Web Designs for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design" />

<!-- css files -->
<link href="/admin/login/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all">
<link href="/admin/login/css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- /css files -->

<!-- online fonts -->
<link href="//fonts.googleapis.com/css?family=Sirin+Stencil" rel="stylesheet">
<!-- online fonts -->

<body>
<div class="container demo-1">
	<div class="content">
        <div id="large-header" class="large-header">
			<h1>Admin Supervisor</h1>
				<div class="main-agileits">
				<!--form-stars-here-->
                <div class="form-w3-agile">
                    <h2>create Now</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                   <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('create.admin') }}" method="post">
                        @csrf
                        <div class="form-sub-w3">
                            <input type="text" name="userName" value="{{ old('userName') }}" placeholder="Enter Name" required />
                            <div class="icon-w3">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="form-sub-w3">
                            <input type="text" name="email" value="{{ old('email') }}" placeholder="Enter Email" required />
                            <div class="icon-w3">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="form-sub-w3">
                            <input type="password" name="passWord" placeholder="Enter Password" required />
                            <div class="icon-w3">
                                <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="form-sub-w3">
                            <input type="password" name="passWord_confirmation" placeholder="Enter Password" required />
                            <div class="icon-w3">
                                <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                            </div>
                        </div>
                        <p class="p-bottom-w3ls">Forgot Password? <a href="#">Click here</a></p>
                        <p class="p-bottom-w3ls1">New User? <a href="#">Register here</a></p>
                        <div class="submit-w3l">
                            <input type="submit" value="Login">
                        </div>
                    </form>

                    <div class="social w3layouts">
                        <div class="heading">
                            <h5>Or Login with</h5>
                        </div>
                        <div class="icons">
                            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
				<!--//form-ends-here-->
				</div><!-- copyright -->
					<!-- //copyright -->
        </div>
	</div>
</div>

</body>
</html>
