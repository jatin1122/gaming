@extends('layouts.main')

@section('background-image', asset('images/main-background.jpg'))

@section('body')


    <div class="home-hero">
        <div id="starshine" style="opacity: 0.6;">
            <div class="template shine"></div>
        </div>
        {{-- <a href="/login" class="home-login-button">
            @icon('account')
        </a> <!-- /.home-login-button --> --}}
        <div class="home-hero__content">
            <h1>
                <a href="/" title="Genie Gaming">
                    <img width="258" height="78" src="{{ asset('images/logo.png') }}" alt="Genie Gaming Logo">
                </a>                
            </h1>
        </div>
    </div>


    <div class="container">
        <div class="generic-typography">




            {!! $content !!}



            
        </div>
        <!-- /.generic-typography -->
    </div>
    <!-- /.container -->


    <div class="home-footer">
        <div id="starshine2" style="opacity: 0.6;"></div>
        <div class="home-footer-text">
            <h3>Our platform</h3>
            <p>Transform the playing experience for your existing games by providing players a platform to compete head to head in competitive matches.</p>
            <p><strong>Real Games, Real Money, Real Instant Payouts.</strong></p>
            <br>
            <p>Get in touch</p>
            <a href="mailto:developers@geniegaming.com">developers@geniegaming.com</a>
            <p class="top"><a href="#">Back to Top</a><p>
        </div>
        <!-- /.home-footer-text -->
    </div>



    <footer class="site-footer">

        <div class="footer-social">
            @if($facebook)
                <a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer">
                    @icon('facebook')
                </a>
            @endif
            @if($instagram)
                <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer">
                    @icon('instagram')
                </a>
            @endif
            @if($twitter)
                <a href="{{ $twitter }}" target="_blank" rel="noopener noreferrer">
                    @icon('twitter')
                </a>
            @endif
        </div>
        <!-- /.footer-social -->

        <div>
            <p><small>&copy; {{ Date('Y') }} Genie Gaming</small></p>
            
            <nav>
                <a href="/terms-and-conditions">Terms and conditions</a>
                <a href="/privacy-policy">Privacy Policy</a>
            </nav>
        </div>
    </footer>



</div>
<!-- /.container -->



@endsection
