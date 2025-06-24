import React, { useEffect, useState } from 'react';
import DiscourseCard from './DiscourseCard';
import axios from 'axios';
import styles from "./MyCourses.module.css"
import { API_BASE_URL } from '../../config';

const MyCourses = () => {
  const [courses, setCourses] = useState([]);

  useEffect(() => {
    const fetchCourses = async () => {
      const token = localStorage.getItem('prasthan_yatna_jwt');
      if (!token) {
        console.error('No token found');
        return;
      }

      try {
        const response = await axios.get(`${API_BASE_URL}/api/course/userCourse`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        setCourses(response.data);
      } catch (error) {
        console.error('Error fetching courses:', error);
      }
    };

    fetchCourses();
  }, []);

  return (
    <div className={styles.container}>
      <div className={styles.title}>
        <h1>MY DISCOURSES</h1>
      </div>
      <div className={styles.discourse}>
        {courses.map(course => (
          <DiscourseCard 
            key={course._id} 
            img={`${API_BASE_URL}/${courseDetails.ImgPath}`}
            id={course._id} 
            title={course.Name} 
            description={course.Brief_Desc}
          />
        ))}
      </div>
    </div>
  );
};

export default MyCourses;
