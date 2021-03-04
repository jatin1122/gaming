<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Mail\Generic;

class HomeController extends Controller
{
    /**
     * Show the homepage.
     *
     * @return \Illuminate\Http\Response
     */

    protected function get_youtube_id($url)
	{
		$pattern =
			'%^               # Match any youtube URL
				(?:https?://)?    # Optional scheme. Either http or https
				(?:www\.)?        # Optional www subdomain
				(?:               # Group host alternatives
					youtu\.be/     # Either youtu.be,
				| youtube\.com    # or youtube.com
					(?:            # Group path alternatives
						/embed/     # Either /embed/
					| /v/          # or /v/
					| /watch\?v=   # or /watch\?v=
					)              # End path alternatives.
				)                 # End host alternatives.
				([\w-]{10,12})    # Allow 10-12 for 11 char youtube id.
				$%x';
		$result = preg_match($pattern, $url, $matches);
		if ($result) {
			return $matches[1];
		}
		return false;
	}

    public function index()
    {

        $games = [
            [
                'background_color' => '#0154c3',
                'name' => 'Pool',
                'logo' => asset('images/home/pool/logo.png'),
                'platforms' => [
                    'ios' => 'iOS'
                ],
                'type' => 'Download',
                'available' => true,
                'link' => 'https://apps.apple.com/gb/app/8-ball-pool-real-cash/id1231423188',
                'description' => '
                    <p><strong>Test your pool skills against thousands of other gamers and win real cash!</strong></p>
                    <p>Using a top-down perspective, the game allows you to play matches against other online gamers head to head.</p>
                    <p>Real Players, Real Money, Instant Payouts!</p>
                    <p>You choose how much you want to win!!</p>
                    <p>Prizes start from £2</p>
                ',
                'gallery' => [
                    [
                        'type' => 'image',
                        'src' => asset('images/home/pool/gallery-3.png'),
                        'alt' => 'Challenge friends'
                    ],
                ]
            ],     
            [
                'background_color' => '#00733c',
                'name' => 'Golf',
                'logo' => asset('images/home/golf/logo.png'),
                'platforms' => [
                    'ios' => 'iOS',
                    'android' => 'Android',
                ],
                'type' => 'Download',
                'available' => false,
                'link' => null,
                'description' => '
                    <p><strong>Great Golf with a competitive edge!</strong></p>
                    <p>The worlds first true mobile esports Golf Game! </p>
                    <p>Multiplayer Fun Instant payouts</p>
                    <p>Prizes start from £2</p>
                    <p>Coming early 2020</p>
                ',
                'gallery' => [
                    [
                        'type' => 'image',
                        'src' => asset('images/home/golf/gallery-1.jpg'),
                        'alt' => 'Challenge friends'
                    ],
                ]
            ],       
        ];

        $kids_games = [
            [
                'background_color' => '#d20043',
                'name' => 'Unicornicopia',
                'logo' => asset('images/home/unicornicopia/logo.png'),
                'platforms' => [
                    'switch' => 'Switch',
                ],
                'type' => 'Buy',
                'available' => true,
                'link' => 'https://www.nintendo.co.uk/Games/Nintendo-Switch-download-software/Unicornicopia-1491642.html',
                'description' => '
                    <p>Alone in the forest, a Unicorn wakes, Searching for its herd as a new dawn breaks. Where are my friends? Not to the west, to find them I must set out on a quest!</p>
                    <p>Aimed at a younger audience this endless runner, virtual pet hybrid is simple to play but hard to put down. With a sprinkle of magical minigames, this enchanted title will be sure to keep you smiling!</p>
                ',
                'gallery' => [
                    [
                        'type' => 'video',
                        'link' => $this->get_youtube_id('https://www.youtube.com/watch?v=qKIFFlohb8A')
                    ],
                    [
                        'type' => 'image',
                        'src' => asset('images/home/unicornicopia/gallery-1.jpg'),
                        'alt' => 'screenshot of unicornicopia'
                    ],
                    [
                        'type' => 'image',
                        'src' => asset('images/home/unicornicopia/gallery-2.jpg'),
                        'alt' => 'screenshot of unicornicopia'
                    ],
                    [
                        'type' => 'image',
                        'src' => asset('images/home/unicornicopia/gallery-3.jpg'),
                        'alt' => 'screenshot of unicornicopia'
                    ],
                    [
                        'type' => 'image',
                        'src' => asset('images/home/unicornicopia/gallery-4.jpg'),
                        'alt' => 'screenshot of unicornicopia'
                    ],
                    [
                        'type' => 'image',
                        'src' => asset('images/home/unicornicopia/gallery-5.jpg'),
                        'alt' => 'screenshot of unicornicopia'
                    ],
                    [
                        'type' => 'image',
                        'src' => asset('images/home/unicornicopia/gallery-6.jpg'),
                        'alt' => 'screenshot of unicornicopia'
                    ],
                ]
            ],
            [
                'background_color' => '#f96a1f',
                'name' => 'Kaiju Khaos',
                'logo' => asset('images/home/kaiju-khaos/logo.png'),
                'platforms' => [
                    'switch' => 'Switch',
                ],
                'type' => 'Buy',
                'available' => true,
                'link' => 'https://www.nintendo.co.uk/Games/Nintendo-Switch-download-software/KAIJU-KHAOS-1636177.html',
                'description' => '
                    <p>Unleash the beast!</p>
                    <p>An endless runner where you must cause as much destruction as you can whilst you make your escape from the military containment facility.</p>
                    <p>Unlock different Kaijus and grow them to monstorous sizes to overcome the obstacles in your path and take your revenge on mankind.</p>
                ',
                'gallery' => [
                    [
                        'type' => 'video',
                        'link' => $this->get_youtube_id('https://www.youtube.com/watch?v=_e-VzM7pny8')
                    ],
                    [
                        'type' => 'image',
                        'src' => asset('images/home/kaiju-khaos/gallery-1.jpg'),
                        'alt' => 'screenshot of Kaiju khaos'
                    ],
                    [
                        'type' => 'image',
                        'src' => asset('images/home/kaiju-khaos/gallery-2.jpg'),
                        'alt' => 'screenshot of Kaiju khaos'
                    ],
                    [
                        'type' => 'image',
                        'src' => asset('images/home/kaiju-khaos/gallery-3.jpg'),
                        'alt' => 'screenshot of Kaiju khaos'
                    ],
                    [
                        'type' => 'image',
                        'src' => asset('images/home/kaiju-khaos/gallery-4.jpg'),
                        'alt' => 'screenshot of Kaiju khaos'
                    ],
                ]
            ],
        ];

        $data = [
            'introduction' => "
                <h1>About Us</h1>
                <p><strong>Formed in 2016, Genie Gaming is the world's first and only Real Time Real Money mobile eSports provider.</strong></p>
                <p>As well as creating our own exciting games, we collaborate with like-minded game developers, porting their titles on to our unique platform.</p>
            ",
            'our_platform' => '
                <p>Transform the playing experience for your existing games by pro</p>
                <p><strong></strong></p>
            ',
            'games' => $games,
            'kids_games' => $kids_games,

            'facebook' => 'https://www.facebook.com/GenieGaming-2211336809186884',
            'instagram' => 'https://www.instagram.com/genieGaming_/',
            'twitter' => 'https://twitter.com/geniegaming_',
        ];
        return view('pages.home', $data);
    }

    public function contact(Request $request) {
        $content = "<p>Name: $request->name</p><p>Email: $request->email</p><p>Phone: $request->phone</p><p>Message: " . nl2br($request->message) . "</p>";
        \Mail::to('support@geniegaming.com')->send(new Generic($content));
        return redirect('/')->with('success', 'Thank you for your message. We will be in touch soon...');
    }
}
