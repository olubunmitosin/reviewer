<?php

namespace Kesty\Reviewer\Contracts;

use Illuminate\Database\Eloquent\Model;

interface ReviewRateable
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function ratings();

    /**
     *
     * @return mixed
     */
    public function averageRating($round= null);

    /**
     *
     * @return mixed
     */
    public function countRating();

    /**
     *
     * @return mixed
     */
    public function sumRating();

    /**
     * @param $max
     *
     * @return mixed
     */
    public function ratingPercent($max = 5);

    /**
     * @param $data
     * @param $author
     * @param Model|null $parent
     *
     * @return mixed
     */
    public function rating($data, $author, Model $parent = null);

    /**
     * @param $id
     * @param $data
     * @param Model|null $parent
     *
     * @return mixed
     */
    public function updateRating($id, $data, Model $parent = null);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function deleteRating($id);
}
