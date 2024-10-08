<!-- ======= Contact Section ======= -->
<section id="contact" class="contact">
    <div class="container">

        <div class="row">
            <div class="col-lg-6">
                <div class="info-box mb-4">
                    <i class="bx bx-map"></i>
                    <h3>Corporate Address</h3>
                    <p>{!!$address!!}</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="info-box  mb-4">
                    <i class="bx bx-envelope"></i>
                    <h3>Email Us</h3>
                    <p>{{ $email  }}</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="info-box  mb-4">
                    <i class="bx bx-phone-call"></i>
                    <h3>Call Us</h3>
                    <p>{{ $phone }}</p>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-lg-6 ">
                <div class="col-lg-12">
                    <div class="info-box mb-4">
                        <i class="bx bx-map"></i>
                        <h3>Executive Office</h3>
                        <p>{!!$executiveOfficeAddress!!}</p>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="info-box mb-4">
                        <i class="bx bx-map"></i>
                        <h3>Overseas Office</h3>
                        <p>{!!$overseasOfficeAddress!!}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <form action="{{ route('createCustomerRequest') }}" method="post" class="php-email-form">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                        </div>
                        <div class="col-md-6 form-group mt-3 mt-md-0">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                    </div>
                    <div class="form-group mt-3">
                        <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                    </div>
                    <div class="my-3">
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Your message has been sent. Thank you!</div>
                    </div>
                    <div class="text-center"><button type="submit">Send Message</button></div>
                </form>
            </div>

        </div>

    </div>
</section>
<!-- End Contact Section -->
