<?php
require_once("Pushdown_Automata.php");


try {

    $a = new Pushdown_Automata();
    // test case #1
    // $a->setStates( ['Q1', 'Q2', 'Q3']);
    // $a->setTerminals( ['a','b'] ); // termināļi
    // $a->setStackSymbols( ['Z','Y'] );
    // $a->setStartState('Q1');
    // $a->setStartSymbol('Z');
    // $a->setAcceptableStates( ['Q1'] );
    // $a->setSearchWord('');
    // $a->setDeltaFunction( [
    //     'Q1' => [
    //         ['a','Z', 'Q2', 'YZ' ]
    //     ],
    //     'Q2' => [
    //         [ 'a', 'Y', 'Q2', 'YY' ],
    //         [ 'b', 'Y', 'Q3', '' ]
    //     ],
    //     'Q3' => [
    //         [ '', 'Z', 'Q1', '' ],
    //         [ 'b', 'Y', 'Q3', '' ]
    //     ]
    // ]);


    // test case #2
    // $a->setStates( ['Q1', 'Q2', 'Q3']);
    // $a->setTerminals( ['a','b'] );
    // $a->setStackSymbols( ['Z','a','b'] );
    // $a->setStartState( 'Q1' );
    // $a->setStartSymbol( 'Z' );
    // $a->setAcceptableStates( ['Q3'] );
    // $a->setSearchWord('aaabbaaa');
    // $a->setDeltaFunction( [
    //     'Q1' => [
    //         [ 'a', 'Z', 'Q1', 'aZ' ],
    //         [ 'b', 'Z', 'Q1', 'aZ' ],
    //         [ 'a', 'a', 'Q1', 'aa' ],
    //         [ 'b', 'b', 'Q1', 'bb' ],
    //         [ 'b', 'a', 'Q1', 'ba' ],
    //         [ 'a', 'b', 'Q1', 'ab' ],
    //         [ '', 'Z', 'Q2', 'Z'],
    //         [ '', 'a', 'Q2', 'a'],
    //         [ '', 'b', 'Q2', 'b'],
    //     ],
    //     'Q2' => [
    //         [ 'a', 'a', 'Q2', '' ],
    //         [ 'b', 'b', 'Q2', '' ],
    //         [ '' , 'Z', 'Q3', 'Z']
    //     ],
    //     'Q3' => []
    //     // 'Q3' => [
    //     // ]
    // ]);

    // test case #3
    $a->setStates( ['Q1', 'Q2', 'Q3']);
    $a->setTerminals( ['a','b'] );
    $a->setStackSymbols( ['Z','a','b'] );
    $a->setStartState( 'Q1' );
    $a->setStartSymbol( 'Z' );
    $a->setAcceptableStates( ['Q3'] );
    $a->setSearchWord('abba');
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
    var_dump( $e->getMessage() );
}


var_dump( $a->status() );
