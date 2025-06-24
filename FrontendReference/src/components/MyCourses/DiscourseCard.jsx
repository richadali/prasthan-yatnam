import React from "react";
import { Button } from "@mui/material";
import styles from "./DiscourseCard.module.css";
import PropTypes from "prop-types";
import { Link, useNavigate } from "react-router-dom";

const DiscourseCard = ({key,
    img,
    id,
    title,
    description
}) => {
  const navigate = useNavigate();

  return (
    <div className={styles.discourse_card_container}>
      <div className={styles.discourse_card}>
        <img src={img} alt="course image" className={styles.image} />
        <div className={styles.content}>
          <Link to={`/discourses/${id}`} className={styles.link}>
            <h1 className={styles.title}>{title}</h1>
          </Link>
          <p className={styles.description}>
            {description}
          </p>
          <Button
            variant="contained"
            color="success"
            onClick={() => {
              navigate(`/discourses/${id}`);
            }}
            className={styles.button}
          >
            View
          </Button>
        </div>
      </div>
    </div>
  );
};

DiscourseCard.propTypes = {
  img: PropTypes.string.isRequired,
  id: PropTypes.number.isRequired,
};

export default DiscourseCard;
