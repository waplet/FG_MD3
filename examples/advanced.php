<?php
require_once("../Pushdown_Automata.php");

try {

    $a = new Pushdown_Automata();
    $a->setStates( ['Q1', 'Q2', 'Q3']);
    $a->setTerminals( ['a','b'] );
    $a->setStackSymbols( ['Z','a','b'] );
    $a->setStartState( 'Q1' );
    $a->setStartSymbol( 'Z' );
    $a->setAcceptableStates( ['Q3'] );
    $a->setSearchWord('');
    $a->setDeltaFunction( [
        'Q1' => [
            [ 'a', '', 'Q1', 'a'],
            [ 'b', '', 'Q1', 'b'],
            [ '' , '', 'Q2', '']
        ],
        'Q2' => [
            [ 'a', 'a', 'Q2', '' ],
            [ 'b', 'b', 'Q2', ''],
            [ '', 'Z' , 'Q3', '']
        ],
        'Q3' => []
    ]);
    $a->start();

} catch ( Exception $e ) {
    echo $e->getMessage();die;
}

echo "Word: " . $a->getSearchWord()."<br/>";
echo $a->status() ? "Accepted" : "Not Accepted";
