<footer class="bg-dark text-white py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4">
                <p class="small text-white-50 mb-md-0">
                    All contents included in this web portal are Copyright © protected.
                </p>
            </div>
            <div class="col-md-4 text-center">
                <p class="small text-white-50 mb-md-0">
                    Conceptualization and Design by AKASH DAS <br>
                    <a href="https://richadali.dev" target="_blank" style="text-decoration:none">Developed by Richad
                        Ali</a>
                </p>
            </div>
            <div class="col-md-4">
                <div class="text-md-end">
                    <a href="#" class="text-white-50 text-decoration-none small me-3">Privacy Policy</a>
                    <a href="{{ asset('images/Acknowledgment form.pdf') }}" target="_blank"
                        class="text-white-50 text-decoration-none small">Acknowledgements</a>
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
        footer .col-md-4 {
            text-align: center !important;
            margin-bottom: 0.5rem;
        }

        footer .text-md-end {
            text-align: center !important;
        }
    }
</style>