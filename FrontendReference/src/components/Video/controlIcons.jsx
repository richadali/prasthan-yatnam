import React from 'react';
import style from './controlIcons.module.css';
import Grid from '@mui/material/Grid';
import Typography from '@mui/material/Typography';
import { IconButton } from '@mui/material';
import Forward10Icon from '@mui/icons-material/Forward10';
import Replay10Icon from '@mui/icons-material/Replay10';
import { PlayArrowSharp } from '@mui/icons-material';
import Button from '@mui/material/Button';
import Slider from '@mui/material/Slider';
import { styled } from '@mui/material/styles';
import { VolumeUp } from '@mui/icons-material';
import { Fullscreen } from '@mui/icons-material';
import { PauseSharp } from '@mui/icons-material';
import { VolumeOff, Settings } from '@mui/icons-material';
import SkipNextOutlinedIcon from '@mui/icons-material/SkipNextOutlined';

const PrettoSlider = styled(Slider)({
    height: 5,
    "& .MuiSlider-track": {
      border: "none",
    },
    "& .MuiSlider-thumb": {
      height: 16,
      width: 16,
      backgroundColor: "#fff",
      border: "2px solid currentColor",
      "&:focus, &:hover, &.Mui-active, &.Mui-focusVisible": {
        boxShadow: "inherit",
      },
      "&:before": {
        display: "none",
      },
    },
    "& .MuiSlider-valueLabel": {
      lineHeight: 1.2,
      fontSize: 12,
      background: "unset",
      padding: 0,
      width: 32,
      height: 32,
      borderRadius: "50% 50% 50% 0",
      backgroundColor: "#52af77",
      transformOrigin: "bottom left",
      transform: "translate(50%, -100%) rotate(-45deg) scale(0)",
      "&:before": { display: "none" },
      "&.MuiSlider-valueLabelOpen": {
        transform: "translate(50%, -100%) rotate(-45deg) scale(1)",
      },
      "& > *": {
        transform: "rotate(45deg)",
      },
    },
  });

const ControlIcons = ({ showIcons , playandpause , playing, rewind, fastforward,
     currentTime, videoDuration, played, onSeek, onSeekMouseUp, muting, muted,
     volume, volumeChange, volumeSeek, fullScreenMode, videoEnded, onNext, videoTitle
    }) => {

  return (
    <div className={`${style.controls__div} ${showIcons ? style.visible : ''}`} onDoubleClick={fullScreenMode}>
      <Grid container direction='row' alignItems='center' justifyContent='start' style={{ padding: 16 }}>
        <Grid item>
          <Typography variant='h5' style={{ color: 'white' }}>{videoTitle}</Typography>
        </Grid>
      </Grid>
      <Grid container direction='row' alignItems='center' justifyContent='center'>
      {videoEnded ? (
        <div className={style.iconSquare} onClick={onNext}>
          <IconButton className={style.controls__icons}  aria-label='rewind'>
            <span className={style.nextButton}>Next</span>
          </IconButton>
        </div>
      ) : (
        <>
          <div className={style.iconBubble} onClick={rewind}>
          <IconButton className={style.controls__icons}  aria-label='rewind'>
            <Replay10Icon fontSize='large' style={{ color: 'white' }} />
          </IconButton>
        </div>
        <div className={style.iconBubble} onClick={playandpause}>
          <IconButton className={style.controls__icons} aria-label='play'>
          {playing ? (
              <PauseSharp fontSize="large" style={{ color: "white" }} />
          ) : (
              <PlayArrowSharp fontSize="large" style={{ color: "white" }} />
          )}
          </IconButton>
        </div>
        <div className={style.iconBubble} onClick={fastforward}>
          <IconButton className={style.controls__icons} aria-label='forward'>
          <Forward10Icon fontSize="large" style={{ color: 'white' }}  />
          </IconButton>
        </div>
      </>
      )}
     
    </Grid>
    <Grid
        container
        direction="row"
        alignItems="center"
        justifyContent="space-between"
        style={{ padding: 16 }}
      >
        <Grid item>
     
        </Grid>

        <Grid item xs={12}>
          <Grid container direction="row" justifyContent="space-between">
            <Typography variant="h7" style={{ color: "white" }}>
              {currentTime}
            </Typography>
            <Typography variant="h7" style={{ color: "white" }}>
              {videoDuration}
            </Typography>
          </Grid>
          <PrettoSlider min={0} max={100}  value={played * 100} 
            onChange={onSeek} 
            onChangeCommitted={onSeekMouseUp}
            />
        </Grid>

        <Grid item>
          <Grid container alignItems="center" direction="row" >
            <IconButton className={style.controls__icons} aria-label="reqind" onClick={playandpause}>
            {playing ? (
                <PauseSharp fontSize="large" style={{ color: "white" }} />
            ) : (
                <PlayArrowSharp fontSize="large" style={{ color: "white" }} />
            )}
            </IconButton>

            <IconButton className='controls__icons' aria-label='reqind' onClick={muting}>
            {
                muted ? (
                    <VolumeOff fontSize='medium' style={{color:'white'}}/>
                    ) : (
                    <VolumeUp fontSize='medium' style={{color:'white'}}/>
                )
            }
            </IconButton>

            <Typography style={{ color: "#fff", paddingTop: "5px" }}>
            {parseInt(volume * 100)}
            </Typography>
            <Slider
              min={0}
              max={100}
              value={volume * 100}
              className={style.volume__slider}
              onChange={volumeChange}
              onChangeCommitted={volumeSeek}
            />
          </Grid>
        </Grid>

        <Grid item>
          <IconButton className={style.bottom__icons}>
            <Settings fontSize="large" style={{ color: "white" }} /> 
          </IconButton>
    

          <IconButton className={style.bottom__icons} onClick={fullScreenMode}>
            <Fullscreen fontSize="large" style={{ color: "white" }}  />
          </IconButton>
        </Grid>
      </Grid>
    
    </div>
  );
};

export default ControlIcons;
