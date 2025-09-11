@extends('layouts.app')

@section('styles')
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Times+New+Roman:ital,wght@0,400;0,700;1,400;1,700&display=swap">
<style>
    .book-container {
        margin-bottom: 40px;
        perspective: 1500px;
    }

    .book {
        position: relative;
        width: 220px;
        height: 300px;
        transform-style: preserve-3d;
        transform-origin: center left;
        transition: transform 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        cursor: pointer;
    }

    .book-cover {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 2px 10px 10px 2px;
        background-color: #79443B;
        background-image:
            linear-gradient(to right, rgba(0, 0, 0, 0.2) 0%, rgba(255, 255, 255, 0.1) 10%, rgba(0, 0, 0, 0.1) 20%, transparent 40%),
            url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1IiBoZWlnaHQ9IjUiPgo8cmVjdCB3aWR0aD0iNSIgaGVpZ2h0PSI1IiBmaWxsPSIjNzQ0NDNiIj48L3JlY3Q+CjxwYXRoIGQ9Ik0wIDVMNSAwWk02IDRMNCA2Wk0tMSAxTDEgLTFaIiBzdHJva2U9IiMwMDAwMDAiIHN0cm9rZS13aWR0aD0iMSIgc3Ryb2tlLW9wYWNpdHk9IjAuMSI+PC9wYXRoPgo8L3N2Zz4=');
        transform-origin: left;
        transform-style: preserve-3d;
        transition: transform 1s ease-in-out;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: white;
        padding-left: 30px;
        box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3);
        border: 1px solid #4a2c25;
    }

    .book-cover::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 0;
        width: 3px;
        height: 100%;
        background: rgba(0, 0, 0, 0.2);
    }

    .book-spine {
        position: absolute;
        width: 40px;
        height: 100%;
        left: 0;
        background: #5C4033;
        transform: rotateY(-90deg) translateX(-100%);
        transform-origin: right;
        z-index: 0;
        border-radius: 2px 0 0 2px;
        box-shadow: inset 5px 0 10px rgba(0, 0, 0, 0.2);
    }

    .book-page {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-color: #fdfaf4;
        border-radius: 0 8px 8px 0;
        transform-origin: left;
        transition: transform 0.8s ease-in-out;
        z-index: -1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 15px;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .book-page-1 {
        transition-delay: 0.1s;
    }

    .book-page-2 {
        transition-delay: 0.2s;
    }

    .book-page-3 {
        transition-delay: 0.3s;
    }

    .book.open .book-cover {
        transform: rotateY(-170deg) translateZ(-10px);
        box-shadow: -10px 10px 20px rgba(0, 0, 0, 0.3);
    }

    .book.open .book-page-1 {
        transform: rotateY(-25deg);
    }

    .book.open .book-page-2 {
        transform: rotateY(-50deg);
    }

    .book.open .book-page-3 {
        transform: rotateY(-145deg);
    }

    .book-title {
        font-family: 'Times New Roman', Times, serif;
        font-style: italic;
        font-size: 1.5rem;
        text-align: center;
        margin-top: 15px;
        padding: 0 15px;
    }

    .book-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        color: white;
    }

    .poem-image-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        overflow: hidden;
    }

    .poem-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }

    .poem-image-link {
        cursor: zoom-in;
    }

    .no-poems {
        min-height: 300px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: #6c757d;
    }

    /* Book hover effect */
    .book:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .book {
            width: 180px;
            height: 250px;
        }

        .book-title {
            font-size: 1.2rem;
        }

        .book-icon {
            font-size: 2rem;
        }
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
@endsection

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-3">Poems</h1>
    <p class="text-center text-muted mb-5">A collection of poetic expressions</p>

    @if(count($poems) > 0)
    <div class="row">
        @foreach($poems as $poem)
        <div class="col-lg-4 col-md-6 col-12 mb-4 d-flex justify-content-center">
            <div class="book-container">
                <div class="book" data-id="{{ $poem->id }}">
                    <div class="book-spine"></div>
                    <div class="book-cover">
                        <i class="fas fa-book-open book-icon"></i>
                        <h3 class="book-title">{{ $poem->title }}</h3>
                    </div>
                    <div class="book-page book-page-1"></div>
                    <div class="book-page book-page-2"></div>
                    <div class="book-page book-page-3">
                        <div class="poem-image-container">
                            @if (Str::startsWith($poem->file_type, 'image/'))
                            <a href="{{ asset('storage/' . $poem->file_path) }}" data-fancybox="poem-gallery"
                                data-caption="{{ $poem->title }}" class="poem-image-link">
                                <img src="{{ asset('storage/' . $poem->file_path) }}" alt="{{ $poem->title }}"
                                    class="poem-image">
                            </a>
                            @elseif ($poem->file_type === 'application/pdf')
                                <a href="{{ asset('storage/' . $poem->file_path) }}" download class="poem-pdf-link">
                                    <div class="text-center">
                                        <i class="fas fa-file-pdf fa-4x text-secondary"></i>
                                        <p class="mt-2">Download PDF</p>
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="no-poems">
        <i class="fas fa-book fa-4x mb-3 text-secondary"></i>
        <p class="lead">No poems have been added yet</p>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const books = document.querySelectorAll('.book');
        let activeBook = null;

        function openBook(book) {
            if (activeBook && activeBook !== book) {
                closeBook(activeBook);
            }
            book.classList.add('open');
            activeBook = book;
        }

        function closeBook(book) {
            book.classList.remove('open');
        }

        Fancybox.bind('[data-fancybox="poem-gallery"]', {
            on: {
                destroy: () => {
                    if (activeBook) {
                        closeBook(activeBook);
                        activeBook = null;
                    }
                },
            },
        });

        books.forEach(book => {
            book.addEventListener('click', function(e) {
                if (this.classList.contains('open')) {
                    return;
                }
                
                openBook(this);

                const imageLink = this.querySelector('.poem-image-link');
                const pdfLink = this.querySelector('.poem-pdf-link');

                if (imageLink) {
                    setTimeout(() => {
                        imageLink.click();
                    }, 800);
                } else if (pdfLink) {
                    pdfLink.click();
                    setTimeout(() => {
                        if (activeBook) {
                            closeBook(activeBook);
                            activeBook = null;
                        }
                    }, 400); // Close the book shortly after initiating download
                }
            });
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (activeBook && !document.querySelector('.fancybox__container')) {
                    closeBook(activeBook);
                    activeBook = null;
                }
            }
        });
    });
</script>
@endsection