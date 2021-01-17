<?php

namespace Kesty\Reviewer\Traits;

use Kesty\Reviewer\Models\Rating;
use Illuminate\Database\Eloquent\Model;

trait ReviewRateable
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'reviewrateable');
    }

    /**
     *
     * @return mixed
     */
    public function averageRating($round= null)
    {
        if ($round) {
            return $this->ratings()
              ->selectRaw('ROUND(AVG(rating), '.$round.') as averageReviewer')
              ->pluck('averageReviewer')->first();
        }

        return $this->ratings()
          ->selectRaw('AVG(rating) as averageReviewer')
          ->pluck('averageReviewer')->first();
    }

    /**
     *
     * @return mixed
     */
    public function countRating()
    {
        return $this->ratings()
          ->selectRaw('count(rating) as countReviewer')
          ->pluck('countReviewer')->first();
    }

    /**
     *
     * @return mixed
     */
    public function sumRating()
    {
        return $this->ratings()
            ->selectRaw('SUM(rating) as sumReviewer')
            ->pluck('sumReviewer');
    }

    /**
     * @param $max
     *
     * @return mixed
     */
    public function ratingPercent($max = 5)
    {
        $ratings = $this->ratings();
        $quantity = $ratings->count();
        $total = $ratings->selectRaw('SUM(rating) as total')->pluck('total');
        return ($quantity * $max) > 0 ? $total / (($quantity * $max) / 100) : 0;
    }

    /**
     * @param $data
     * @param $author
     * @param Model|null $parent
     *
     * @return static
     */
    public function rating($data, $author, Model $parent = null)
    {
        return (new Rating())->createRating($this, $data, $author);
    }

    /**
     * @param $id
     * @param $data
     * @param Model|null $parent
     *
     * @return mixed
     */
    public function updateRating($id, $data, Model $parent = null)
    {
        return (new Rating())->updateRating($id, $data);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function deleteRating($id)
    {
        return (new Rating())->deleteRating($id);
    }

    /**
     *
     * @return mixed
     * @param $round
     */
    public function ratingMeta( $round = null) {
     return [
       "avg" => $this->averageRating($round),
       "count" => $this->countRating(),
     ];
    }
}
