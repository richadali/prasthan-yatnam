import React, { useState } from 'react';
import GalleryItem from './GalleryItem'; 
import GalleryModal from './GalleryModal'; 
import styles from './Gallery.module.css'; 
import UnderConstruction from '../../underconstrunction';

const Gallery = () => {
  const [selectedGallery, setSelectedGallery] = useState(null); // State to track the selected gallery

  // Dummy data for galleries
  const galleries = [
    {
      id: 1,
      name: 'Nature Landscapes',
      images: [
        'https://images.unsplash.com/photo-1470252649378-9c29740c9fa8?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80',
        'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80',
        'https://images.unsplash.com/photo-1503265192875-fb2d94968735?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80',
      ],
    },
    {
      id: 2,
      name: 'City Skylines',
      images: [
        'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1774&q=80',
        'https://images.unsplash.com/photo-1486299267070-83823f5448dd?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1771&q=80',
        'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80',
      ],
    },
    {
      id: 3,
      name: 'Wildlife',
      images: [
        'https://images.unsplash.com/photo-1564349683136-77e08dba1ef7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1772&q=80',
        'https://images.unsplash.com/photo-1503023345310-bd7c1de61c7d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1765&q=80',
        'https://images.unsplash.com/photo-1608198093002-b2b324232b1b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80',
      ],
    },
  ];
  // Function to handle gallery item click
  const handleGalleryItemClick = (gallery) => {
    setSelectedGallery(gallery);
  };

  // Function to handle modal close
  const handleCloseModal = () => {
    console.log("clicked")
    setSelectedGallery(null);
  };

  return (
    // <div className={styles.galleryPage}>
    //   <h1></h1>
    //   <div className={styles.gallery}>
    //     {galleries.map((gallery) => (
    //       <GalleryItem key={gallery.id} gallery={gallery} onClick={() => handleGalleryItemClick(gallery)} />
    //     ))}
    //   </div>
    //   {selectedGallery && (
    //     <GalleryModal gallery={selectedGallery} onClose={handleCloseModal} />
    //   )}
    // </div>
    <UnderConstruction/>
  );
};

export default Gallery;
