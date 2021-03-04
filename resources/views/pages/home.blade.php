@extends('layouts.main')

@section('background-image', asset('images/main-background.jpg'))

@section('body')

<div class="home-page">


<div class="home-hero">
    <div id="starshine" style="opacity: 0.6;">
        <div class="template shine"></div>
    </div>
    <a href="/login" class="home-login-button">
        @icon('account')
    </a> <!-- /.home-login-button -->
    <div class="home-hero__content">
        <div class="logo">
            <a href="/" title="Genie Gaming">
                <img width="258" height="78" src="{{ asset('images/logo.png') }}" alt="Genie Gaming Logo">
            </a>
        </div>

        @if (session('success'))
        <div class="tac">
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        </div>
        <!-- /.tac -->
        @endif

        {!! $introduction !!}
        <a href="/register" class="btn btn-white btn-small">
        Join the fun!
        </a>
        <!-- /.btn btn-white -->

        <h2>Our Skill Based Cash Games</h2>
    </div>
</div>

@foreach ($games as $game)
    @include('components.game', [])
@endforeach

{{-- <div class="home-hero-kids">
    <div id="starshine2" style="opacity: 0.6;"></div>
    <div class="home-hero__content">
        <p>We also have a collection of fun and friendly childrens games available for the Nintendo Switch.</p>
        <h2>Our Childrens Games</h2>
    </div>
</div>

@foreach ($kids_games as $game)
    @include('components.game', [])
@endforeach --}}

    <div class="home-footer">
        <div id="starshine3" style="opacity: 0.6;"></div>
        <div class="home-footer-text">
            <h3>Our platform</h3>
            <p>Transform the playing experience for your existing games by providing players a platform to compete head to head in competitive matches.</p>
            <p><strong>Real Games, Real Money, Real Instant Payouts.</strong></p>
            <br>
            <h3>Get in touch</h3>
            <p>Email us at<br><a href="mailto:support@geniegaming.com">support@geniegaming.com</a><br>or use the form below...</p>
            <form class="form-horizontal" action="{{ route('contact') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input name="name" type="text" placeholder="Your name *" class="form-control input-md" required>
                </div>
                <div class="form-group">
                    <input name="phone" type="text" placeholder="Phone" class="form-control input-md">
                </div>
                <div class="form-group">
                    <input name="email" type="email" placeholder="Email address *" class="form-control input-md" required>
                </div>
                <div class="form-group">
                    <textarea class="form-control" name="message">Message</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <p class="top"><a href="#">Back to Top</a><p>
        </div>
        <!-- /.home-footer-text -->
    </div>



    <footer class="site-footer">

        <div class="footer-social">
            @if($facebook)
                <a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer" class="facebook">
                    @icon('facebook')
                </a>
            @endif
            @if($instagram)
                <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer" class="instagram">
                    @icon('instagram')
                </a>
            @endif
            @if($twitter)
                <a href="{{ $twitter }}" target="_blank" rel="noopener noreferrer" class="twitter">
                    @icon('twitter')
                </a>
            @endif
        </div>
        <!-- /.footer-social -->

        <div>
            <p><small>&copy; {{ Date('Y') }} Genie Gaming</small></p>
            <p>Ingleboro, St. Helens Lane, Corbridge, United Kingdom,<br>NE45 5JD</p>
            {{-- <p>Company Number: 11668563</p> --}}
            <nav>
                <a href="/terms-and-conditions">Terms and conditions</a>
                <a href="/privacy-policy">Privacy Policy</a>
            </nav>
        </div>
    </footer>



</div>
<!-- /.container -->


</div>
<!-- /.home-page -->

@endsection
