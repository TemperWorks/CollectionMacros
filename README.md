
# CollectionMacros

Macros, for Laravel Collections.

This package currently only contains `matchWith`

## matchWith

`matchWith` pairs two **pre-sorted** collections with eachother. It takes a comparator function and callbacks to handle both matched and unmatched items. It does this as efficiently as possible in O(n) by walking through both collections alongside each other.
         
```php
collect([ 1,2,4,7,8,9,14 ]))->matchWith(
    collect([ 1,2,5,6,8,10,11,13,14 ]),
    function($a, $b) { return $a <=> $b; },
    function($a, $b) { echo "$a matches $b"; },
    function($a) { echo "$a was not found in b"; },
    function($b) { echo "$b was not found in a"; },
);
```
