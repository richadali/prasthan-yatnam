@extends('layouts.app')

@section('content')
<div class="about-page">
    <!-- Hero Section -->
    <section class="hero-section py-5"
        style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/images/himalaya.jpg'); background-size: cover; background-position: center; color: white;">
        <div class="container py-5 text-center">
            <h1 class="display-4 mb-3 fw-bold">About Us</h1>
            <p class="lead mb-0">Peace, love and healing..Sarve Bhavantu Sukhinaha..</p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Welcome Section -->
                <div class="text-center mb-5">
                    <div class="d-inline-block p-2 mb-4" style="border-bottom: 3px solid #ff8c00;">
                        <h2 class="h2 mb-0" style="color: #0047AB;">PRASTHAN YATNAM</h2>
                    </div>
                    <p class="lead mb-4">
                        Peace, love and healing. Sarve Bhavantu Sukhinaha.
                    </p>
                </div>

                <!-- Founder's Background (Added from document) -->
                <div class="card shadow-sm mb-5 border-0" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-header text-white py-3" style="background-color: #0047AB;">
                        <h3 class="mb-0">Background</h3>
                    </div>
                    <div class="card-body p-4" style="background-color: #f8f9fa;">
                        <p style="line-height: 1.8;">
                            Privileged to be born in a clan wherein I have grown up with vivid
                            memories of my paternal grandfather Tonkeswar Sharma ringing the ghonta (bell)
                            in adoration of Lord Narayan (Saligram) in the Guxai Ghor (room for prayer) and my
                            maternal grandfather Shankardhar Barooah in meditative contemplation penning
                            down "The Vedanta in New Light", coupled with the cosmopolitan ambience flavoured
                            with traditional roots provided by my parents Girindranath Sharma and Nilima Sharma I
                            have embarked on a different journey in life.
                        </p>
                    </div>
                </div>

                <!-- The Concept Section -->
                <div class="card shadow-sm mb-5 border-0" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-header text-white py-3" style="background-color: #ff8c00;">
                        <h3 class="mb-0">The Concept of Prasthan Yatnam</h3>
                    </div>
                    <div class="card-body p-4">
                        <p style="line-height: 1.8;">
                            I realized the need for a platform as an aftercare
                            for a lot of people and also for family/friends/associates and anyone else who
                            needs it for developing meaning and purpose in life.
                        </p>
                        <p style="line-height: 1.8;">
                            Being spiritually inclined, I often go for many camps/discourses/workshops on
                            positive living etc. conducted by all kinds of institutions to pick up the gems
                            for myself and my loved ones. Therein I realized that generally every institution
                            barring a limited few, try to thrust down their ideologies on the buffet era people!! Thus
                            the idea of Prasthan Yatnam was born within me, influenced greatly by the all
                            embracing Sanatan Dharma.
                        </p>
                    </div>
                </div>

                <!-- What is Prasthan Yatnam Section -->
                <div class="card shadow-sm mb-5 border-0" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-header text-white py-3" style="background-color: #0047AB;">
                        <h3 class="mb-0">What is Prasthan Yatnam</h3>
                    </div>
                    <div class="card-body p-4">
                        <p style="line-height: 1.8;">
                            It is a humble endeavor to develop a movement wherein
                            every Thursday members gather to sit in group meditation with the music of
                            different sects. Thereafter a brief input is given about the sect whose music is being
                            used, followed by sharing of experiences by the participants. God willing, one day
                            this movement will culminate into an Organisation!!
                        </p>
                        <p class="mb-0"><strong>Established:</strong> 9th of May, 2013</p>
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
                                        business which can be realized through the scriptures which have dynamite
                                        messages but
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
                                        home one can practice whatever he/she prefers.
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
                                    kalot tumi hodai bel paat di bidai di sila, aji tumar aie moha yatrat tumi ai bel
                                    paat loi
                                    Brahmalookoloi "Prasthan" kora'. (during everyone's journey you have always sent
                                    them off with a bel paat. Today on your final journey, take this bel paat and
                                    proceed (Prasthan) to (Brahmalook). Thus Prasthan Yatnam, Prasthan (proceed) Yatnam
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
                        <h3 class="mb-0">Inspiration</h3>
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

                <!-- Vision and Mission Section -->
                <div class="card shadow-sm mb-5 border-0"
                    style="border-radius: 15px; overflow: hidden; background-color: #f8f9fa;">
                    <div class="card-header text-white py-3" style="background-color: #0047AB;">
                        <h3 class="mb-0">Vision and Mission of Prasthan Yatnam</h3>
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
                        <p style="line-height: 1.8; font-style: italic;" class="text-end">
                            Peace, love and healing.<br>
                            Sarve Bhavantu Sukhinaha.
                        </p>
                        <p style="line-height: 1.8; font-weight: bold;" class="text-end">
                            Raina Bhattacharjee<br>
                            <span style="font-weight: normal;">(Founder and Director)</span>
                        </p>
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
                            understanding, and harmony.
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