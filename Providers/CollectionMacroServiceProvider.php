<?php declare(strict_types=1);

namespace Temper\CollectionMacros\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;

class CollectionMacroServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /**
         * Matches two sorted collections based on a comparator callable with O(m+n) efficiency
         * Accepts callables for matched pairs as well as unmatched elements (on both sides)
         * Collections can have ordered duplicates, all permutations become matched pairs
         *
         * Example:
         * ```php
         * collect([ 1,2,4,7,8,9,14 ]))->matchWith(
         *     collect([ 1,2,5,6,8,10,11,13,14 ]),
         *     function($a, $b) { return $a <=> $b; },
         *     function($a, $b) { echo "$a matches $b"; },
         *     function($a) { echo "$a was not found in b"; },
         *     function($b) { echo "$b was not found in a"; },
         * );
         * ```
         *
         * @param Collection $b A collection to match up with
         * @param callable $comparator A comparator function, to match orderable elements using a <=> b
         * @param callable $matched A callback to be executed on each matched pair
         * @param callable $unmatchedA A callback to be executed for each unmatched item in the a collection
         * @param callable $unmatchedB A callback to be executed on each unmatched item in the b collection
         * @return $this
         */
        Collection::macro('matchWith', function(
            Collection $b,
            callable $comparator,
            callable $matched,
            callable $unmatchedA = null,
            callable $unmatchedB = null
        ): self
        {
            $a = $this->values();
            $b = $b->values();
            $an = $bn = 0;

            while ($an < $a->count() && $bn < $b->count()) {
                switch ($comparator($a[$an], $b[$bn])) {
                    case -1:
                        if ($unmatchedA) $unmatchedA($a[$an]);
                        $an++;
                        break;
                    case 0:
                        $matched($a[$an], $b[$bn]);
                        // Perform a lookahead to permutate on duplicates
                        if (isset($a[$an + 1]) && $comparator($a[$an + 1], $b[$bn]) === 0) $an++;
                        elseif (isset($b[$bn + 1]) && $comparator($a[$an], $b[$bn + 1]) === 0) $bn++;
                        else {
                            $an++;
                            $bn++;
                        }
                        break;
                    case 1:
                        if ($unmatchedB) $unmatchedB($b[$bn]);
                        $bn++;
                        break;
                }
            }

            // Take care of any unmatched trailing items left over in either collection
            while (isset($a[$an])) {
                if ($unmatchedA) $unmatchedA($a[$an]);
                $an++;
            }

            while (isset($b[$bn])) {
                if ($unmatchedB) $unmatchedB($b[$bn]);
                $bn++;
            }

            return $this;
        });
    }
}
