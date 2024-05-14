@extends('layouts.app')
@section('content')
    {{-- Head banner --}}
    @include('components.head-banner')

    <div class="contact-form-area pt-90 pb-100">
        <div class="container">
            <div class="section-title-4 text-center mb-55" data-aos="fade-up" data-aos-delay="200">
                <h2>Ask Us Anything Here</h2>
            </div>
            <div class="contact-form-wrap" data-aos="fade-up" data-aos-delay="200">
                <div class="contact-form-style" id="contact-form">
                    <div class="row">
                        <div class="col-lg-4">
                            <input name="name" type="text" placeholder="Name*">
                            <input name="email" type="email" placeholder="Email*">
                            <input name="subject" type="text" placeholder="Subject*">
                            <input name="phone" type="text" placeholder="Phone*">
                        </div>
                        <div class="col-lg-8">
                            <textarea name="message" placeholder="Message"></textarea>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12 contact-us-btn btn-hover">
                            <button class="submit" type="submit">Send Message</button>
                        </div>
                    </div>
                </div>
                <p class="form-messege"></p>
            </div>
        </div>
    </div>
    <div class="map pt-120" data-aos="fade-up" data-aos-delay="200">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d317718.69319292053!2d-0.3817765050863085!3d51.528307984912544!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47d8a00baf21de75%3A0x52963a5addd52a99!2sLondon%2C+UK!5e0!3m2!1sen!2sin!4v1463669021863"></iframe>
    </div>
@endsection
