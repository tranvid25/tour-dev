@include('clients.layout.header')
<div class="form-back-drop"></div>

        <!-- Hidden Sidebar -->
        <section class="hidden-bar">
            <div class="inner-box text-center">
                <div class="cross-icon"><span class="fa fa-times"></span></div>
                <div class="title">
                    <h4>Get Appointment</h4>
                </div>

                <!--Appointment Form-->
                <div class="appointment-form">
                    <form method="post" action="https://webtendtheme.net/html/2024/ravelo/contact.html">
                        <div class="form-group">
                            <input type="text" name="text" value="" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" value="" placeholder="Email Address" required>
                        </div>
                        <div class="form-group">
                            <textarea placeholder="Message" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="theme-btn style-two">
                                <span data-hover="Submit now">Submit now</span>
                                <i class="fal fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!--Social Icons-->
                <div class="social-style-one">
                    <a href="contact.html"><i class="fab fa-twitter"></i></a>
                    <a href="contact.html"><i class="fab fa-facebook-f"></i></a>
                    <a href="contact.html"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                </div>
            </div>
        </section>
        <!--End Hidden Sidebar -->


        <!-- Page Banner Start -->
        <section class="page-banner-area pt-50 pb-35 rel z-1 bgs-cover" style="background-image: url(clients/assets/images/banner/banner.jpg);">
            <div class="container">
                <div class="banner-inner text-white">
                    <h2 class="page-title mb-10" data-aos="fade-left" data-aos-duration="1500" data-aos-offset="50">About Us</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-20" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1500" data-aos-offset="50">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active">Information</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </section>
<div class="container mt-5">
    <h3 class="mb-4">Cập nhật thông tin người dùng</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('clients.user.update', ['id' => session('user')['id']]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Họ tên -->
        <div class="mb-3">
            <input type="text" name="userName" class="form-control @error('userName') is-invalid @enderror"
                value="{{ old('userName', session('user')['name']) }}" required>
            @error('userName') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', session('user')['email']) }}" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Số điện thoại -->
        <div class="mb-3">
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                value="{{ old('phone', session('user')['phone']) }}" required>
            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Địa chỉ -->
        <div class="mb-3">
            <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address', session('user')['address']) }}</textarea>
            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Avatar -->
        <div class="mb-3">
            @if(session('user')['avatar'])
                <div class="mb-2">
                    <img src="{{ asset('uploads/avatars/' . session('user')['avatar']) }}" width="100" alt="Avatar">
                </div>
            @endif
            <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror">
            @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@include('clients.layout.footer')
