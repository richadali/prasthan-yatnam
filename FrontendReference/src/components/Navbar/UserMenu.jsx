import * as React from 'react';
import Menu from '@mui/material/Menu';
import MenuItem from '@mui/material/MenuItem';
import { NavLink, useNavigate } from "react-router-dom";
import { AuthContext } from '../../AuthProvider';

export default function UserMenu() {
  const [anchorEl, setAnchorEl] = React.useState(null);
  const open = Boolean(anchorEl);
  const { logout } = React.useContext(AuthContext);
  const navigate = useNavigate();

  const handleClick = (event) => {
    setAnchorEl(event.currentTarget);
  };
  
  const handleClose = () => {
    setAnchorEl(null);
  };

  const handleLogout = () => {
    logout();
    handleClose();
    navigate('/');
  };

  return (
    <div>
      <div 
        onClick={handleClick} 
        style={{ cursor: 'pointer' }} // Make cursor pointer
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          strokeWidth="2"
          strokeLinecap="round"
          strokeLinejoin="round"
          color="white"
          style={{ transition: 'transform 0.2s ease-in-out' }} // Add transition for hover effect
          onMouseEnter={(e) => e.target.setAttribute('transform', 'scale(1.2)')} // Scale up on hover
          onMouseLeave={(e) => e.target.setAttribute('transform', 'scale(1)')} // Scale back to normal on leave
        >
          <path d="M12 2c-3.31 0-6 2.69-6 6a6 6 0 0 0 12 0c0-3.31-2.69-6-6-6zM12 14c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
        </svg>
      </div>
      <Menu
        id="basic-menu"
        anchorEl={anchorEl}
        open={open}
        onClose={handleClose}
        MenuListProps={{
          'aria-labelledby': 'basic-button',
        }}
      >
        <MenuItem onClick={handleClose}>
          <NavLink 
            style={{ cursor: 'pointer', color: 'black', textDecoration: 'none' }} 
            to={"/userProfile"}
          >
            Profile
          </NavLink>
        </MenuItem>
        <MenuItem onClick={handleClose}>
          <NavLink 
            style={{ cursor: 'pointer', color: 'black', textDecoration: 'none' }} 
            to={"/mycourses"}
          >
            My Courses
          </NavLink>
        </MenuItem>
        <MenuItem onClick={handleLogout}>
          <span style={{ cursor: 'pointer', color: 'black', textDecoration: 'none' }}>Logout</span>
        </MenuItem>
      </Menu>
    </div>
  );
}
