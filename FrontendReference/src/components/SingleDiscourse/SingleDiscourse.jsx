import React, { useEffect, useState } from "react";
import { Button } from "@mui/material";
import { useNavigate, useParams } from "react-router-dom";
import axios from "axios";
import { ClipLoader } from "react-spinners";
import singleCourseCSS from "./SingleDiscourse.module.css";
import { API_BASE_URL } from "../../config";
import SharingButton from "../Video/Sharing";

const override = `
  display: block;
  margin: 0 auto;
  border-color: red;
`;

const SingleDiscourse = () => {
  const { id } = useParams();
  const [courseDetails, setCourseDetails] = useState(null);
  const [hasBoughtCourse, setHasBoughtCourse] = useState(false);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const navigate = useNavigate();

  useEffect(() => {
    const tokenKey = 'prasthan_yatna_jwt';
    const token = localStorage.getItem(tokenKey);

    const fetchCourseData = async () => {
      try {
        const courseResponse = await axios.get(
          `${API_BASE_URL}/api/course/${id}`,
          {
            headers: {
              'Authorization': 'Bearer ' + token
            }
          }
        );

        const purchaseResponse = await axios.get(
          `${API_BASE_URL}/api/checkCoursePurchase/${id}`,
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        setCourseDetails(courseResponse.data);
        setHasBoughtCourse(!purchaseResponse.data.hasBought);
        setLoading(false); 
      } catch (error) {
        console.error("Error fetching course data:", error);
        setError("Failed to load course data. Please try again later.");
        setLoading(false); 
      }
    };

    fetchCourseData();
  }, [id]);

  if (loading) {
    return (
      <div className={singleCourseCSS.loaderContainer}>
        <ClipLoader color="#4fa94d" loading={loading} css={override} size={100} />
      </div>
    );
  }

  if (error) {
    return (
      <div className={singleCourseCSS.errorContainer}>
        <p>{error}</p>
      </div>
    );
  }

  return (
    courseDetails ? (
      <div className={singleCourseCSS.singleDiscourse}>
        <div className={singleCourseCSS.header}>
          <img
            src={`${API_BASE_URL}/${courseDetails.ImgPath}`}
            alt={courseDetails.Name}
            className={singleCourseCSS.headerImage}
          />
          <div className={singleCourseCSS.headerContent}>
            <h1>{courseDetails.Name}</h1>
            <div className={singleCourseCSS.details}>
              <div className={singleCourseCSS.detailItem}>
                <span className={singleCourseCSS.label}>Facilitator: </span>
                {courseDetails.Author}
              </div>
              <div className={singleCourseCSS.detailItem}>
                <span className={singleCourseCSS.label}>Duration: </span>
                <h5>Divine Mother PART 1, 23:15 minutes</h5>
                <h5>Divine-Mother-PART2, 26:59 minutes</h5>
              </div>
              {!hasBoughtCourse && (
                <div className={singleCourseCSS.detailItem}>
                  <span className={singleCourseCSS.label}>Offering: </span>
                  ₹{courseDetails.Price}
                </div>
              )}
            </div>

          </div>
          <Button
              variant="contained"
              className={singleCourseCSS.button}
              style={{"width":"280px","paddingLeft":"0px","paddingRight":"0px"}}
              onClick={() => {
                // if (hasBoughtCourse) {
                  navigate(`/discourses/${id}/videos`);
                // } else {
                //   navigate(`/buy-course/${id}`);
                // }
              }}
            >
              {hasBoughtCourse ? "Begin Your Journey" : "Receive Wisdom"}
            </Button>
          
        </div>
        <div className={singleCourseCSS.content}>
          <h3>BACKGROUND</h3>
          <div className={singleCourseCSS.description}>
            <p>{courseDetails.Brief_Desc}</p>
          </div>
          <div className={singleCourseCSS.videoList}>
            <h3>DISCOURSE PARTS</h3>
            <ul>
              {courseDetails.Content.map((video, index) => (
                <li key={video.id} className={singleCourseCSS.videoItem}>
                  <div className={singleCourseCSS.videoTitle}>
                    {index + 1}. {video.title}
                  </div>
                  <div className={singleCourseCSS.videoMeta}>
                  
                    <div>{courseDetails.Author}</div>
                  </div>
                </li>
              ))}
            </ul>
          </div>
          {!hasBoughtCourse && (
            <div className={singleCourseCSS.buttonContainer}>
              <Button
                variant="contained"
                className={singleCourseCSS.button}
                onClick={() => {
                  navigate(`/buy-course/${id}`);
                }}
              >
                Offer ₹{courseDetails.Price} for Enlightenment
              </Button>
            </div>
          )}
        </div>
        <div className={singleCourseCSS.sharingButtonsContainer} style={{"right":"0px"}}>
          <SharingButton url={window.location.href} title={courseDetails.Name} />
        </div>
      </div>
    ) : (
      <div className={singleCourseCSS.errorContainer}>
        <h3>A moment of reflection is needed...</h3>
        <p>Please refresh the page or seek guidance from our support if the issue persists.</p>
      </div>
    )
  );}

export default SingleDiscourse;
