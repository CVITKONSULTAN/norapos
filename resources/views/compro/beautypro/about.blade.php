@extends('compro.beautypro.layouts.master')

@push('style')
<style>
    
    div.head_background h1{
        font-family: "Scriptina";
        color: var(--primary);
        font-size: 50pt;
    }
    div.head_background h3{
        font-size: 30pt;
        font-weight: 700;
    }
    div.head_background{
        background-image: url(/images/about.png);
        background-repeat: no-repeat;
        background-size: cover;
        text-align: center;
        /* padding: 2rem 1rem; */
        padding: 8rem 0rem;
    }

    section.teams h1{
        font-family: "Scriptina";
        color: var(--primary);
        font-size: 50pt;
    }
    section.teams h3{
        font-size: 30pt;
        font-weight: 700;
        color: var(--white);
    }
    section.teams{
        text-align: center;
        background: #1E1E1E;
        padding: 3rem 1rem;
    }
    h5.people{
        color: var(--white);
        text-align: center;
    }
    p.position{
        color: var(--primary);
        text-align: center;
    }

    section.checkout a{
        color: #000;
    }
    section.checkout {
        text-align: center;
        padding: 2rem 1rem;
    }
    section.checkout h3{
        font-size: 30pt;
        font-weight: 700;
    }
    section.checkout h1{
        font-family: "Scriptina";
        color: var(--primary);
        font-size: 50pt;
    }
    
    
    /* in desktop */
    @media (min-width: 992px){
        
    }

    /* on mobile */
    @media screen and (max-width: 768px) {
        
    }
    
</style>
@endpush

@section('main')
<!-- MAIN section -->
    <div class="head_background">
        <h1>About Us</h1>
        <h3 class="mt-3">Beauty Pro Clinic</h3>
    </div>
    <div class="container py-5">
        <p class="text-center">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Pellentesque in mauris eget nulla dictum molestie. Cras rhoncus ullamcorper dignissim. Sed venenatis risus in leo dapibus molestie.
            Vivamus vel risus facilisis tellus efficitur interdum. Nunc in tempus nulla, feugiat rhoncus enim. Pellentesque sodales, nisl sit amet vestibulum venenatis, justo est volutpat sem
            nec dictum quam lorem vitae augue. Vivamus dapibus facilisis libero eget pulvinar. Proin rhoncus pretium est, non egestas neque condimentum at. Vivamus aliquam mattis aliquet.
            Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aliquam vehicula non elit vel varius. Nullam id vestibulum libero.
            Phasellus dignissim elit ipsum, non tempus erat malesuada sit amet. Phasellus efficitur, erat non efficitur lacinia, dolor risus hendrerit metus, et gravida dolor tortor a diam.
        </p>
        <p class="text-center">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Pellentesque in mauris eget nulla dictum molestie. Cras rhoncus ullamcorper dignissim. Sed venenatis risus in leo dapibus molestie.
            Vivamus vel risus facilisis tellus efficitur interdum. Nunc in tempus nulla, feugiat rhoncus enim. Pellentesque sodales, nisl sit amet vestibulum venenatis, justo est volutpat sem
            nec dictum quam lorem vitae augue. Vivamus dapibus facilisis libero eget pulvinar. Proin rhoncus pretium est, non egestas neque condimentum at. Vivamus aliquam mattis aliquet.
            Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aliquam vehicula non elit vel varius. Nullam id vestibulum libero.
            Phasellus dignissim elit ipsum, non tempus erat malesuada sit amet. Phasellus efficitur, erat non efficitur lacinia, dolor risus hendrerit metus, et gravida dolor tortor a diam.
        </p>
    </div>
    <section class="teams">
        <h1>Who we are?</h1>
        <h3 class="mt-3 mb-5">MEET THE BEAUTY PRO CLINIC TEAM</h3>
        <div class="row">
            <div class="col-md-3">
                <img src="/images/people 1.png" />
                <h5 class="people mt-3">dr. ELIZABETH TIERNEY</h5>
                <p class="position">Direktur</p>
            </div>
            <div class="col-md-3">
                <img src="/images/people 1.png" />
                <h5 class="people mt-3">dr. ELIZABETH TIERNEY</h5>
                <p class="position">Direktur</p>
            </div>
            <div class="col-md-3">
                <img src="/images/people 1.png" />
                <h5 class="people mt-3">dr. ELIZABETH TIERNEY</h5>
                <p class="position">Direktur</p>
            </div>
            <div class="col-md-3">
                <img src="/images/people 1.png" />
                <h5 class="people mt-3">dr. ELIZABETH TIERNEY</h5>
                <p class="position">Direktur</p>
            </div>
        </div>
    </section>

    <section class="checkout">
        <h1>Check out</h1>
        <h3 class="mt-3 mb-5">OUR MOST POPULAR TREATMENTS</h3>

        <div class="row">
            <div class="col-md-4">
                <a href="#">
                    <img src="/images/checkout 1.png" />
                    <h5 class="mt-3">Nama Treatment</h5>
                </a>
            </div>
            <div class="col-md-4">
                <a href="#">
                    <img src="/images/checkout 1.png" />
                    <h5 class="mt-3">Nama Treatment</h5>
                </a>
            </div>
            <div class="col-md-4">
                <a href="#">
                    <img src="/images/checkout 1.png" />
                    <h5 class="mt-3">Nama Treatment</h5>
                </a>
            </div>
        </div>

    </section>

<!-- MAIN section -->
@endsection