// GalleryItem.js

import React from 'react';
import styles from './GalleryItem.module.css'; // Import module.css styles

const GalleryItem = ({ gallery, onClick }) => {
    const backgroundImageStyle = {
        backgroundImage: `url(${gallery.images[0]})`,
        backgroundSize: 'cover', // Example: Set background size to cover
        backgroundPosition: 'center', // Example: Center the background image
        backgroundRepeat: 'no-repeat', // Ensure background image does not repeat
        // Add more background properties as needed
      };
  return (
    <div className={styles.galleryItem} style={backgroundImageStyle} onClick={onClick}>
      <h2>{gallery.name}</h2>
      <p>{gallery.images.length} images</p>
    </div>
  );
};

export default GalleryItem;
