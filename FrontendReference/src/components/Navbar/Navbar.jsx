// Import necessary libraries and styles
import React from "react";
import navcss from "./Navbar.module.css"
import navLogo from "../../assets/logo.png";
import navLogo2 from "../../assets/PRASTHAN YATNAM-OK.jpg";
import { NavLink } from "react-router-dom";
import { Link } from "react-router-dom";
import UserMenu from "./UserMenu";

const Navbar = ({ isLoggedIn }) => {
  return (
    <nav className={navcss.navbar}>
      <div className={navcss.navbar_logo}>
 
        <Link to="/">
          <img src={navLogo2} alt="" />
        </Link>
      </div>
      <div className={navcss.navbar_links}>
        <NavLink to={"/"} className={({ isActive }) => isActive ? `${navcss.active}` : ''}>HOME</NavLink>
        <NavLink to={"/discourses"} className={({ isActive }) => isActive ? `${navcss.active}` : ''}>DISCOURSES</NavLink>
        <NavLink to={"/poems"} className={({ isActive }) => isActive ? `${navcss.active}` : ''}>POEMS</NavLink>
        <NavLink to={"/activity"} className={({ isActive }) => isActive ? `${navcss.active}` : ''}>ACTIVITY</NavLink>
        <NavLink to={"/testimonials"} className={({ isActive }) => isActive ? `${navcss.active}` : ''}>TESTIMONIAL</NavLink>
        {/* <NavLink to={"/donations"} className={({ isActive }) => isActive ? `${navcss.active}` : ''}>DONATION</NavLink> */}
        <NavLink to={"/about"} className={({ isActive }) => isActive ? `${navcss.active}` : ''}>ABOUT</NavLink>
        
        {isLoggedIn ? (
          <UserMenu/>
        ) : (
          <NavLink to={"/login"} className={({ isActive }) => isActive ? `${navcss.active}` : ''}>LOGIN</NavLink>
        )}
      </div>
    </nav>
  );
};

export default Navbar;

