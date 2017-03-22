<?php

namespace App\Utils;

use Illuminate\Support\Collection;

class Inspiring
{

    public static function quote()
    {
        return Collection::make([

            // 'When there is no desire, all things are at peace. - Laozi',
            // 'Simplicity is the ultimate sophistication. - Leonardo da Vinci',
            // 'Simplicity is the essence of happiness. - Cedric Bledsoe',
            // 'Smile, breathe, and go slowly. - Thich Nhat Hanh',
            // 'Simplicity is an acquired taste. - Katharine Gerould',
            // 'Well begun is half done. - Aristotle',
            // 'He who is contented is rich. - Laozi',
            // 'Very little is needed to make a happy life. - Marcus Antoninus',
            'There is only one boss... the customer. - Sam Walton @ Walmart',
            'Get Shit Done. - Aaron Levie @ Box',
            'Less Meetings. More Doing. - Jason Goldberg @ Fab.com',
            "Don't Compromise. - Steve Jobs @ Apple",
            'Whatever the problem be part of the solution. - Tina Fey',
            "If a user is having a problem, it's our problem. - Steve Jobs @ Apple",
            'Complaining is not a strategy. - Jeff Bezons @ Amazon',
            "Optimism, pessimism, F... that! We're going to make it happen. - Elon Musk @ Tesla",
            'Think like a customer. - Paul Gillin',
            'Always deliver more than expected. - Larry Page @ Google',
            'Done is better than perfect. - Sheryl Sandberg @ Facebook',
            'Make it work then make it better',
            'Be more curious. - Tanner Christensen @ Facebook',
            'Start where you are, use what you have, do what you can',
            'Ideas are worthless until you get them out of your head to see what they can do. - Tanner Christensen @ Facebook',
            'Set goals. Reach. Repeat',
            'Quality is the best business plan. - John Lasseter @ Pixar',
            'Never Never Never Give Up. - Winston Churchill',
            'Life is short. Do stuff that matters. - Siqi Chen @ Hey',
            'Experiment. Fail. Learn. Repeat.',
            "We have a strategic plan. It's called Doing Things. - Herb Kelleher @ Southwest Arilines",
            'Vision without execution is hallucination',
            "It's simple until you make it complicated. - Jason Fried @ Twitter",
            "There's nothing wrong with being small. You can do big things with a small team. - Jason Fried @ 37signals",
            "There are seven days in a week. Someday isn't one of them",
            'Wake up with determination. Go to bed with satisfaction',
            "Be so good they can't ignore you. - Steve Martin",
            'The worst decision is indecision. - Ryan Harwood @ PureWow',
            "Don't guess. Measure. - Slava Akhmechet @ RethinkDB",
            'Try again. Fail again. Fail better. - Samuel Beckett',

        ])->random();
    }
}
