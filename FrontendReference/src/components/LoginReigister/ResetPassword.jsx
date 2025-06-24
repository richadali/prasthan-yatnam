import React, { useState } from 'react';
import { TextField, Button, Grid, Paper, Typography, makeStyles } from '@material-ui/core';
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

const ResetPassword = () => {
  const [token, setToken] = useState('');
  const [password, setPassword] = useState('');
  const [message, setMessage] = useState('');
  const classes = useStyles();

  const handleTokenChange = (event) => {
    setToken(event.target.value);
  };

  const handlePasswordChange = (event) => {
    setPassword(event.target.value);
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    try {
      const response = await axios.post(`${API_BASE_URL}/api/user/reset-password`, { token, password });
      setMessage(response.data.msg);
    } catch (error) {
      setMessage(error.response.data.err || 'Something went wrong');
    }
  };

  return (
    <div className={classes.root}>
      <Paper className={classes.paper}>
        <Typography variant="h6" gutterBottom>
          Reset Password
        </Typography>
        <form className={classes.form} onSubmit={handleSubmit}>
          <Grid container spacing={2}>
            <Grid item xs={12}>
              <TextField
                className={classes.textField}
                label="OTP"
                type="text"
                value={token}
                onChange={handleTokenChange}
                fullWidth
                required
                variant="outlined"
              />
            </Grid>
            <Grid item xs={12}>
              <TextField
                className={classes.textField}
                label="New Password"
                type="password"
                value={password}
                onChange={handlePasswordChange}
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
                Done
              </Button>
            </Grid>
          </Grid>
        </form>
        {message && <Typography color="textSecondary">{message}</Typography>}
      </Paper>
    </div>
  );
};

export default ResetPassword;
