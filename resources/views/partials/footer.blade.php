<footer class="bg-dark text-white py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4">
                <p class="small text-white-50 mb-md-0">
                    &copy; {{ date('Y') }} Prasthan Yatnam. All rights reserved.
                </p>
            </div>
            <div class="col-md-4 text-center">
                <p class="small text-white-50 mb-md-0">
                    Developed by Richad Ali
                </p>
            </div>
            <div class="col-md-4">
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

    @media (max-width: 767.98px) {
        footer .text-center {
            text-align: left !important;
            margin: 0.5rem 0;
        }

        footer .text-md-end {
            text-align: left !important;
        }
    }
</style>