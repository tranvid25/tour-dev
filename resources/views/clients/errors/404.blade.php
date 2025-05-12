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


<!-- 404 Error Area start -->
<section class="error-area pt-70 pb-100 rel z-1">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-5 col-lg-6">
                <div class="error-content rmb-55" data-aos="fade-left" data-aos-duration="1500" data-aos-offset="50">
                    <h1>OPPS! </h1>
                    <div class="section-title mt-15 mb-25">
                        <h2>This Page Can’t be Found</h2>
                    </div>
                    <p>Best features to include on business landing page are those that quickly convey your value proposition, build trust, and encourage action. Here are six essential features</p>
                    <form class="newsletter-form mt-40 mb-50" action="#">
                        <input id="news-email" type="text" placeholder="Search keyword" required>
                        <button type="submit" class="theme-btn bgc-secondary style-two">
                            <span data-hover="Search">Search</span>
                            <i class="fal fa-arrow-right"></i>
                        </button>
                    </form>
                    <div class="keywords">
                        <a href="blog.html">Travel</a>
                        <a href="blog.html">Luxury Hotel</a>
                        <a href="blog.html">Indonesia</a>
                        <a href="blog.html">Sea Beach</a>
                        <a href="blog.html">Camping</a>
                        <a href="blog.html">Hiking</a>
                        <a href="blog.html">Fishing</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-6">
                <div class="error-images" data-aos="fade-right" data-aos-duration="1500" data-aos-offset="50">
                    <img src="assets/images/newsletter/404.png" alt="404 Error">
                </div>
            </div>
        </div>
    </div>
</section>
@include('clients.layout.footer')
