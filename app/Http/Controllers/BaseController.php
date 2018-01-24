<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Club;
use App\Models\Contact;
use App\Models\League;
use App\Models\Match;
use App\Models\Year;
use Carbon\Carbon;
use Facepalm\Http\Controllers\BaseController as FacepalmBaseController;
use App\Models\User;
use Facepalm\Tools\TextProcessor;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Twig_SimpleFunction;
use TwigBridge\Facade\Twig;

class BaseController extends FacepalmBaseController
{

    protected $images;
    protected $texts;
    protected $strings;
    protected $categories;

    protected $years;

    /**
     * BaseController constructor.
     * @param Request $request
     * @param TextProcessor $processor
     */
    public function __construct(Request $request, TextProcessor $processor)
    {

        $function = new Twig_SimpleFunction('russian_date', function ($date) {
            return russian_date($date);
        });
        Twig::addFunction($function);

        $this->addSiteNameToTitle = true;
        $this->siteName = 'Squashbase';

        parent::__construct($request, $processor);

        $this->commonViewValues['colors'] = [
            'red' => '#e9573f',
            'yellow' => '#ffce54',
            'green' => '#8cc152',
            'blue' => '#4a89dc',
            'violet' => '#967adc',
            'mint-light' => '#48cfad',
        ];
        $this->commonViewValues['user'] = auth()->user();
        $this->commonViewValues['minDate'] = Carbon::now()->subYear(1);
        $this->commonViewValues['returnUrl'] = $this->request->input('returnUrl');

        if ($this->currentSection) {
            $this->texts = $this->currentSection->texts();
            $this->strings = $this->currentSection->strings();
            $this->images = $this->currentSection->imagesByGroup();
        }
    }

    /**
     * @param $text
     * @return mixed
     */
    protected function processText($text)
    {
        if ($text) {
            $text = $this->textProcessor->replaceMceImages($text, [
                'image' => 'partials/image',
                'gallery' => 'partials/gallery',
            ]);


            $text = preg_replace('/(<iframe.*<\/iframe>)/isU', '<div class="video-container">$1</div>', $text);
            $text = preg_replace('/(<table.*<\/table>)/isU', '<article class="b-table">$1</article>', $text);
        }

        return $text;
    }

    /**
     * @param $template
     * @param $parameters
     * @return mixed
     */

    protected function render($template, array $parameters = array())
    {
        return parent::render($template, $parameters + [
                'texts' => $this->texts,
                'strings' => $this->strings,
                'images' => $this->images,
            ]);
    }


    /**
     * @param Match $match
     * @param $returnUrl
     * @param $colorClass
     * @return mixed
     */
    protected function renderEditMatchForm($match, $returnUrl, $colorClass)
    {
        $players = User::where('status', 1)->where('last_name', '!=', '')->where('first_name', '!=',
            '')->where('is_player', true)->orderBy('last_name')->orderBy('first_name')->get();
        $clubs = Club::where('status', 1)->orderBy('name')->get();
        $match->games = json_decode($match->results, true);
        return $this->render('pages/edit-match', [
            'players' => $players,
            'leagues' => app('LeaguesService')->getLeaguesForSelector(),
            'clubs' => $clubs,
            'match' => $match,
            'returnUrl' => $returnUrl,
            'header' => [
                'color' => $colorClass,
                'title' => 'Редактирование матча',
                'back' => $returnUrl,
            ]
        ]);
    }


    /**
     * @param Match $match
     * @param $returnUrl
     * @param $colorClass
     * @return mixed
     */
    protected function renderMatchPage(Match $match, $returnUrl, $colorClass, $template = 'pages/match')
    {
        $match->games = json_decode($match->results, true);
        $match->score = str_replace(':', ' – ', $match->score);
        $rightButton = null;
        if ($match->canUserEdit(auth()->user())) {
            $rightButton = [
                'icon' => 'edit',
                'path' => './edit/'
            ];
        }
        return $this->render($template, [
            'match' => $match,
            'header' => [
                'color' => $colorClass,
                'title' => 'Информация о матче',
                'back' => $returnUrl,
                'rightButton' => $rightButton ?: ''
            ]
        ]);
    }


}