// GreetingModal.js
import React from 'react';
import './GreetingModal.css'; // Import the CSS file for styles

const GreetingModal = ({ isOpen, onClose }) => {
    if (!isOpen) return null; // Don't render if not open

    return (
        <div className="modal">
            <div className="modal-content">
                <h2>Prasthan Yatnam welcomes you…</h2>
                <p>
                    We are honoured to have you with us in this journey. Prasthan Yatnam (PY) is committed to bringing <br/> hidden jewels of spiritual wisdom for the upliftment of mankind. Kindly log in to view our discourses.<br/> On this occasion of Deepawali (the festival of lights) and to mark the pre-launch of our online web-<br/>portal, we are making our discourse on ‘Divine Mother’ freely available for the visitors.
                    </p>
                    <p>
                        Log in and attend the discourse
                    </p>
                <button id="close-modal" onClick={onClose}>Close</button>
            </div>
        </div>
    );
};

export default GreetingModal;
