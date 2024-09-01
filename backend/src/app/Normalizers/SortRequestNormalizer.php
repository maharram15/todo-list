<?php

namespace App\Normalizers;

use App\Contracts\NormalizerInterface;
use App\Contracts\SortsInterface;
use App\Sorts\Sort;
use App\Sorts\Sorts;
use Illuminate\Http\Request;

class SortRequestNormalizer implements NormalizerInterface
{
    public function __construct(
        protected Request $request
    ){}

    public function normalize(): SortsInterface
    {
        $sortsRaw = (array) $this->request->query('sort', []);
        $sortsRaw = array_filter($sortsRaw);
        $sorts = new Sorts();
        foreach ($sortsRaw as $sort) {
            $sorts->put(new Sort($sort));
        }

        return $sorts;
    }

}
