import React, { createContext, useState, useEffect } from 'react';
import { API_BASE_URL } from './config';

export const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
  const [isLoggedIn, setIsLoggedIn] = useState(false);

  useEffect(() => {
    const token = localStorage.getItem('prasthan_yatna_jwt');
    if (token) {
      setIsLoggedIn(true);
    }
  }, []);

  const login = (token) => {
    localStorage.setItem('prasthan_yatna_jwt', token);
    setIsLoggedIn(true);
  };

  const logout = () => {
    localStorage.removeItem('prasthan_yatna_jwt');
    setIsLoggedIn(false);
  };

  const resetPassword = async (newPassword) => {
    try {
      const token = localStorage.getItem('prasthan_yatna_jwt');
      const response = await axios.post(
        `${API_BASE_URL}/api/reset-password`,
        {
          newPassword
        },
        {
          headers: {
            Authorization: `Bearer ${token}`
          }
        }
      );
      if (response.status === 200) {
        console.log('Password reset successful');
      } else {
        console.error('Password reset failed');
      }
    } catch (error) {
      console.error('Error resetting password:', error);
    }
  };

  return (
    <AuthContext.Provider value={{ isLoggedIn, login, logout, resetPassword }}>
      {children}
    </AuthContext.Provider>
  );
};
