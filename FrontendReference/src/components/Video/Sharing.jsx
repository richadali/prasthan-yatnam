import React from 'react';
import { FacebookShareButton, TwitterShareButton, LinkedinShareButton, WhatsappShareButton } from 'react-share';
import IconButton from '@mui/material/IconButton';
import FacebookIcon from '@mui/icons-material/Facebook';
import TwitterIcon from '@mui/icons-material/Twitter';
import LinkedInIcon from '@mui/icons-material/LinkedIn';
import WhatsAppIcon from '@mui/icons-material/WhatsApp';


const SharingButton = ({ url, title }) => {
  return (
    <>
      <FacebookShareButton url={url} quote={title}>
        <IconButton aria-label="Share on Facebook">
          <FacebookIcon style={{ color: "#3b5998" }} />
        </IconButton>
      </FacebookShareButton>
      <TwitterShareButton url={url} title={title}>
        <IconButton aria-label="Share on Twitter">
          <TwitterIcon style={{ color: "#1da1f2" }} />
        </IconButton>
      </TwitterShareButton>
      <LinkedinShareButton url={url} title={title}>
        <IconButton aria-label="Share on LinkedIn">
          <LinkedInIcon style={{ color: "#0077b5" }} />
        </IconButton>
      </LinkedinShareButton>
      <WhatsappShareButton url={url} title={title}>
        <IconButton aria-label="Share on WhatsApp">
          <WhatsAppIcon style={{ color: "#25D366" }} /> 
        </IconButton>
      </WhatsappShareButton>
    </>
  );
};

export default SharingButton;
