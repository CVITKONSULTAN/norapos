@extends('compro.grandkartika.layouts')

@section('main')
    <div role="main" class="main">

        <div class="slider-container bg-transparent rev_slider_wrapper" style="height: 530px;">
            <div id="revolutionSlider" class="slider rev_slider manual" data-version="5.4.8">
                <ul>
                    <li data-transition="boxfade">

                        <img src="/hotel/img/slide1.webp"  
                            alt=""
                            data-bgposition="center bottom"
                            data-bgfit="cover"
                            data-bgrepeat="no-repeat"
                            data-bgparallax="10"
                            class="rev-slidebg"
                            data-no-retina>
                    </li>
                    <li data-transition="boxfade">

                        <img src="/hotel/img/slide2.webp"  
                            alt=""
                            data-bgposition="center bottom"
                            data-bgfit="cover"
                            data-bgrepeat="no-repeat"
                            data-bgparallax="10"
                            class="rev-slidebg"
                            data-no-retina>
                    </li>
                </ul>
            </div>
        </div>

        <section class="section section-no-background section-no-border m-0">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">

                        <h3 class="mt-4 mb-0 pb-0">In the Heart of Porto</h3>
                        <div class="divider divider-primary divider-small my-3">
                            <hr class="mt-2 me-auto">
                        </div>

                        <p class="lead font-weight-regular">Lorem ipsum dolor sit amet, <span class="highlight highlight-primary highlight-bg-opacity highlight-animated px-0" data-appear-animation="highlight-animated-start" data-appear-animation-delay="200" data-plugin-options="{'flagClassOnly': true}">nisi elit consequat ipsum</span> dolor sit amet. Lorem ipsum dolor sit amet.</p>

                        <p class="mt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultrices malesuada ante quis pharetra. Nullam non bibendum dolor. Ut vel turpis accumsan, efficitur dolor fermentum.</p>

                        <a class="font-weight-bold text-2 text-decoration-none mt-2 mb-4" href="#">Learn More <i class="fas fa-angle-right p-relative top-1 ms-1"></i></a>
                    </div>
                    <div class="col-lg-6">

                        <div class="micro-map box-shadow-custom my-4 clearfix">
                            <div class="micro-map-map">
                                <div id="googleMapsMicro" class="google-map m-0" style="height: 260px;"></div>
                            </div>
                            <div class="micro-map-info">
                                <div class="micro-map-info-detail">
                                    <label class="opacity-7 d-block text-2">ADDRESS</label>
                                    <p class="text-dark text-3 font-weight-bold line-height-5 mb-4"><?php echo $address; ?><br> <a class="font-weight-bold text-color-primary text-color-hover-secondary text-uppercase mt-2 text-1" href="<?php echo $direction_link; ?>"><u>Get Directions</u></a></p>

                                    <label class="opacity-7 d-block text-2">PHONE</label>
                                    <p class="text-dark text-4 font-weight-bold line-height-5 mb-1"><?php echo $phone; ?></p>
                                    <!-- <p class="text-dark text-3 font-weight-bold line-height-5 mb-0">(800) 123-4568</p>
                                    <p class="text-dark text-3 font-weight-bold line-height-5 mb-0">(800) 123-4569</p> -->
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>

        <section class="section section-parallax section-height-3 overlay overlay-show overlay-op-5 border-0 m-0 appear-animation" data-appear-animation="fadeIn" data-plugin-parallax data-plugin-options="{'speed': 1.1, 'parallaxHeight': '200%'}" 
        data-image-src="/hotel/img/feature_image1.webp">
            <div class="container">
                <div class="row">
                    <div class="col text-center">

                        <h3 class="mt-4 mb-0 pb-0 text-color-light">Enjoy The Best Of Experiences</h3>
                        <div class="divider divider-primary divider-small my-3">
                            <hr class="mt-2 m-auto">
                        </div>

                        <p class="lead font-weight-regular text-color-light opacity-7">Make your reservation right now with the best price!</p>

                        <a href="#" class="btn btn-primary font-weight-bold text-uppercase px-5 py-3 mt-2 mb-2 appear-animation" data-appear-animation="fadeInUpShorterPlus" data-appear-animation-delay="350">Book Now</a>

                    </div>
                </div>
            </div>
        </section>

        <section class="section section-no-background section-no-border m-0">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-lg-4">

                        <div class="owl-carousel owl-carousel-mini-dots owl-theme dots-inside box-shadow-custom mt-4" data-plugin-options="{'items': 1, 'margin': 10, 'animateOut': 'fadeOut', 'autoplay': true, 'autoplayTimeout': 3000}">
                            <div>
                                <img alt="" class="img-fluid" src="/hotel/img/feature_image1.webp">
                            </div>
                            <div>
                                <img alt="" class="img-fluid" src="/hotel/img/featured_image2.jpeg">
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-8">

                        <h3 class="mt-4 pt-1 mb-0 pb-0">Hotel Overview</h3>
                        <div class="divider divider-primary divider-small my-3">
                            <hr class="mt-2 me-auto">
                        </div>

                        <p class="mt-4 mb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultrices malesuada ante quis pharetra. Nullam non bibendum dolor. Ut vel turpis accumsan, efficitur dolor fermentum, tincidunt metus ut vel turpis accumsan, efficitur dolor fermentum, tincidunt metus. Etiam ut.</p>

                        <div class="row mt-4 pt-2">
                            <div class="col-lg-4">
                                <ul class="list list-icons list-primary text-uppercase font-weight-bold text-color-dark text-2">
                                    <li><i class="fas fa-check"></i> 24 Rooms, 4 Luxury suites</li>
                                    <li><i class="fas fa-check"></i> Fitness center</li>
                                    <li><i class="fas fa-check"></i> Airport transporation</li>
                                </ul>
                            </div>
                            <div class="col-lg-4">
                                <ul class="list list-icons list-primary text-uppercase font-weight-bold text-color-dark text-2">
                                    <li><i class="fas fa-check"></i> 24-Hour In-Room Dining</li>
                                    <li><i class="fas fa-check"></i> Cocktail Bar</li>
                                    <li><i class="fas fa-check"></i> Dog Friendly - Pets Stay Free</li>
                                </ul>
                            </div>
                            <div class="col-lg-4">
                                <ul class="list list-icons list-primary text-uppercase font-weight-bold text-color-dark text-2">
                                    <li><i class="fas fa-check"></i> Valet car service</li>
                                    <li><i class="fas fa-check"></i> Pool</li>
                                    <li><i class="fas fa-check"></i> Free Wi-Fi</li>
                                </ul>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>

        <section class="section section-parallax bg-color-primary border-0 m-0" data-plugin-parallax data-plugin-options="{'speed': 1.1, 'parallaxHeight': '200%'}" data-image-src="img/demos/hotel/backgrounds/background-3-boxed.png">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h3 class="mt-4 mb-0 pb-0 text-light">Guest Reviews</h3>
                        <div class="divider divider-light divider-small divider-small-center my-3">
                            <hr class="mt-2">
                        </div>
                    </div>
                </div>
                <div class="row pt-2 px-3">
                    <div class="col px-5 mb-4 pb-2">

                        <div class="owl-carousel owl-theme nav-style-1 nav-arrows-thin nav-outside nav-light nav-font-size-lg bg-light box-shadow-4 py-5 py-lg-0 mb-0" data-plugin-options="{'responsive': {'0': {'items': 1, 'dots': true}, '768': {'items': 1}, '992': {'items': 1, 'nav': true, 'dots': false}, '1200': {'items': 1, 'nav': true, 'dots': false}}, 'loop': true, 'autoHeight': true}">
                            <div class="py-3 py-lg-5 px-lg-5">
                                <div class="custom-testimonial-style-1 testimonial testimonial-style-2 testimonial-with-quotes testimonial-remove-right-quote px-0 px-md-4 mx-xl-3 my-3">
                                    <img width="56" height="56" src="/hotel/img/demos/hotel/icons/tripadvisor.svg" alt="Tripadvisor Icon" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-dark', 'fadeIn': false}" />
                                    <blockquote class="pt-3 pb-2 px-0 px-md-3">
                                        <p class="text-color-dark text-3-5 line-height-8 alternative-font-4 mb-0">Cras a elit sit amet leo accumsan volutpat. Suspendisse hendreriast ehicula leo, vel efficitur felis ultrices non. Cras a elit sit amet leo acun volutpat. </p>
                                    </blockquote>
                                    <p class="text-color-grey opacity-6">TRIP ADVISOR - NOV 2020</p>
                                    <div class="testimonial-author">
                                        <strong class="font-weight-bold text-4 negative-ls-1">John Doe</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="py-3 py-lg-5 px-lg-5">
                                <div class="custom-testimonial-style-1 testimonial testimonial-style-2 testimonial-with-quotes testimonial-remove-right-quote px-0 px-md-4 mx-xl-3 my-3">
                                    <img width="56" height="56" src="/hotel/img/demos/hotel/icons/tripadvisor.svg" alt="Tripadvisor Icon" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-dark', 'fadeIn': false}" />
                                    <blockquote class="pt-3 pb-2 px-0 px-md-3">
                                        <p class="text-color-dark text-3-5 line-height-8 alternative-font-4 mb-0">Cras a elit sit amet leo accumsan volutpat. Suspendisse hendreriast ehicula leo, vel efficitur felis ultrices non. Cras a elit sit amet leo acun volutpat. </p>
                                    </blockquote>
                                    <p class="text-color-grey opacity-6">TRIP ADVISOR - NOV 2020</p>
                                    <div class="testimonial-author">
                                        <strong class="font-weight-bold text-4 negative-ls-1">John Doe</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section class="section section-no-background section-no-border m-0">
            <div class="container">
                <div class="row">
                    <div class="col my-3">

                        <div class="text-center">
                            <h3 class="mb-0 pb-0">Special Offers</h3>
                            <div class="divider divider-primary divider-small divider-small-center my-3">
                                <hr class="mt-2">
                            </div>
                        </div>

                        <div class="row pt-2 pb-3">
                            <div class="col-lg-4 mb-4 mb-lg-0">
                                <article class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="0">
                                    <div class="card border-0 border-radius-0 box-shadow-1">
                                        <div class="card-body p-3 z-index-1">
                                            <a href="demo-hotel-book-boxed.html">
                                                <img class="card-img-top border-radius-0 mb-2" src="/hotel/img/slide1.webp" alt="Card Image">
                                            </a>
                                            <div class="card-body p-0">
                                                <h4 class="card-title text-5 font-weight-bold pb-1 mt-3 mb-2"><a class="text-color-dark text-decoration-none" href="demo-hotel-book-boxed.html">PROMO Floating Restaurant</a></h4>
                                                <p class="card-text mb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc viverra lorem , consectetur adipiscing elit...</p>
                                                <a class="font-weight-bold text-uppercase text-2 text-decoration-none mt-2 mb-4" href="demo-hotel-book-boxed.html">Book Now <i class="fas fa-angle-right p-relative top-1 ms-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="col-lg-4 mb-4 mb-lg-0">
                                <article class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="150">
                                    <div class="card border-0 border-radius-0 box-shadow-1">
                                        <div class="card-body p-3 z-index-1">
                                            <a href="demo-hotel-book-boxed.html">
                                                <img class="card-img-top border-radius-0 mb-2" src="/hotel/img/promo2.jpeg" alt="Card Image">
                                            </a>
                                            <div class="card-body p-0">
                                                <h4 class="card-title text-5 font-weight-bold pb-1 mt-3 mb-2"><a class="text-color-dark text-decoration-none" href="demo-hotel-book-boxed.html">PROMO Valentine Days</a></h4>
                                                <p class="card-text mb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc viverra lorem , consectetur adipiscing elit...</p>
                                                <a class="font-weight-bold text-uppercase text-2 text-decoration-none mt-2 mb-4" href="demo-hotel-book-boxed.html">Book Now <i class="fas fa-angle-right p-relative top-1 ms-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="col-lg-4 mb-4 mb-lg-0">
                                <article class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="300">
                                    <div class="card border-0 border-radius-0 box-shadow-1">
                                        <div class="card-body p-3 z-index-1">
                                            <a href="demo-hotel-book-boxed.html">
                                                <img class="card-img-top border-radius-0 mb-2" src="/hotel/img/promo3.jpeg" alt="Card Image">
                                            </a>
                                            <div class="card-body p-0">
                                                <h4 class="card-title text-5 font-weight-bold pb-1 mt-3 mb-2"><a class="text-color-dark text-decoration-none" href="demo-hotel-book-boxed.html">Reverside views from Room</a></h4>
                                                <p class="card-text mb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc viverra lorem , consectetur adipiscing elit...</p>
                                                <a class="font-weight-bold text-uppercase text-2 text-decoration-none mt-2 mb-4" href="demo-hotel-book-boxed.html">Book Now <i class="fas fa-angle-right p-relative top-1 ms-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </section>

        <footer id="footer" class="color bg-primary mt-0 py-5">
            <div class="container">
                <div class="row align-items-center my-3">
                    <div class="col-lg-3">
                        <a href="demo-hotel-boxed.html">
                            <img alt="Porto" class="img-fluid logo" src="<?php echo $logo_white; ?>">
                        </a>
                    </div>
                    <div class="col-lg-6">
        
                        <div class="d-lg-flex">
                            <div class="my-4 my-lg-0 feature-box feature-box-style-5">
                                <div class="feature-box-icon p-0 m-0">
                                    <i class="icon-phone icons text-color-light text-8"></i>
                                </div>
                                <div class="feature-box-info p-0 ms-2">
                                    <label class="text-light opacity-7 d-block line-height-5">CALL US</label>
                                    <strong class="text-uppercase text-5"><a href="tel:<?php echo $phone; ?>" class="text-light ws-nowrap"><?php echo $phone; ?></a></strong>
                                </div>
                            </div>
        
                            <div class="my-4 my-lg-0 feature-box feature-box-style-5 ms-lg-4">
                                <div class="feature-box-icon p-0 m-0">
                                    <i class="icon-location-pin icons text-color-light text-8"></i>
                                </div>
                                <div class="feature-box-info p-0 ms-2">
                                    <label class="text-light opacity-7 d-block line-height-5">ADDRESS</label>
                                    <strong class="text-light text-4 line-height-5"><?php echo $address; ?><a class="d-block font-weight-bold text-color-light text-uppercase text-1" href="<?php echo $direction_link; ?>"><u>Get Directions</u></a></strong>
                                </div>
                            </div>
                        </div>
        
                    </div>
                    <div class="col-lg-3 text-lg-end">
                        <ul class="header-social-icons social-icons social-icons-clean social-icons-icon-light">
                            <li class="social-icons-instagram mx-1"><a href="http://www.instagram.com/" target="_blank" class="text-3" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                            <li class="social-icons-twitter mx-1"><a href="http://www.twitter.com/" target="_blank" class="text-3" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                            <li class="social-icons-facebook mx-1"><a href="http://www.facebook.com/" target="_blank" class="text-3" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

    </div>
@endsection