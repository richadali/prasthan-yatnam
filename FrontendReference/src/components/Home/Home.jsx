import { Button } from "@mui/material";
import { useState,useEffect } from "react";
import "./Home.css";
import homeImage from "../../assets/Divine-mother-22.08.2023-OK.jpg";
import disourse1 from "../../assets/hinduism.jpg"
import discourse2 from "../../assets/saiBaba.jpg"
import homeCarouselImage from "../../assets/BHAJAGOVINDAM-OK.png";
import Carousel from "react-material-ui-carousel";
import { useNavigate,Link } from "react-router-dom";
import { API_BASE_URL } from "../../config";
const Home = ({isLoggedIn}) => {
  
  const [trendCourses, setTrendCourses] = useState([]);
  
  const navigate = useNavigate();

  const handleNavigation = () => {
    if (isLoggedIn) {
      navigate('/discourses/672364123bc640264e9a7bd8');
    } else {
      navigate('/login');
    }
  };

  const defaultImageUrl = 'src/assets/IMG-5.png';
  window.scrollTo(0, 0);


  useEffect( () => {
	
    fetch(`${API_BASE_URL}/api/trend_course`, {
     method:'GET',
      headers: {
       Accept: `application/json`,
      },
    }).then(response=> response.json())
    .then(data => {
 
     console.log(data)
      setTrendCourses(data)
      console.log(data[0].ImgPath);
    }).catch((error)=> {
     
      console.log('Error in getting trend courses',error);
    });
 
  },[])



  return (
    <div className="home">
      <div className="home_image">
      <h1 className="quote">" The need not to journey,to sit still, 
      is the greatest journey."<h2 className="quote_author">~Raina Bhattacharjee</h2></h1>
      
       {!isLoggedIn && (
        <div className="home_image_buttons">
        <Button variant="contained" sx={{ width: "13rem", transition:"0.3s",backgroundColor: "#000080",'&:hover': {
            backgroundColor: "darkblue"} }} className="button login-button" onClick={()=>{navigate("/login")}}>
          LOGIN
        </Button>
        <Button variant="contained" sx={{  width: "13rem", transition:"0.3s",backgroundColor: "#000080",'&:hover': {
            backgroundColor: "darkblue" 
          } }} className="button member-button"  color="success" onClick={()=>{navigate("/register")}}>
          Register
        </Button>
        </div>        
       )}

       {/* {isLoggedIn && (
        <div className="home_image_buttons">
          <Button variant="contained" sx={{  width: "14rem","fontWeight":"800", transition:"0.3s",backgroundColor: "#000080",'&:hover': {
              backgroundColor: "darkblue" 
            } }} className="button member-button"  color="success" >
            Welcome
          </Button>
        </div>
       )} */}


        
      </div>
      <div className="home_grid_background">
      <section class="upcoming-courses-section">
        <h2 class="section-header-static static-header">Click on the image to attend the discourse</h2>
    </section>
      <div className="home_grid">
        <div className="home_grid_carousel">
          <Carousel interval={3000} className="home_carousel">
            <img src={homeImage} onClick={handleNavigation} alt="" width={"100%"}  height={"300px"}/>
            {/* <img src={homeCarouselImage} alt="" width={"100%"} /> */}
          </Carousel>

        </div>

        <div className="home_grid_text">
          <h2>Discourse On:</h2>
          <p>‘Divine Mother: Getting rid of misconceptions regarding Maa Kali and the facts and the spiritual interpretation’</p>
        </div>



        {/* <div>
          <h2>
            Upcoming Discourse: <br />
            Divine Mother
          </h2>
          <Button variant="contained" sx={{ width: "40%", transition:"0.3s",backgroundColor: "#000080",'&:hover': {
            backgroundColor: "darkblue" } }} className="home_button" >
            Register Now
          </Button>
          <Button
            variant="contained"
            color="success"
            fullWidth
            sx={{ width: "40%", transition:"0.3s",'&:hover': {
            backgroundColor: "darkgreen" } }}
            className="home_button" 
          >
            Attend Class
          </Button>
        </div> */}
      </div>
      <section class="upcoming-courses-section">
        <h2 class="section-header blinking-header">Upcoming Discourses</h2>
    </section>

      {/* <div className="home_grid_2">
      {
          trendCourses
              .filter(trendCourse => trendCourse.Name !== "Himalaya")
              .map(trendCourse => (
                <Link key={trendCourse.courseId} to={`/discourses/${trendCourse.courseId}`} state={{ course: trendCourse }}>
                  <img 
                    src={`${API_BASE_URL}/${trendCourse.ImgPath}` || defaultImageUrl} 
                    alt={trendCourse.title || "Course Image"} 
                    className="home_carousel_image" 
                    onError={(e) => { e.target.src = defaultImageUrl; }} 
                  />
                </Link>
              ))
		
	      }
      </div> */}

      <div className="home_grid_2">
  <Link to="/discourses/672364123bc640264e9a7bd8" state={{ courseId: "672364123bc640264e9a7bd8" }}>
    <img 
       src={disourse1}
      alt="Discourse" 
      className="home_carousel_image"
    />
  </Link>

  <Link to="/discourses/anotherCourseId" state={{ courseId: "anotherCourseId" }}>
    <img 
       src={discourse2} 
      alt="Discourse" 
      className="home_carousel_image"
    />
  </Link>
</div>
      
      </div>
      
      <div className="home_para">
        
        <h2>FOUNDER CUM DIRECTOR&apos;S MESSAGE</h2>
        <p>
        Peace, love and healing..Sarve Bhavantu Sukhinaha..</p>
        <p style={{marginTop:"0px"}}>
        We are joyous to launch Prasthan Yatnam's webportal to the World.
        We hope and pray that it serves the purpose of unifying the world in this conflict ridden times and most importantly keep the youngsters close to their roots.
        Our endeavour is to 'Live and Let Live', to embrace One and all, to pick up the gems from all quarters, to remain forever open minded.
        We at Prasthan Yatnam, understand spirituality to be Universility. Thus we are making a humble attempt to provide a soothing healthy atmosphere, free from any kind of dogma/prejudice/fanatism/cultism for a balanced holistic overall growth of a being.
        </p>
        <div style={{ display: 'flex', justifyContent: 'center', marginTop: '20px' }}>
        <Button variant="contained" sx={{ width: "13rem", transition:"0.3s",backgroundColor:"navy",marginTop:"50px",marginLeft:"20px" ,          '&:hover': {
            backgroundColor: "darkblue" 
          }}} className="home_button" onClick={()=>{navigate("/about")}}>
          KNOW MORE ABOUT US
        </Button>
      </div>        
      </div>
    </div>
  );
};

export default Home;
