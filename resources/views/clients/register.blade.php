@include('clients.layout.header')
    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form action="{{ route('form_register') }}" method="POST" class="register-form" id="register-form" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="userName"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="userName" id="userName" placeholder="Your Name"/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email"/>
                            </div>
                            <div class="form-group">
                                <label for="passWord"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="passWord" id="passWord" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <label for="passWord_confirmation"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="passWord_confirmation" id="passWord_confirmation" placeholder="Repeat your password"/>
                            </div>
                            <div class="form-group">
                                <label for="phoneNumber"><i class="zmdi zmdi-phone"></i></label>
                                <input type="text" name="phoneNumber" id="phoneNumber" placeholder="Your Phone Number"/>
                            </div>
                            <div class="form-group">
                                <label for="address"><i class="zmdi zmdi-pin"></i></label>
                                <input type="text" name="address" id="address" placeholder="Your Address"/>
                            </div>
                            <div class="form-group">
                                <label for="avatar"><i class="zmdi zmdi-image"></i></label>
                                <input type="file" name="avatar" id="avatar"/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in <a href="#" class="term-service">Terms of service</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>

                    </div>
                    <div class="signup-image">
                        <figure><img src="/clients/assets/images/login/signup-image.jpg" alt="sing up image"></figure>
                        <a href="#" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sing in  Form -->

    </div>
@include('clients.layout.footer')

