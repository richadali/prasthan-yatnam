@extends('layouts.app')

@section('styles')
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Times+New+Roman:ital,wght@0,400;0,700;1,400;1,700&display=swap">
<style>
    .poem-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .poem-title {
        font-family: 'Times New Roman', Times, serif;
        font-style: italic;
        font-size: 2.5rem;
        margin-bottom: 30px;
        color: var(--primary-blue);
        text-align: center;
    }

    .poem-image-container {
        text-align: center;
        margin-bottom: 30px;
    }

    .poem-image {
        max-width: 100%;
        max-height: 70vh;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        margin-bottom: 30px;
        color: var(--primary-blue);
        text-decoration: none;
        font-weight: 500;
    }

    .back-link:hover {
        color: var(--dark-blue);
    }

    .back-icon {
        margin-right: 8px;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="poem-container">
        <a href="{{ route('poems') }}" class="back-link">
            <i class="fas fa-arrow-left back-icon"></i> Back to Poems
        </a>

        <h1 class="poem-title">{{ $poem->title }}</h1>

        <div class="poem-image-container">
            <img src="{{ asset('storage/' . $poem->image) }}" alt="{{ $poem->title }}" class="poem-image">
        </div>
    </div>
</div>
@endsection