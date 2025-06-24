import React, { useState } from 'react';
import { TextField, Button, Grid, Paper, Typography, makeStyles } from '@material-ui/core';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import { API_BASE_URL } from '../../config';

const useStyles = makeStyles((theme) => ({
  root: {
    flexGrow: 1,
    padding: theme.spacing(10),
    marginLeft: 'auto',
    marginRight: 'auto',
    maxWidth: 600,
    minHeight: "100vh",
  },
  paper: {
    padding: theme.spacing(3),
  },
  form: {
    width: '100%',
    marginTop: theme.spacing(2),
  },
  textField: {
    marginBottom: theme.spacing(2),
  },
  submitButton: {
    backgroundColor: theme.palette.primary.main,
    color: theme.palette.common.white,
    padding: theme.spacing(1, 2),
    marginTop: theme.spacing(2),
    '&:hover': {
      backgroundColor: 'green',
    },
  },
}));

const ForgotPassword = () => {
  const [email, setEmail] = useState('');
  const [message, setMessage] = useState('');
  const classes = useStyles();
  const navigate = useNavigate();

  const handleEmailChange = (event) => {
    setEmail(event.target.value);
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    try {
      const response = await axios.post(`${API_BASE_URL}/api/user/forgot-password`, { email });
      setMessage(response.data.msg);
      if (response.status === 201) {
        navigate('/reset-password'); 
      }
    } catch (error) {
      if (error.response) {

        if (error.response.status === 400) {
          setMessage('User email does not exist.');
        } else if (error.response.status === 500) {
          setMessage('Please try again later.');
        } else {
          setMessage('Something went wrong. Please try again.');
        }
      } else if (error.request) {
        // The request was made but no response was received
        setMessage('No response from server. Please check your connection.');
      } else {
        // Something happened in setting up the request that triggered an Error
        setMessage('Error: ' + error.message);
      }
    }
  };

  return (
    <div className={classes.root}>
      <Paper className={classes.paper}>
        <Typography variant="h6" gutterBottom>
          Forgot Password
        </Typography>
        <form className={classes.form} onSubmit={handleSubmit}>
          <Grid container spacing={2}>
            <Grid item xs={12}>
              <TextField
                className={classes.textField}
                label="Email"
                type="email"
                value={email}
                onChange={handleEmailChange}
                fullWidth
                required
                variant="outlined"
              />
            </Grid>
            <Grid item xs={12}>
              <Button
                className={classes.submitButton}
                variant="contained"
                color="primary"
                type="submit"
              >
                Send OTP
              </Button>
            </Grid>
          </Grid>
        </form>
        {message && <Typography color="textSecondary">{message}</Typography>}
      </Paper>
    </div>
  );
};

export default ForgotPassword;
