// src/components/LoginReigister/Register.js
import React, { useState, useContext,useEffect } from 'react';
import { Button, TextField, Grid, Paper, Typography, Link, makeStyles, MenuItem } from '@material-ui/core';
import { useNavigate } from 'react-router-dom';
import { AuthContext } from '../../AuthProvider';
import { API_BASE_URL } from '../../config';

import { Link as RouterLink } from 'react-router-dom'; 

const useStyles = makeStyles((theme) => ({
  paper: {
    marginTop: theme.spacing(8),
    display: 'flex',
    flexDirection: 'column',
    alignItems: 'center',
    padding: theme.spacing(4),
    backgroundColor: theme.palette.common.background,
  },
  form: {
    width: '400px',
    margin: 'auto',
  },
  input: {
    border: '1px solid #ccc',
    padding: theme.spacing(1),
    marginBottom: theme.spacing(2),
  },
  submit: {
    backgroundColor: theme.palette.primary.main,
    color: theme.palette.common.white,
    padding: theme.spacing(1, 2),
    marginTop: theme.spacing(2),
    '&:hover': {
      backgroundColor: 'green', // Change to green on hover
    },
  },
}));

const Register = () => {
  const classes = useStyles();
  const navigate = useNavigate();
  const { login } = useContext(AuthContext);

  const [username, setUsername] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [age, setAge] = useState('');
  const [gender, setGender] = useState('');
  const [organization, setOrganization] = useState('');
  const [errorMessage, setErrorMessage] = useState('');

  useEffect(()=>{ window.scrollTo(0, 0);},[])

  const handleChange = (event) => {
    const { name, value } = event.target;
    if (name === 'username') {
      setUsername(value);
    } else if (name === 'email') {
      setEmail(value);
    } else if (name === 'password') {
      setPassword(value);
    } else if (name === 'confirmPassword') {
      setConfirmPassword(value);
    } else if (name === 'age') {
      setAge(value);
    } else if (name === 'gender') {
      setGender(value);
    } else if (name === 'organization') {
      setOrganization(value);
    }
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    setErrorMessage('');

    if (password !== confirmPassword) {
      setErrorMessage('Passwords do not match');
      return;
    }

    try {
      const response = await fetch(`${API_BASE_URL}/api/user/register/v1`, {
        method: 'POST',
        mode: 'cors',
        body: JSON.stringify({
          username,
          email,
          password,
          age,
          gender,
          organization
        }),
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json',
        },
      });

      if (response.status === 500) {
        throw new Error('Server error');
      }

      const data = await response.json();

      if (response.ok) {
        login(data.token) 
        navigate('/');
      } else {
        setErrorMessage(`Registration failed: ${Object.keys(data.keyValue)} already exists.`);
      }
    } catch (error) {
      setErrorMessage('An error occurred during registration. Please try again.');
      console.error('Error in handleSubmit:', error);
    }
  };

  return (
    <Grid container spacing={0} justify="center" direction="row">
      <Grid item>
        <Paper variant="elevation" elevation={2} className={classes.paper}>
          <Typography component="h1" variant="h5">
            Register
          </Typography>
          <form className={classes.form} onSubmit={handleSubmit} id="registrationForm">
            <TextField
              label="Username"
              type="username"
              className={classes.input}
              fullWidth
              name="username"
              variant="outlined"
              value={username}
              onChange={handleChange}
              required
              autoFocus
            />
            <TextField
              label="Email"
              type="email"
              className={classes.input}
              fullWidth
              name="email"
              variant="outlined"
              value={email}
              onChange={handleChange}
              required
            />
            <TextField
              label="Age"
              type="number"
              className={classes.input}
              fullWidth
              name="age"
              variant="outlined"
              value={age}
              onChange={handleChange}
              required
            />
            <TextField
              label="Gender"
              select
              className={classes.input}
              fullWidth
              name="gender"
              variant="outlined"
              value={gender}
              onChange={handleChange}
              required
            >
              <MenuItem value="male">Male</MenuItem>
              <MenuItem value="female">Female</MenuItem>
              <MenuItem value="other">Other</MenuItem>
            </TextField>
            <TextField
              label="Organization"
              type="text"
              className={classes.input}
              fullWidth
              name="organization"
              variant="outlined"
              value={organization}
              onChange={handleChange}
            />            <TextField
              label="Password"
              type="password"
              className={classes.input}
              fullWidth
              name="password"
              variant="outlined"
              value={password}
              onChange={handleChange}
              required
            />
            <TextField
              label="Confirm Password"
              type="password"
              className={classes.input}
              fullWidth
              name="confirmPassword"
              variant="outlined"
              value={confirmPassword}
              onChange={handleChange}
              required
            />

            {errorMessage && <Typography color="error">{errorMessage}</Typography>}
            <Button variant="contained" className={classes.submit} type="submit">
              Register
            </Button>
          </form>
          <Link component={RouterLink} to="/login" variant="body2">
            Already have an account? Login
          </Link>
        </Paper>
      </Grid>
    </Grid>
  );
};

export default Register;
