import React, { useState, useEffect } from "react";
import playercss from "./Player.module.css";
import PlayerCourse from "./PlayerCourse";
import VideoPlayer from "./VideoPlayer";
import axios from 'axios'; // Assuming you're using axios for API calls
import { css } from '@emotion/react';
import { ClipLoader } from 'react-spinners';
import { useNavigate, useParams } from "react-router-dom";
import { API_BASE_URL } from "../../config";

const override = css`
  display: block;
  margin: 0 auto;
  border-color: red;
`;

const Player = () => {
  const [videos, setVideos] = useState([]);
  const [currentVideoIndex, setCurrentVideoIndex] = useState(0);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const { id } = useParams();

  useEffect(() => {
    const fetchCourseVideos = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/api/course/${id}`, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('prasthan_yatna_jwt')}`
          }
        });
        setVideos(response.data.Content);
        setCurrentVideoIndex(0);
        setLoading(false);
      } catch (error) {
        console.error("Error fetching course videos:", error);
        setError("Failed to load videos. Please try again later.");
        setLoading(false);
      }
    };

    fetchCourseVideos();
  }, [id]);

  useEffect(() => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  }, [currentVideoIndex]);

  const handleNextVideo = () => {
    if (currentVideoIndex < videos.length - 1) {
      setCurrentVideoIndex(currentVideoIndex + 1);
    }
  };

  const handleVideoClick = (index) => {
    if (index < videos.length) {
      setCurrentVideoIndex(index);
    }
  };

  if (loading) {
    return (
      <div className={playercss.loader}>
        <ClipLoader color="#4fa94d" loading={loading} css={override} size={100} />
      </div>
    );
  }

  if (error) {
    return (
      <div className={playercss.loader}>
        <p>{error}</p>
      </div>
    );
  }

  return (
    <div className={playercss.player}>
      {videos.length > 0 ? (
        <>
          <VideoPlayer 
            key={videos[currentVideoIndex]?.id} 
            durVal={videos[currentVideoIndex]?.duration} 
            videoUrl={videos[currentVideoIndex]?.videoUrl} 
            onNextVid={handleNextVideo} 
            videoTitle={videos[currentVideoIndex].title}
          />
          <div>
            <h2 className={playercss.player_course_heading} style={{ marginBottom: "1rem" }}>
              {}
            </h2>
            <div>
              {videos.map((video, index) => (
                <PlayerCourse
                  key={video.id}
                  videoTitle={video.title}
                  videoDuration={video.duration}
                  setVideo={() => handleVideoClick(index)}
                  videoLink={video.videoUrl}
                />
              ))}
            </div>
          </div>
        </>
      ) : (
        <div className={playercss.loader}>
          <p>No videos available for this course.</p>
        </div>
      )}
    </div>
  );
};

export default Player;
