import React, { useState, useEffect } from 'react';
import testimonialPageStyles from './TestimonialPage.module.css';
import UnderConstruction from '../../underconstrunction';

const TestimonialPage = () => {
  const [testimonials, setTestimonials] = useState([]);

  const dummyTestimonials = [
    {
      id: 1,
      name: 'John Doe',
      avatar: 'https://via.placeholder.com/150',
      message: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
    },
    {
      id: 2,
      name: 'Jane Smith',
      avatar: 'https://via.placeholder.com/150',
      message: 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
    },
    {
      id: 3,
      name: 'Mark Johnson',
      avatar: 'https://via.placeholder.com/150',
      message: 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.'
    },
    {
      id: 4,
      name: 'Emily Davis',
      avatar: 'https://via.placeholder.com/150',
      message: 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
    }
    // Add more dummy testimonials as needed
  ];

  useEffect(() => {
    // Simulating API call to fetch testimonials
    setTimeout(() => {
      setTestimonials(dummyTestimonials);
    }, 1000); // Delay added to simulate asynchronous fetch
  }, []);

  return (
    // <div className={testimonialPageStyles.container}>
    //   {testimonials.map((testimonial) => (
    //     <div key={testimonial.id} className={testimonialPageStyles.card}>
    //       <img src={testimonial.avatar} alt={testimonial.name} className={testimonialPageStyles.avatar} />
    //       <h3 className={testimonialPageStyles.name}>{testimonial.name}</h3>
    //       <p className={testimonialPageStyles.message}>{testimonial.message}</p>
    //     </div>
    //   ))}
    // </div>
    <UnderConstruction/>
  );
};

export default TestimonialPage;
