<footer class="bg-dark text-white pt-5 pb-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <h5 class="text-uppercase fw-bold mb-4">Prasthan Yatnam</h5>
                <p class="small">
                    Our endeavour is to 'Live and Let Live', to embrace One and all, to pick up the gems from all
                    quarters, to remain forever open minded.
                </p>
                <div class="mt-4">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook-f fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-youtube fa-lg"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                <h6 class="text-uppercase fw-bold mb-4">Quick Links</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Home</a></li>
                    <li class="mb-2"><a href="{{ url('/discourses') }}"
                            class="text-white-50 text-decoration-none">Discourses</a></li>
                    <li class="mb-2"><a href="{{ url('/poems') }}" class="text-white-50 text-decoration-none">Poems</a>
                    </li>
                    <li class="mb-2"><a href="{{ url('/activity') }}"
                            class="text-white-50 text-decoration-none">Activity</a></li>
                    <li class="mb-2"><a href="{{ url('/testimonials') }}"
                            class="text-white-50 text-decoration-none">Testimonials</a></li>
                    <li><a href="{{ url('/about') }}" class="text-white-50 text-decoration-none">About Us</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h6 class="text-uppercase fw-bold mb-4">Courses</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Hinduism</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Divine Mother</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Sai Baba</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">View All Courses</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="text-uppercase fw-bold mb-4">Contact Us</h6>
                <p class="small mb-2"><i class="fas fa-home me-2"></i> 123 Spiritual Street, City, Country</p>
                <p class="small mb-2"><i class="fas fa-envelope me-2"></i> info@prasthanyatnam.com</p>
                <p class="small mb-2"><i class="fas fa-phone me-2"></i> +91 1234567890</p>
                <p class="small"><i class="fas fa-clock me-2"></i> Mon - Fri: 9am - 5pm</p>
            </div>
        </div>

        <hr class="my-4">

        <div class="row align-items-center">
            <div class="col-md-7 col-lg-8">
                <p class="small text-white-50 mb-md-0">
                    &copy; {{ date('Y') }} Prasthan Yatnam. All rights reserved.
                </p>
            </div>
            <div class="col-md-5 col-lg-4">
                <div class="text-md-end">
                    <a href="#" class="text-white-50 text-decoration-none small me-3">Privacy Policy</a>
                    <a href="#" class="text-white-50 text-decoration-none small">Terms of Use</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    footer a:hover {
        color: var(--primary-orange) !important;
        transition: all 0.3s ease;
    }

    footer .fab:hover {
        color: var(--primary-orange);
        transform: translateY(-3px);
        transition: all 0.3s ease;
    }
</style>