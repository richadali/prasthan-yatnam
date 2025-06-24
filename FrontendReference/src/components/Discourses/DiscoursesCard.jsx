import React from 'react';
import styles from './DiscoursesCard.module.css';
import { useNavigate,Link } from 'react-router-dom';
import { API_BASE_URL } from '../../config';

const DiscoursesCard = ({ courseId, title, imageUrl, body }) => {

  const truncateText = (text, maxWords) => {
    const words = text.split(' ');
    if (words.length > maxWords) {
      return words.slice(0, maxWords).join(' ') + '...';
    }
    return text;
  };

  // Truncate body text to fit within the card (approximately 50 words)
  const truncatedBody = truncateText(body, 20);
  const truncatedTitle = truncateText(title, 3);



  return (
    <div className={styles.card}>
      <img src={`${API_BASE_URL}/${imageUrl}`} alt={title} className={styles.cardImage} />
      <div className={styles.cardContent}>
        <h3 className={styles.cardTitle}>{truncatedTitle}</h3>
        <p className={styles.cardBody}>{truncatedBody}</p>
        {title === "Divine Mother" ?  
        <Link to={`/discourses/${courseId}`} className={styles.cardButton}>
        ATTEND DISCOURSE
        </Link>:<Link  className={styles.cardButton}>
          Upcoming
        </Link>}

      </div>
    </div>
  );
};

export default DiscoursesCard;
