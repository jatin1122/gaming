<div class="home-game-tile {{ $loop->iteration % 2 == 0 ? 'home-game-tile--reverse' : null }}" style="background-color: {{ $game['background_color'] }}">
  
    <div class="home-game__content">    
        <div>
        @if($game['link'])
        <a href="{{ $game['link'] }}" target="_blank">
        @endif
            <h3><img src="{{ $game['logo'] }}" alt="{{ $game['name'] }}"></h3>
            {!! $game['description'] !!}
            <div class="home-game__platforms {{ $game['available']  ? 'home-game__platforms--available' : 'home-game__platforms--comingsoon' }}">
                @foreach ($game['platforms'] as $platform => $name)
                    @icon($platform)
                @endforeach
            </div>
            <div class="home-game__availability {{ $game['available']  ? 'home-game__availability--available' : 'home-game__availability--comingsoon' }}">
            @if($game['link'])
                {{ $game['type'] }} now..
            @else
                {{ $game['available']  ? 'Out now!' : 'Coming soon!' }}
            @endif
            </div>
        @if($game['link'])
        </a>
        @endif
        </div>        
    </div>
    
    <!-- /.home-game__content -->
    @if(count($game['gallery']) >= 1)
    <div class="swiper-container home-game__swiper-container">
        {{-- @if(count($game['gallery'])) --}}
            <div class="swiper-wrapper {{ count($game['gallery']) == 1 ? 'disabled' : null }}">
                @foreach ($game['gallery'] as $gallery)
                    <div class="swiper-slide home-game-swiper-slide">
                        @if($gallery['type'] == 'image')
                            <img class="swiper-lazy" src="{{ $gallery['src'] }}" alt="{{ $gallery['alt'] }}">
                            {{-- <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div> --}}
                        @elseif($gallery['type'] == 'video')
                            <iframe 
                                width="560" height="315" 
                                src="https://www.youtube.com/embed/{{ $gallery['link'] }}?modestbranding=1&rel=0&color=red" 
                                frameborder="0" 
                                allow="encrypted-media" 
                                allowfullscreen
                            ></iframe>
                        @endif
                    </div>
                @endforeach
            </div>
            <!-- /.swiper-wrapper -->
            {{-- @if(count($game['gallery']) > 1) --}}
                <div {{ count($game['gallery']) < 2 ? 'hidden' : null }} class="swiper-button-next swiper-button-white"></div>
                <div {{ count($game['gallery']) < 2 ? 'hidden' : null }} class="swiper-button-prev swiper-button-white"></div>
            {{-- @endif --}}
        {{-- @endif --}}
    </div>
    <!-- /.home-game__swiper-container -->
    @endif
</div>
<!-- /.home-game-tile -->