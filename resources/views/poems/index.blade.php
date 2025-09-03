@extends('layouts.app')

@section('styles')
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Times+New+Roman:ital,wght@0,400;0,700;1,400;1,700&display=swap">
<style>
    .book-container {
        margin-bottom: 40px;
        perspective: 1000px;
    }

    .book {
        position: relative;
        width: 50%;
        height: 250px;
        transform-style: preserve-3d;
        transform-origin: center left;
        transition: transform 0.5s ease;
        cursor: pointer;
    }

    .book-cover {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 5px;
        background-color: white;
        transform-origin: left;
        transform-style: preserve-3d;
        transition: transform 1.2s ease;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: black;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        border: 1px solid #e0e0e0;
    }

    .book-spine {
        position: absolute;
        width: 30px;
        height: 100%;
        left: -15px;
        background: linear-gradient(to right, #e0e0e0, #f5f5f5);
        transform: rotateY(90deg) translateZ(15px);
        z-index: 1;
        border-radius: 3px 0 0 3px;
        border: 1px solid #d0d0d0;
    }

    .book-page {
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: #f8f8f8;
        border-radius: 0 5px 5px 0;
        transform-origin: left;
        z-index: -1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 15px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }

    .book-page-1 {
        background-color: #f0f0f0;
        transform: rotateY(0.01deg);
    }

    .book-page-2 {
        background-color: #e8e8e8;
        transform: rotateY(0.02deg);
    }

    .book-page-3 {
        background-color: #e0e0e0;
        transform: rotateY(0.03deg);
    }

    .book.open .book-cover {
        transform: rotateY(-160deg);
        box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
    }

    .book.open .book-page-1 {
        transform: rotateY(-20deg);
        transition-delay: 0.2s;
    }

    .book.open .book-page-2 {
        transform: rotateY(-40deg);
        transition-delay: 0.4s;
    }

    .book.open .book-page-3 {
        transform: rotateY(-60deg);
        transition-delay: 0.6s;
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
        color: #333;
    }

    .poem-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }

    .book-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.85);
        z-index: 9999;
        display: none;
        justify-content: center;
        align-items: center;
    }

    .book-overlay-content {
        max-width: 90%;
        max-height: 90%;
        position: relative;
    }

    .book-overlay-image {
        max-width: 100%;
        max-height: 90vh;
        box-shadow: 0 0 30px rgba(255, 255, 255, 0.2);
    }

    .close-overlay {
        position: absolute;
        top: -40px;
        right: 0;
        color: white;
        font-size: 2rem;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .close-overlay:hover {
        transform: scale(1.2);
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
            height: 200px;
        }
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-3">Poems</h1>
    <p class="text-center text-muted mb-5">A collection of poetic expressions</p>

    @if(count($poems) > 0)
    <div class="row">
        @foreach($poems as $poem)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="book-container">
                <div class="book" data-id="{{ $poem->id }}" data-image="{{ asset('storage/' . $poem->image) }}"
                    data-title="{{ $poem->title }}">
                    <div class="book-spine"></div>
                    <div class="book-cover">
                        <i class="fas fa-book-open book-icon"></i>
                        <h3 class="book-title">{{ $poem->title }}</h3>
                    </div>
                    <div class="book-page book-page-1"></div>
                    <div class="book-page book-page-2"></div>
                    <div class="book-page book-page-3">
                        <img src="{{ asset('storage/' . $poem->image) }}" alt="{{ $poem->title }}" class="poem-image">
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

<div class="book-overlay" id="bookOverlay">
    <div class="book-overlay-content">
        <span class="close-overlay">&times;</span>
        <img src="" alt="Poem" class="book-overlay-image" id="overlayImage">
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const books = document.querySelectorAll('.book');
        const overlay = document.getElementById('bookOverlay');
        const overlayImage = document.getElementById('overlayImage');
        const closeButton = document.querySelector('.close-overlay');
        let activeBook = null;
        
        // Function to open book
        function openBook(book) {
            book.classList.add('open');
            activeBook = book;
        }
        
        // Function to close book
        function closeBook(book) {
            book.classList.remove('open');
        }
        
        // Function to show overlay with full-size image
        function showOverlay(imageSrc, title) {
            overlayImage.src = imageSrc;
            overlayImage.alt = title;
            overlay.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        }
        
        // Function to close overlay
        function closeOverlay() {
            overlay.style.display = 'none';
            document.body.style.overflow = 'auto'; // Re-enable scrolling
            
            // Close all books after a short delay
            setTimeout(() => {
                if (activeBook) {
                    closeBook(activeBook);
                    activeBook = null;
                }
            }, 300);
        }
        
        // Add click event to each book
        books.forEach(book => {
            book.addEventListener('click', function() {
                const poemId = this.dataset.id;
                const imageSrc = this.dataset.image;
                const title = this.dataset.title;
                
                // First open the book
                openBook(this);
                
                // After a delay to show the book opening animation, show the overlay
                setTimeout(() => {
                    showOverlay(imageSrc, title);
                }, 1000);
            });
        });
        
        // Close overlay when clicking the close button
        closeButton.addEventListener('click', function() {
            closeOverlay();
        });
        
        // Close overlay when clicking outside the image
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                closeOverlay();
            }
        });
        
        // Close overlay with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && overlay.style.display === 'flex') {
                closeOverlay();
            }
        });
        
        // Add hover effect for better UX
        books.forEach(book => {
            book.addEventListener('mouseenter', function() {
                // Slight lift effect on hover
                this.style.transform = 'translateY(-5px)';
            });
            
            book.addEventListener('mouseleave', function() {
                // Reset position if not opened
                if (!this.classList.contains('open')) {
                    this.style.transform = 'translateY(0)';
                }
            });
        });
    });
</script>
@endsection