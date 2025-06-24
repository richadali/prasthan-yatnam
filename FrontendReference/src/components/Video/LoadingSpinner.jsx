import React from "react";
import spinnerCss from "./LoadingSpinner.module.css";

const LoadingSpinner = () => (
  <div className={spinnerCss.spinner}>
    <div className={spinnerCss.doubleBounce1}></div>
    <div className={spinnerCss.doubleBounce2}></div>
  </div>
);

export default LoadingSpinner;
