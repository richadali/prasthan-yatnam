@extends('layouts.app')

@section('content')
<div class="about-page">
    <!-- Header -->
    <div class="container py-4">
        <h1 class="text-center mb-3" style="color: #000080;">Help Desk</h1>
        <p class="text-center motto-text" style="color: #FA8128;">How can we help you?</p>
    </div>

    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <p>If you have any questions or need assistance, please feel free to contact us. We are here to help!</p>
            </div>
        </div>
    </div>
</div>

<style>
    .about-page {
        font-family: 'Times New Roman', serif;
        line-height: 1.6;
        color: #333;
        background-color: #fff;
    }

    .about-page .container.py-3 {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 30px 25px !important;
    }

    h1 {
        font-family: 'Times New Roman', serif;
    }

    p {
        margin-bottom: 1.2rem;
        text-align: center;
        font-size: 1.2rem;
        font-weight: 500;
    }

    .motto-text {
        color: #805319;
        /* Changed color to a vibrant orange */
        font-style: italic;
        font-weight: bolder;
        font-size: 1.2rem;
    }
</style>
@endsection