<?php

namespace App\Transfomer;

interface DataTransformerInterface
{
    /**
     * Transform to a Weather class
     * @return mixed
     */
    public function transform($data);

    /**
     * Reverse transform back to the format of the api response
     * @return mixed
     */
    public function reverseTransform($data);
}
