<?php
require_once("../Pushdown_Automata.php");

try {

    $a = new Pushdown_Automata();

    $a->setStates( ['Q1', 'Q2', 'Q3']);
    $a->setTerminals( ['a','b'] );
    $a->setStackSymbols( ['Z','Y'] );
    $a->setStartState('Q1');
    $a->setStartSymbol('Z');
    $a->setAcceptableStates( ['Q1'] );
    $a->setSearchWord('ab');
    $a->setDeltaFunction( [
        'Q1' => [
            ['a','Z', 'Q2', 'YZ' ]
        ],
        'Q2' => [
            [ 'a', 'Y', 'Q2', 'YY' ],
            [ 'b', 'Y', 'Q3', '' ]
        ],
        'Q3' => [
            [ '', 'Z', 'Q1', '' ],
            [ 'b', 'Y', 'Q3', '' ]
        ]
    ]);

    $a->start();

} catch ( Exception $e ) {
    echo $e->getMessage();die;
}

echo "Word: " . $a->getSearchWord()."<br/>";
echo $a->status() ? "Accepted" : "Not Accepted";
