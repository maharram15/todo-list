<?php

namespace App\Normalizers;

use App\Contracts\FiltersInterface;
use App\Contracts\NormalizerInterface;
use App\Filters\Filter;
use App\Filters\Filters;
use Illuminate\Http\Request;

class FilterRequestNormalizer implements NormalizerInterface
{
    public function __construct(protected Request $request){}

    public function normalize(): FiltersInterface
    {
        $filtersRaw = $this->request->query('filter', []);

        $filters = new Filters();

        foreach ($filtersRaw as $column => $value) {
            $filters->addFilter(new Filter($column, $value));
        }

        return $filters;
    }
}
