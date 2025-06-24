import React, { useState, useEffect, useRef } from 'react';
import style from "./VideoPlayer.module.css";
import ReactPlayer from 'react-player';
import screenfull from 'screenfull';
import Container from '@mui/material/Container';
import ControlIcons from './controlIcons';
import { FamilyRestroomOutlined } from '@mui/icons-material';
import { VIMEO_BASE_URL } from '../../config';

function VideoPlayer({durVal, videoUrl, onNextVid, videoTitle }) {
  const [showIcons, setShowIcons] = useState(false);
  const [videoEnded, setVideoEnded] = useState(false);
  const [vidUrl, setVidUrl] = useState(videoUrl);
  const [playerLoaded, setPlayerLoaded] = useState(false);
  const [playerstate, setPlayerState] = useState({
    playing: true,
    mute: false,
    volume: 0.20,
    playerbackRate: 1.0,
    played: 0,
    seeking: false,
  });

  let timeoutId;
  const playerRef = useRef(null);

  useEffect(() => {
    setVidUrl(videoUrl);
    return () => {
      clearTimeout(timeoutId);
    };
  }, [videoUrl]);

  useEffect(() => {
    setPlayerLoaded(true);
  }, []);

  const handleMouseEnter = () => {
    if (!screenfull.isFullscreen) {
      setShowIcons(true);
      clearTimeout(timeoutId);
    }
  };

  const handleMouseLeave = () => {
    if (!screenfull.isFullscreen) {
      timeoutId = setTimeout(() => {
        setShowIcons(false);
      }, 500);
    }
  };

  const handleScreenClick = () => {
    if (screenfull.isFullscreen) {
      setShowIcons(!showIcons);
      clearTimeout(timeoutId);
    }
  };

  const handlePlayAndPause = () => {
    setPlayerState({
      ...playerstate,
      playing: !playerstate.playing
    });
  };

  const handleRewind = () => {
    playerRef.current.seekTo(playerRef.current.getCurrentTime() - 10, 'seconds');
  };

  const handleFastForward = () => {
    playerRef.current.seekTo(playerRef.current.getCurrentTime() + 10, 'seconds');
  };

  const handlePlayerProgress = (state) => {
    if (!playerstate.seeking) {
      setPlayerState({ ...playerstate, ...state });
    }
  };

  const handlePlayerSeek = (e, newValue) => {
    setPlayerState({ ...playerstate, played: parseFloat(newValue / 100) });
    playerRef.current.seekTo(parseFloat(newValue / 100));
  };

  const handlePlayerMouseSeekUp = (e, newValue) => {
    setPlayerState({ ...playerstate, seeking: false });
    playerRef.current.seekTo(newValue / 100);
  };

  const format = (seconds) => {
    if (isNaN(seconds)) {
      return '00:00';
    }

    const date = new Date(seconds * 1000);
    const hh = date.getUTCHours();
    const mm = date.getUTCMinutes();
    const ss = date.getUTCSeconds().toString().padStart(2, "0");

    if (hh) {
      return `${hh}:${mm.toString().padStart(2, "0")}:${ss}`;
    } else {
      return `${mm}:${ss}`;
    }
  };

  const currentTime = playerRef.current ? playerRef.current.getCurrentTime() : '00:00';
  const videoDuration = playerRef.current ? playerRef.current.getDuration() : '00:00';
  const playedTime = format(currentTime);
  const totalTime = format(videoDuration);

  const handleMuting = () => {
    setPlayerState({ ...playerstate, mute: !playerstate.mute });
  };

  const handleVideoEnd = () => {
    setVideoEnded(true);
  };

  const handleNextVideo = () => {
    onNextVid();
  };

  const handleVolumeChange = (e, newValue) => {
    setPlayerState({ ...playerstate, volume: parseFloat(newValue / 100), mute: newValue === 0 ? true : false });
  };

  const handleVolumeSeek = (e, newValue) => {
    setPlayerState({ ...playerstate, volume: parseFloat(newValue / 100), mute: newValue === 0 ? true : false });
  };

  const playerDivRef = useRef(null);

  const handleFullScreenMode = () => {
    screenfull.toggle(playerDivRef.current);
  };

  const { playing, mute, volume, playerbackRate, played, seeking } = playerstate;

  return (
    <Container maxWidth='lg' onClick={handleScreenClick}>
      <div className={`${style.playerDiv} ${playerLoaded ? style.loaded : ''}`} onMouseEnter={handleMouseEnter} onMouseLeave={handleMouseLeave} ref={playerDivRef}>
        <ReactPlayer
          className={style.reactplayer}
          url={`https://vimeo.com/${vidUrl}`}
          width={"100%"}
          height={"100%"}

          ref={playerRef}
          playing={playing}
          muted={mute}
          volume={volume}
          onProgress={handlePlayerProgress}
          onEnded={handleVideoEnd}
          config={{
            file: {
              attributes: {
                controlsList: 'nodownload'
              }
            }
          }}
        />
        <ControlIcons
          showIcons={showIcons}
          playandpause={handlePlayAndPause}
          playing={playing}
          rewind={handleRewind}
          fastforward={handleFastForward}
          currentTime={playedTime}
          videoDuration={totalTime}
          played={played}
          onSeek={handlePlayerSeek}
          onSeekMouseUp={handlePlayerMouseSeekUp}
          muting={handleMuting}
          muted={mute}
          volume={volume}
          volumeChange={handleVolumeChange}
          volumeSeek={handleVolumeSeek}
          fullScreenMode={handleFullScreenMode}
          videoEnded={videoEnded}
          onNext={handleNextVideo}
          videoTitle={videoTitle}
        />
      </div>
    </Container>
  );
}

export default VideoPlayer;
