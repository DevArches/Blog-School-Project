<?php
class RatingManagement
{
    private $ratingRepository;

    public function __construct($ratingRepository)
    {
        $this->ratingRepository = $ratingRepository;
    }

    public function getRatings()
    {
        $ratings = $this->ratingRepository->getAll();
        return $ratings;
    }

    public function getRatingCount($bnum)
    {
        $ratings = $this->getRatings();
        $count = 0;
        foreach ($ratings as $rating) {
            if ($rating['bnum'] == $bnum) {
                $count++;
            }
        }
        return $count;
    }

    public function Stars($bnum)
    {
        $rating = $this->ratingRepository->getRatingAverage($bnum);
        $stars = 5;
        for ($i = 0; $i < $stars;) {
            if ($i + 0.5 < $rating) {
                $num = $i + 1;
                $i++;
                echo '<a href="star.php?rating=' . $num . '&bnum=' . $bnum . '"><span class="fa fa-star checked" id="starA"></span></a>';
            } elseif ($i - 0.5 < $rating && $rating > $i) {
                $num = $i + 1;
                $i++;
                echo '<a href="star.php?rating=' . $num . '&bnum=' . $bnum . '"><span class="fa fa-star-half-empty checked" id="starA"></span></a>';
            } else {
                $num = $i + 1;
                $i++;
                echo '<a href="star.php?rating=' . $num . '&bnum=' . $bnum . '"><span class="fa fa-star" id="starA"></span></a>';
            }
        }
    }

    public function newRating($bnum, $newRating, $user)
    {   
        if (is_numeric($newRating) && $newRating >= 1 && $newRating <= 5) {
        $this->ratingRepository->newRating($bnum, $newRating, $user);
        } else {
            header ('Location: index.php#b' . $bnum);
            exit;
        }
}
    
    public function checkUserRating($bnum, $user)
    {
        return $this->ratingRepository->checkUserRating($bnum, $user); 
    }
}
