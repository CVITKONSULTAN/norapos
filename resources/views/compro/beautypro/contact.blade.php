@extends('compro.beautypro.layouts.master')

@push('style')
<style>
        
        div.head_background h1{
            font-weight: 700;
            font-size: 50pt;
            text-decoration: underline;
            text-decoration-color: var(--primary);
            text-underline-offset: 2rem;
        }

        div.head_background h3{
            font-size: 30pt;
            font-weight: 700;
        }
        div.head_background{
            background-image: url(/images/banner_contact.png);
            background-repeat: no-repeat;
            background-size: cover;
            text-align: center;
            /* padding: 2rem 1rem; */
            padding: 8rem 0rem;
        }

        .promo-banner{
            width: 100%;
        }


</style>
@endpush

@section('main')

    <!-- MAIN section -->
    <div class="head_background">
        <h1>CONTACT US</h1>
    </div>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.8157320356445!2d109.34418687616245!3d-0.0652632999340851!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e1d593fbd30cc37%3A0xaef1db5a96a1219f!2sBeauty%20Pro%20Clinic!5e0!3m2!1sen!2sid!4v1685446219835!5m2!1sen!2sid" 
    width="100%" 
    height="500" 
    style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    <a href="#">
        <img src="/images/banner promo.png" class="promo-banner" />
    </a>
    <!-- MAIN section -->
    
@endsection

@push('javascript')

@endpush