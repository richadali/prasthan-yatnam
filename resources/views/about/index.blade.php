@extends('layouts.app')

@section('content')
<div class="about-page">
    <!-- Hero Section -->
    <section class="hero-section py-5"
        style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/images/himalaya.jpg'); background-size: cover; background-position: center; color: white;">
        <div class="container py-5 text-center">
            <h1 class="display-4 mb-3 fw-bold">About Us</h1>
            <p class="lead mb-0">Peace Love and Healing</p>
            <p class="lead mb-0">Sarve Bhavantu Sukhinaha </p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Welcome Section -->
                <div class="text-center mb-5">
                    <div class="d-inline-block p-2 mb-4" style="border-bottom: 3px solid #ff8c00;">
                        <h2 class="h2 mb-0" style="color: #0047AB;">Welcome to Prasthan Yatnam</h2>
                    </div>
                    <p class="lead mb-4">
                        We are joyous to launch Prasthan Yatnam's webportal to the World.
                        We hope and pray that it serves the purpose of unifying the world in this conflict ridden times
                        and most
                        importantly keep the youngsters close to their roots.
                    </p>
                </div>

                <!-- Founder's Background (Added from document) -->
                <div class="card shadow-sm mb-5 border-0" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-header text-white py-3" style="background-color: #0047AB;">
                        <h3 class="mb-0">Our Story</h3>
                    </div>
                    <div class="card-body p-4" style="background-color: #f8f9fa;">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-4">
                                    <h4 class="mb-3" style="color: #0047AB;">Background</h4>
                                    <p style="line-height: 1.8;">
                                        Privileged to be born in a clan wherein I have grown up with vivid
                                        memories of my paternal grandfather Tonkeswar Sharma ringing the ghonta (bell)
                                        in
                                        adoration of Lord Narayan (Saligram) in the Guxai Ghor (room for prayer) and my
                                        maternal grandfather Shankardhar Barooah in meditative contemplation penning
                                        down
                                        "The Vedanta in New Light", coupled with the cosmopolitan ambience flavoured
                                        with
                                        traditional roots provided by my parents Girindranath Sharma and Nilima Sharma I
                                        have embarked on a different journey in life.
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <h4 class="mb-3" style="color: #0047AB;">The Concept of Prasthan Yatnam</h4>
                                    <p style="line-height: 1.8;">
                                        I realized the need for a platform as an aftercare
                                        for a lot of people and also for family/friends/associates and anyone else who
                                        needs it
                                        for developing meaning and purpose in life.
                                    </p>
                                    <p style="line-height: 1.8;">
                                        Being spiritually inclined, I often go for many camps/discourses/workshops on
                                        positive living etc. conducted by all kinds of institutions to pick up the gems
                                        for
                                        myself and my loved ones. Therein I realized that generally every institution
                                        barring a
                                        limited few, try to thrust down their ideologies on the buffet era people!! Thus
                                        the
                                        idea of Prasthan Yatnam was born within me, influenced greatly by the all
                                        embracing
                                        Sanatan Dharma.
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <h4 class="mb-3" style="color: #0047AB;">What is Prasthan Yatnam</h4>
                                    <p style="line-height: 1.8;">
                                        It is a humble endeavor to develop a movement wherein
                                        every Thursday members gather to sit in group meditation with the music of
                                        different
                                        sects. Thereafter a brief input is given about the sect whose music is being
                                        used,
                                        followed by sharing of experiences by the participants. God willing, one day
                                        this
                                        movement will culminate into an Organisation!!
                                    </p>
                                    <p class="mb-0"><strong>Established:</strong> 9th of May, 2013</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Motto Section -->
                <div class="mb-5">
                    <div class="text-center mb-4">
                        <h2 style="color: #0047AB;">The Fourfold Motto</h2>
                        <div class="mx-auto" style="height: 3px; width: 70px; background-color: #ff8c00;"></div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm border-0 hover-card" style="border-radius: 10px;">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-circle me-3"
                                            style="background-color: #0047AB; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <span class="fw-bold">1</span>
                                        </div>
                                        <h4 class="card-title mb-0">Spirituality is Universality</h4>
                                    </div>
                                    <p class="card-text">
                                        Spirituality is not religiosity. It is Universality.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm border-0 hover-card" style="border-radius: 10px;">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-circle me-3"
                                            style="background-color: #ff8c00; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <span class="fw-bold">2</span>
                                        </div>
                                        <h4 class="card-title mb-0">Power of Meditation</h4>
                                    </div>
                                    <p class="card-text">
                                        Meditation is the best tool to untangle, tangled emotions leading to freedom and
                                        peace.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm border-0 hover-card" style="border-radius: 10px;">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-circle me-3"
                                            style="background-color: #0047AB; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <span class="fw-bold">3</span>
                                        </div>
                                        <h4 class="card-title mb-0">Return to Roots</h4>
                                    </div>
                                    <p class="card-text">
                                        Going back to our roots. In today's world the reverse of the renaissance has
                                        become necessary because people have lost their identity and are spiritually
                                        bankrupt. The youth are left with no one to really guide them except 'Google
                                        Search'!! People are looking for peace outside whereas peace in an internal
                                        business
                                        which can be realized through the scriptures which have dynamite messages but
                                        unfortunately people have gone far away from them and also sadly the scriptures
                                        have been misinterpreted.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm border-0 hover-card" style="border-radius: 10px;">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-circle me-3"
                                            style="background-color: #ff8c00; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <span class="fw-bold">4</span>
                                        </div>
                                        <h4 class="card-title mb-0">Live and Let Live</h4>
                                    </div>
                                    <p class="card-text">
                                        For Universal Brotherhood of mankind and for International
                                        Peace, this principle is an important prerequisite. Hence in Prasthan Yatnam, we
                                        learn about everyone's ideology (110 different sects covered till date) and at
                                        home
                                        one can practice whatever he/she prefers.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logo & Name Origin Section -->
                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
                            <div class="card-header text-white py-3" style="background-color: #ff8c00;">
                                <h3 class="mb-0">Logo and Colors</h3>
                            </div>
                            <div class="card-body p-4">
                                <div class="text-center mb-4">
                                    <img src="/images/logo.jpg" alt="Prasthan Yatnam Logo"
                                        style="max-width: 150px; border-radius: 10px;" class="img-fluid">
                                </div>
                                <p style="line-height: 1.8;" class="text-center">
                                    <strong>Snow Clad mountain with the Sun Rising</strong><br>
                                    White for Peace.<br>
                                    Orange for Brilliance.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
                            <div class="card-header text-white py-3" style="background-color: #0047AB;">
                                <h3 class="mb-0">Why the Name</h3>
                            </div>
                            <div class="card-body p-4">
                                <p style="line-height: 1.8;">
                                    Poignantly influenced by the narration of my mother regarding how at
                                    the deathbed of my maternal grandmother, Annapurna Devi, my grandfather bid her
                                    farewell with a 'bel paat' (a auspicious leaf of the Hindus) and said "Ataire yatra
                                    kalot
                                    tumi hodai bel paat di bidai di sila, aji tumar aie moha yatrat tumi ai bel paat loi
                                    Brahmalookoloi "Prasthan" kora'. (during everyone's journey you have always sent
                                    them off with a bel paat. Today on your final journey, take this bel paat and
                                    proceed
                                    (Prasthan) to (Brahmalook). Thus Prasthan Yatnam, Prasthan (proceed) Yatnam
                                    (attempt) An attempt to proceed.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inspiration Section -->
                <div class="card shadow-sm mb-5 border-0"
                    style="border-radius: 15px; overflow: hidden; background-color: #f8f9fa;">
                    <div class="card-header text-white py-3" style="background-color: #ff8c00;">
                        <h3 class="mb-0">Our Inspiration</h3>
                    </div>
                    <div class="card-body p-4">
                        <p style="line-height: 1.8;">
                            Deeply inspired by the Gyan Yagnas of Revered Swami Chinmayanandaji
                            and the powerful silent meditation of Rishi Aurobindo and The Divine Mother, Secular
                            idea of "Sab ka Malik hai Ek" of Shirdi Sai Baba, thoughts of Buddha/Swami
                            Vivekananda and many other spiritual Giants and also the 12 step principle of
                            "Together we can, alone I cannot".
                        </p>
                    </div>
                </div>

                <!-- Membership Section -->
                <div class="card shadow-sm mb-5 border-0" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-header text-white py-3" style="background-color: #0047AB;">
                        <h3 class="mb-0">Membership</h3>
                    </div>
                    <div class="card-body p-4">
                        <p style="line-height: 1.8;" class="text-center mb-0">
                            <strong>Caste/Creed/sect/religion/sex/age/species no bar.</strong><br>
                            Open to like-minded people who want to evolve.
                        </p>
                    </div>
                </div>





                <!-- Philosophy Section -->
                <div class="mb-5">
                    <div class="text-center mb-4">
                        <h2 style="color: #0047AB;">Our Philosophy</h2>
                        <div class="mx-auto" style="height: 3px; width: 70px; background-color: #ff8c00;"></div>
                    </div>
                    <p class="lead text-center mb-5">
                        Our philosophy is rooted in the ancient wisdom of the East while embracing universal spiritual
                        principles that transcend cultural boundaries.
                    </p>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm border-0 hover-card"
                                style="border-radius: 10px; transition: transform 0.3s ease;">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-circle me-3"
                                            style="background-color: #0047AB; color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-infinity"></i>
                                        </div>
                                        <h4 class="card-title mb-0">Spirituality as Universality</h4>
                                    </div>
                                    <p class="card-text">
                                        We believe in the power of ancient wisdom to guide us through modern challenges.
                                        Our
                                        courses combine traditional knowledge with contemporary understanding, creating
                                        a bridge
                                        between the past and present.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm border-0 hover-card"
                                style="border-radius: 10px; transition: transform 0.3s ease;">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-circle me-3"
                                            style="background-color: #ff8c00; color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-heart"></i>
                                        </div>
                                        <h4 class="card-title mb-0">Holistic Growth</h4>
                                    </div>
                                    <p class="card-text">
                                        Our approach focuses on the complete development of an individual -
                                        intellectual,
                                        emotional, and spiritual. We provide an environment where one can explore these
                                        dimensions without prejudice or dogma.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Core Values Section (Added from document) -->
                <div class="mb-5">
                    <div class="text-center mb-4">
                        <h2 style="color: #0047AB;">Our Core Values</h2>
                        <div class="mx-auto" style="height: 3px; width: 70px; background-color: #ff8c00;"></div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm border-0 hover-card" style="border-radius: 10px;">
                                <div class="card-body p-4">
                                    <div class="text-center mb-3">
                                        <div class="icon-circle mx-auto mb-3"
                                            style="background-color: #0047AB; color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-balance-scale fa-2x"></i>
                                        </div>
                                        <h4 class="card-title">Respect for All Traditions</h4>
                                    </div>
                                    <p class="card-text text-center">
                                        We honor all spiritual paths and traditions, recognizing that there are many
                                        valid approaches to personal growth and enlightenment.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm border-0 hover-card" style="border-radius: 10px;">
                                <div class="card-body p-4">
                                    <div class="text-center mb-3">
                                        <div class="icon-circle mx-auto mb-3"
                                            style="background-color: #ff8c00; color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-lightbulb fa-2x"></i>
                                        </div>
                                        <h4 class="card-title">Authentic Knowledge</h4>
                                    </div>
                                    <p class="card-text text-center">
                                        We are committed to providing accurate, authentic knowledge based on traditional
                                        texts and teachings, presented in an accessible manner.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm border-0 hover-card" style="border-radius: 10px;">
                                <div class="card-body p-4">
                                    <div class="text-center mb-3">
                                        <div class="icon-circle mx-auto mb-3"
                                            style="background-color: #0047AB; color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-handshake fa-2x"></i>
                                        </div>
                                        <h4 class="card-title">Inclusivity</h4>
                                    </div>
                                    <p class="card-text text-center">
                                        Our courses and community are open to people of all backgrounds, beliefs, and
                                        levels of knowledge, fostering an inclusive environment.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vision Section (Added from document) -->
                <div class="card shadow-sm mb-5 border-0"
                    style="border-radius: 15px; overflow: hidden; background-color: #f8f9fa;">
                    <div class="card-header text-white py-3" style="background-color: #0047AB;">
                        <h3 class="mb-0">Our Vision and Mission </h3>
                    </div>
                    <div class="card-body p-4">
                        <p style="line-height: 1.8;">
                            In today's world of fast lanes with ever-increasing traffic, pollution has heightened
                            to its peak...thus Prasthan Yatnam makes an attempt to be an oxygen mask to save one
                            from the compromised air around. It is a kind of a Rainbow Bridge or a Bridge Course
                            or a balanced platform especially for youngsters to have a breath of fresh air amidst the
                            hurry bury of life. Not all are destined nor inclined to climb the lofty spiritual heights
                            of the Himalayas, yet in their hearts, they have a longing for solace…
                        </p>
                        <p style="line-height: 1.8;">
                            In the midst of modern-day living, play and interaction, suddenly something happens
                            within and life seems to take on a more meaningful shade and rays of tranquility seem
                            to sip into our existence...
                            Prasthan Yatnam makes a humble attempt to provide just that…
                        </p>
                        <p style="line-height: 1.8;">
                            Universality makes us open-minded to embrace humanity...We are no profound giants
                            but mere commoners who find a balanced meaning and purpose in life no matter what
                            our age, past and backgrounds are…
                        </p>
                        <p style="line-height: 1.8;">
                            Prasthan Yatnam provides that joyous bonhomie ...We are waiting to embrace you if
                            you choose to knock our door..We turn noone away...
                        </p>
                        <p style="line-height: 1.8; font-style: italic;">
                            Peace, love and healing.<br>
                            Sarve Bhavantu Sukhinaha.
                        </p>
                        <p style="line-height: 1.8; font-weight: bold;" class="text-end">
                            Raina Bhattacharjee<br>
                            <span style="font-weight: normal;">(Founder and Director)</span>
                        </p>
                    </div>
                </div>

                <!-- Focus Areas (Added from document) -->
                <div class="mb-5">
                    <div class="text-center mb-4">
                        <h2 style="color: #0047AB;">Our Focus Areas</h2>
                        <div class="mx-auto" style="height: 3px; width: 70px; background-color: #ff8c00;"></div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-0 hover-card" style="border-radius: 10px;">
                                <div class="card-body p-4">
                                    <div class="text-center mb-3">
                                        <div class="icon-circle mx-auto mb-3"
                                            style="background-color: #0047AB; color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-book fa-2x"></i>
                                        </div>
                                        <h4 class="card-title">Ancient Wisdom</h4>
                                    </div>
                                    <p class="card-text text-center">
                                        Exploring and interpreting ancient Indian texts to extract their timeless wisdom
                                        and practical applications.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-0 hover-card" style="border-radius: 10px;">
                                <div class="card-body p-4">
                                    <div class="text-center mb-3">
                                        <div class="icon-circle mx-auto mb-3"
                                            style="background-color: #ff8c00; color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-users fa-2x"></i>
                                        </div>
                                        <h4 class="card-title">Community Building</h4>
                                    </div>
                                    <p class="card-text text-center">
                                        Creating a global network of individuals committed to spiritual growth and
                                        cultural understanding.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-0 hover-card" style="border-radius: 10px;">
                                <div class="card-body p-4">
                                    <div class="text-center mb-3">
                                        <div class="icon-circle mx-auto mb-3"
                                            style="background-color: #0047AB; color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-hands fa-2x"></i>
                                        </div>
                                        <h4 class="card-title">Practical Application</h4>
                                    </div>
                                    <p class="card-text text-center">
                                        Translating spiritual concepts into practical tools for everyday life challenges
                                        and personal growth.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Courses Section -->
                <div class="mb-5 py-5" style="background-color: #f8f9fa; border-radius: 15px; padding: 40px;">
                    <div class="text-center mb-4">
                        <h2 style="color: #0047AB;">Our Courses</h2>
                        <div class="mx-auto" style="height: 3px; width: 70px; background-color: #ff8c00;"></div>
                    </div>
                    <p class="lead text-center mb-4">
                        Prasthan Yatnam offers a variety of courses designed to help individuals connect with their
                        spiritual
                        roots while navigating the complexities of modern life.
                    </p>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <h5 class="card-title" style="color: #0047AB;"><i class="fas fa-music me-2"
                                            style="color: #ff8c00;"></i> Bhaja Govindam</h5>
                                    <p class="card-text">Exploring the timeless teachings of Adi Shankaracharya</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <h5 class="card-title" style="color: #0047AB;"><i class="fas fa-venus me-2"
                                            style="color: #ff8c00;"></i> Divine Mother</h5>
                                    <p class="card-text">Understanding the concept of feminine divine energy</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <h5 class="card-title" style="color: #0047AB;"><i class="fas fa-book me-2"
                                            style="color: #ff8c00;"></i> Chandi Path</h5>
                                    <p class="card-text">Deep dive into the sacred text with practical applications</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <h5 class="card-title" style="color: #0047AB;"><i class="fas fa-hands-helping me-2"
                                            style="color: #ff8c00;"></i> Sai Baba Teachings</h5>
                                    <p class="card-text">Exploring the universal message of love and service</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Benefits of Our Courses (Added from document) -->
                <div class="card shadow-sm mb-5 border-0" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-header text-white py-3" style="background-color: #0047AB;">
                        <h3 class="mb-0">Benefits of Our Courses</h3>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div
                                            style="background-color: #ff8c00; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-brain"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 style="color: #0047AB;">Deeper Understanding</h5>
                                        <p>Gain insights into ancient wisdom and how it applies to contemporary
                                            challenges.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div
                                            style="background-color: #ff8c00; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-peace"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 style="color: #0047AB;">Inner Peace</h5>
                                        <p>Develop practices that promote mental clarity, emotional balance, and
                                            spiritual harmony.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div
                                            style="background-color: #ff8c00; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 style="color: #0047AB;">Community Connection</h5>
                                        <p>Join a global network of like-minded individuals on a similar spiritual path.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div
                                            style="background-color: #ff8c00; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-tools"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 style="color: #0047AB;">Practical Tools</h5>
                                        <p>Learn techniques and practices that you can incorporate into your daily life.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Educational Approach (Added from document) -->
                <div class="card shadow-sm mb-5 border-0" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-header text-white py-3" style="background-color: #ff8c00;">
                        <h3 class="mb-0">Our Educational Approach</h3>
                    </div>
                    <div class="card-body p-4">
                        <p style="line-height: 1.8;">
                            Prasthan Yatnam's educational methodology combines traditional teaching with modern
                            pedagogical techniques.
                            Our courses are designed to be accessible to people from all backgrounds, regardless of
                            their prior
                            knowledge of Indian philosophy or spirituality.
                        </p>
                        <p style="line-height: 1.8;">
                            We believe in learning through engagement and reflection. Our courses include not just
                            lectures but also
                            discussions, practical exercises, and opportunities for personal exploration. We encourage
                            questions and
                            critical thinking, as we believe that true understanding comes from active engagement with
                            the material.
                        </p>
                    </div>
                </div>

                <!-- Team and Leadership Section (Added from document) -->
                <div class="mb-5">
                    <div class="text-center mb-4">
                        <h2 style="color: #0047AB;">Our Team</h2>
                        <div class="mx-auto" style="height: 3px; width: 70px; background-color: #ff8c00;"></div>
                    </div>
                    <p class="lead text-center mb-4">
                        Prasthan Yatnam is led by a dedicated team of scholars, practitioners, and educators with
                        extensive knowledge of Indian philosophy and spirituality.
                    </p>

                    <div class="card shadow-sm border-0 mb-4"
                        style="border-radius: 15px; overflow: hidden; background-color: #f8f9fa;">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-4 text-center mb-3 mb-md-0">
                                    <div class="mx-auto mb-3"
                                        style="background-color: #0047AB; color: white; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-user fa-3x"></i>
                                    </div>
                                    <h4 style="color: #0047AB;">Guiding Experts</h4>
                                </div>
                                <div class="col-md-8">
                                    <p style="line-height: 1.8;">
                                        Our team consists of individuals who have dedicated their lives to studying and
                                        practicing the teachings of ancient Indian wisdom. They bring a wealth of
                                        knowledge and experience to our courses, ensuring that the content is both
                                        authentic and relevant.
                                    </p>
                                    <p style="line-height: 1.8;">
                                        Many of our team members have studied under traditional gurus and have also
                                        received formal education in various disciplines, allowing them to bridge the
                                        gap between ancient wisdom and modern understanding.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0"
                        style="border-radius: 15px; overflow: hidden; background-color: #f8f9fa;">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-4 text-center mb-3 mb-md-0">
                                    <div class="mx-auto mb-3"
                                        style="background-color: #ff8c00; color: white; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-hands-helping fa-3x"></i>
                                    </div>
                                    <h4 style="color: #0047AB;">Community Support</h4>
                                </div>
                                <div class="col-md-8">
                                    <p style="line-height: 1.8;">
                                        Behind our core team is a supportive community of volunteers and contributors
                                        who help us in various capacities, from content creation to technical support.
                                        This collaborative approach allows us to draw on diverse perspectives and
                                        talents.
                                    </p>
                                    <p style="line-height: 1.8;">
                                        We believe in the principle of seva (selfless service), and many members of our
                                        community contribute their time and skills to help fulfill Prasthan Yatnam's
                                        mission of spreading spiritual knowledge and fostering unity.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="card border-0 shadow-sm mb-5"
                    style="background: linear-gradient(135deg, #0047AB, #00008B); border-radius: 15px; overflow: hidden;">
                    <div class="card-body text-white p-5 text-center">
                        <h3 class="card-title mb-3">Join Our Journey</h3>
                        <p class="card-text mb-4">
                            We invite you to be part of this spiritual journey with us. Register for our courses,
                            participate in discussions, and help us create a community dedicated to growth,
                            understanding,
                            and harmony.
                        </p>
                        <p class="card-text mb-4">
                            Let us walk together on this path of self-discovery and universal harmony.
                        </p>
                        <a href="/discourses" class="btn btn-lg"
                            style="background-color: #ff8c00; color: white;">Explore Our Courses</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card:hover {
        transform: translateY(-5px);
    }

    .icon-circle {
        transition: all 0.3s ease;
    }

    .hover-card:hover .icon-circle {
        transform: scale(1.1);
    }

    @media (max-width: 768px) {
        .hero-section {
            padding-top: 3rem !important;
            padding-bottom: 3rem !important;
        }
    }
</style>
@endsection