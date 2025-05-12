@include('clients.layout.header')
    <div class="main">

        <!-- Sign up form -->

        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="/clients/assets/images/login/signin-image.jpg" alt="sing up image"></figure>
                        <a href="#" class="signup-image-link">Login Here</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Sign In</h2>
                        <form action="{{route('form_login')}}" method="POST" class="register-form" id="login-form">
                            @csrf
                            @if (session('error'))
                                <p style="color:red">{{ session('error') }}</p>
                            @endif
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="email" id="email" placeholder="Your Email" required/>
                            </div>
                            <div class="form-group">
                                <label for="passWord"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="passWord" id="passWord" placeholder="Password" required/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                            </div>
                        </form>

                        <div class="social-login">
                            <span class="social-label">Or login with</span>
                            <ul class="socials">
                                <li><a href="{{route('login.facebook')}}"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                                <li><a href="{{route('login.google')}}"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                            </ul>
                        </div>
                        <div>
                            <a href="{{route('index_register')}}">Đăng kí nếu chưa có tài khoản</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@include('clients.layout.footer')

