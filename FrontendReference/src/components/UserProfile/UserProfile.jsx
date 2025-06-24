import React, { useEffect, useState, useContext } from 'react';
import { AuthContext } from '../../AuthProvider';
import userStyle from './UserProfile.module.css';
import { useNavigate } from 'react-router-dom';

const UserProfile = () => {
  const { logout } = useContext(AuthContext);
  const navigate = useNavigate();
  const [user, setUser] = useState(null);

  useEffect(() => {
    const token = localStorage.getItem('prasthan_yatna_jwt');
    if (token) {
      try {
        const decodedToken = parseJwt(token);
        setUser({
          name: decodedToken.name,
          email: decodedToken.email,
          profilePicture: decodedToken.profilePicture || 'https://via.placeholder.com/150',
          coursesPurchased: decodedToken.coursesPurchased || 0,
        });
      } catch (error) {
        console.error('Error decoding token:', error);
      }
    }
  }, []);

  const handleLogout = () => {
    logout();
    navigate('/');
  };

  const handlePasswordChange = () => {
    navigate('/forgot-password');
  };

  if (!user) {
    return <p>Loading...</p>;
  }

  return (
    <div className={userStyle.cardContainer}>
      <div className={userStyle.card}>
        <div className={userStyle.profilePicture}>
          <img src={user.profilePicture} alt="Profile" />
        </div>
        <div className={userStyle.profileInfo}>
          <h2 className={userStyle.username}>{user.name}</h2>
          <p className={userStyle.email}>{user.email}</p>
          <p className={userStyle.courses}>Courses Purchased: {user.coursesPurchased}</p>
          <div className={userStyle.actions}>
            <button className={userStyle.passwordChange} onClick={handlePasswordChange}>
              Change Password
            </button>
            <button className={userStyle.logout} onClick={handleLogout}>
              Logout
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

function parseJwt(token) {
  try {
    const base64Url = token.split('.')[1];
    const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    const jsonPayload = decodeURIComponent(
      atob(base64)
        .split('')
        .map((c) => '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2))
        .join('')
    );

    return JSON.parse(jsonPayload);
  } catch (error) {
    console.error('Error parsing JWT:', error);
    return null;
  }
}

export default UserProfile;
