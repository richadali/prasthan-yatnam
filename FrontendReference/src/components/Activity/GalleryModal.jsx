import React, { useState } from 'react';
import galleryModalStyles from './GalleryModal.module.css';

const GalleryModal = ({ gallery, onClose }) => {
  const [currentImageIndex, setCurrentImageIndex] = useState(0);

  const handlePrevImage = () => {
    setCurrentImageIndex((prevIndex) =>
      prevIndex === 0 ? gallery.images.length - 1 : prevIndex - 1
    );
  };

  const handleNextImage = () => {
    setCurrentImageIndex((prevIndex) =>
      prevIndex === gallery.images.length - 1 ? 0 : prevIndex + 1
    );
  };

  return (
    <div className={galleryModalStyles.modalOverlay} >
      <div className={galleryModalStyles.modalContainer}>
        <div className={galleryModalStyles.modalHeader}>
          <h2>{gallery.name}</h2>
          <button
            className={galleryModalStyles.closeButton}
            onClick={onClose}
          >
            &times;
          </button>
        </div>
        <div className={galleryModalStyles.imageContainer}>
          <button
            className={galleryModalStyles.prevButton}
            onClick={handlePrevImage}
          >
            &laquo;
          </button>
          <img
            src={gallery.images[currentImageIndex]}
            alt={`Gallery ${gallery.name}`}
            className={galleryModalStyles.image}
          />
          <button
            className={galleryModalStyles.nextButton}
            onClick={handleNextImage}
          >
            &raquo;
          </button>
        </div>
      </div>
    </div>
  );
};

export default GalleryModal;