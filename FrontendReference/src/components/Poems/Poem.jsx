import React, { useState } from 'react';
import poemData from './poemData';
import poemStyles from './poem.module.css';
import UnderConstruction from '../../underconstrunction';



const Poem = () => {
  const [selectedPoemIndex, setSelectedPoemIndex] = useState(null);

  const handlePoemClick = (index) => {
    setSelectedPoemIndex(index);
  };

  const handleBackClick = () => {
    setSelectedPoemIndex(null);
  };


  return (
    // <div className={poemStyles.container}>
    //   {selectedPoemIndex === null ? (
    //     <>
    //       <h1 className={poemStyles.heading}></h1>
    //       <div className={poemStyles.poemList}>
    //         {poemData.map((poem, index) => (
    //           <div
    //             key={index}
    //             className={poemStyles.poem}
    //             onClick={() => handlePoemClick(index)}
    //           >
    //             <h2 className={poemStyles.poemTitle}>{poem.title}</h2>
    //             <p className={poemStyles.author}>- author</p>
    //           </div>
    //         ))}
    //       </div>
    //     </>
    //   ) : (
    //     <>
    //     <button className={poemStyles.backButton} onClick={handleBackClick}>
    //         Back
    //       </button>
    //     <div className={poemStyles.poemDetail}>

    //       <h1 className={poemStyles.poemTitle}>
    //         {poemData[selectedPoemIndex].title}
    //       </h1>
    //       <div className={poemStyles.poemContent}>
    //           {poemData[selectedPoemIndex].content.split('\n').map((line, index) => (
    //             <p key={index} className={poemStyles.poemLine}>{line}</p>
    //           ))}
    //       </div>
    //     </div>
    //     </>

    //   )}
    // </div>
    <UnderConstruction/>
  );
};

export default Poem;