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