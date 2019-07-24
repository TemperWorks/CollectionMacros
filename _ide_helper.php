<?php

namespace  {
    exit("This file should not be included, only analyzed by your IDE");
}


namespace Illuminate\Support {

    /**
     * Class Collection
     * @package Illuminate\Support
     */
    class Collection
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
        public function matchWith(Collection $b, callable $comparator, callable $matched, callable $unmatchedA = null, callable $unmatchedB = null): self
        {
            return $this;
        }
    }
}
