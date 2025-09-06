@extends('layouts.app')

@section('styles')
<style>
    .testimonial-header {
        background: linear-gradient(rgba(30, 80, 162, 0.8), rgba(10, 36, 99, 0.8)),
        url('{{ asset("images/enlightening-bg.webp") }}');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 5rem 0;
        margin-bottom: 3rem;
        position: relative;
    }

    .testimonial-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 50px;
        background: linear-gradient(to bottom right, transparent 49%, white 50%);
    }

    .testimonial-card {
        display: flex;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #eee;
        align-items: center;
    }

    @media (max-width: 767px) {
        .testimonial-card {
            flex-direction: column;
            text-align: center;
        }
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .testimonial-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid darkgrey;
        margin-right: 2rem;
        flex-shrink: 0;
        margin: 30px
    }

    @media (max-width: 767px) {
        .testimonial-img {
            margin-right: 0;
            margin-bottom: 1rem;
        }
    }

    .testimonial-icon-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light, #5b92e5) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 2rem;
        flex-shrink: 0;
        border: 5px solid darkgrey;
        margin: 30px
    }

    @media (max-width: 767px) {
        .testimonial-icon-placeholder {
            margin-right: 0;
            margin-bottom: 1rem;
        }
    }

    .testimonial-icon-placeholder i {
        font-size: 60px;
        color: white;
        opacity: 0.8;
    }

    .testimonial-content {
        padding: 2rem;
        position: relative;
        flex-grow: 1;
    }

    .testimonial-text {
        font-style: italic;
        color: #555;
        line-height: 1.8;
        position: relative;
        padding: 0 1rem;
    }

    .testimonial-text::before,
    .testimonial-text::after {
        content: '"';
        font-size: 3rem;
        color: var(--primary-blue);
        opacity: 0.2;
        position: absolute;
        line-height: 0;
    }

    .testimonial-text::before {
        top: 0.5rem;
        left: -1rem;
    }

    .testimonial-text::after {
        bottom: -0.5rem;
        right: -1rem;
    }

    .testimonial-name {
        font-weight: 600;
        color: var(--primary-blue);
        margin-bottom: 0.2rem;
        font-size: 1.2rem;
    }

    .testimonial-designation {
        font-size: 0.9rem;
        color: var(--primary-orange);
        margin-bottom: 1rem;
    }

    .section-title {
        position: relative;
        display: inline-block;
        margin-bottom: 3rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background-color: var(--primary-orange);
    }

    .team-table {
        width: 100%;
        margin: 0 auto 3rem;
        border-collapse: collapse;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
        overflow: hidden;
    }

    .team-table th,
    .team-table td {
        padding: 1rem 1.5rem;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .team-table th {
        background-color: var(--primary-blue);
        color: white;
        font-weight: 600;
    }

    .team-table tr:last-child td {
        border-bottom: none;
    }

    .team-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .team-table .table-caption {
        font-size: 1.2rem;
        font-weight: 600;
        padding: 1.5rem;
        background-color: #f3f3f3;
        color: var(--primary-dark);
        text-align: center;
        caption-side: top;
    }

    @media (max-width: 767px) {
        .team-table th,
        .team-table td {
            padding: 0.5rem;
            font-size: 0.8rem;
        }

        .testimonial-header {
            padding: 3rem 0;
        }

        .testimonial-text {
            font-size: 0.95rem;
            line-height: 1.7;
        }

        .testimonial-name {
            font-size: 1.1rem;
        }
    }
</style>
@endsection

@section('content')

<!-- Team Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="fw-bold section-title">WHO’S WHO OF PY?</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <table class="team-table">
                    <caption class="table-caption">Executive Committee of Governing Body of the Society Prasthan Yatnam (PY).</caption>
                    <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>NAME</th>
                            <th>DESIGNATION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1.</td>
                            <td>Raina Bhattacharjee</td>
                            <td>Director/ Margdarshak/ Founder</td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>Bhrigu Kumar Mishra</td>
                            <td>General Secretary cum Treasurer</td>
                        </tr>
                        <tr>
                            <td>3.</td>
                            <td>Akash Das</td>
                            <td>Joint Secretary cum Technology & Operations</td>
                        </tr>
                        <tr>
                            <td>4.</td>
                            <td>Jahnavi Baruah</td>
                            <td>Finance</td>
                        </tr>
                        <tr>
                            <td>5.</td>
                            <td>Smita Bezboruah</td>
                            <td>Finance</td>
                        </tr>
                        <tr>
                            <td>6.</td>
                            <td>Bobita Goswami</td>
                            <td>Finance</td>
                        </tr>
                        <tr>
                            <td>7.</td>
                            <td>Rajita Goswami</td>
                            <td>General Operations</td>
                        </tr>
                        <tr>
                            <td>8.</td>
                            <td>Jayashree Kalita</td>
                            <td>General Operations</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="fw-bold section-title">Testimonials</h2>
            </div>
        </div>

        @if($testimonials->count() > 0)
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @foreach($testimonials as $testimonial)
                <div class="testimonial-card bg-white">
                    @if($testimonial->image)
                    <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}"
                        class="testimonial-img">
                    @else
                    <div class="testimonial-icon-placeholder">
                        <i class="fas fa-user"></i>
                    </div>
                    @endif
                    <div class="testimonial-content">
                        <div class="testimonial-text mb-4">
                            {{ $testimonial->message }}
                        </div>
                        <h4 class="testimonial-name">{{ $testimonial->name }}</h4>
                        <p class="testimonial-designation">{{ $testimonial->designation }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-12 text-center">
                <p class="lead">No testimonials available yet.</p>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection