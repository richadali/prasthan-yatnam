import { useContext, useEffect, useState } from "react";
import { AuthContext } from "./AuthProvider";
import styles from "./App.module.css";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Home from "./components/Home/Home";
import Navbar from "./components/Navbar/Navbar";
import Discourse from "./components/Discourses/Discourse";
import Player from "./components/Video/Player";
import SingleDiscourse from "./components/SingleDiscourse/SingleDiscourse";
import Login from "./components/LoginReigister/Login";
import Register from "./components/LoginReigister/Register";
import MyCourses from "./components/MyCourses/MyCourses";
import UserProfile from "./components/UserProfile/UserProfile";
import About from "./components/About/about";
import Poem from "./components/Poems/Poem";
import Gallery from "./components/Activity/Gallery";
import TestimonialPage from "./components/Testimonials/TestimonialPage";
import PrivateRoute from "./PrivateRoute";
import ProtectedCourseRoute from "./ProtectedCourseRoutes";
import ResetPassword from "./components/LoginReigister/ResetPassword";
import ForgotPassword from "./components/LoginReigister/ForgotPassword";
import GreetingModal from "./GreetingModal";

function App() {
  const { isLoggedIn } = useContext(AuthContext);
  const [isModalOpen, setModalOpen] = useState(false);
  const [hasModalBeenShown, setHasModalBeenShown] = useState(false); // Track if modal has been shown

  // Show the modal when the component mounts and hasn't been shown yet
  useEffect(() => {
    if (!hasModalBeenShown) {
      setModalOpen(true);
      setHasModalBeenShown(true); // Set to true to prevent reopening
    }
  }, [hasModalBeenShown]);

  // Function to close the modal
  const closeModal = () => {
    setModalOpen(false);
  };

  return (
    <>
      <Router>
        <Navbar isLoggedIn={isLoggedIn} />
        <Routes>
          <Route path="/" element={<Home isLoggedIn={isLoggedIn}/>} />
          <Route path="/donation" element={<Home isLoggedIn={isLoggedIn}/>} />
          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<Register />} />
          <Route path="/discourses" element={<Discourse />} />
          <Route path="/poems" element={<Poem />} />
          <Route path="/activity" element={<Gallery />} />
          <Route path="/testimonials" element={<TestimonialPage />} />
          <Route path="/discourses/:id/videos" element={<ProtectedCourseRoute element={Player} />} />
          <Route path="/discourses/:id" element={<SingleDiscourse />} />
          <Route path="/mycourses" element={<PrivateRoute element={MyCourses} />} />
          <Route path="/userProfile" element={<PrivateRoute element={UserProfile} />} />
          <Route path="/reset-password" element={<ResetPassword />} />
          <Route path="/forgot-password" element={<ForgotPassword />} />
          <Route path="/about" element={<About />} />
          <Route path="/buy-course/:id" element={<About />} />
          <Route path="*" element={<Home />} />
        </Routes>
        <footer className={styles.footer}>
          <p>Copyright &copy; 2024 PrasthanYatnam.org. All rights reserved.</p>
        </footer>
      </Router>

      <GreetingModal isOpen={isModalOpen} onClose={closeModal} />
    </>
  );
}

export default App;
