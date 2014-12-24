<?php

/**
 * Creating Stack automata
 *
 * First starting, by creating simple automata
 * Seconds - automata created, proceed with magazine
 */

class Automata {

    private $states            = [];
    private $terminals         = [];
    private $stack_symbols     = [];
    private $start_state       = ''; // probably name, probably index
    private $start_symbol      = '';
    private $acceptable_states = [];
    private $search_word       = '';
    private $delta_function    = '';
    private $current_state     = '';

    private $emptity_symbol = 'e';
    private $found          = false;

    function __construct() {
        return;
    }

    public function setStates( array $states ) {
        $this->states = $states;
    }
    public function setTerminals( array $terminals ) {
        $this->terminals = $terminals;
    }
    public function setStackSymbols( array $stack_symbols ) {
        $this->stack_symbols = $stack_symbols;
    }
    public function setStartState( $start_state = '') {
        if( !in_array( $start_state, $this->states ) ) throw new Exception( "Incorrect start state" );
        $this->start_state = $start_state;
    }
    public function setStartSymbol( $start_symbol = '') {
        if( !in_array( $start_symbol, $this->stack_symbols ) ) throw new Exception( "Incorrect stack start symbol" );
        $this->start_symbol  = $start_symbol;
    }
    public function setAcceptableStates( array $acceptable_states ) {
        $this->acceptable_states = $acceptable_states;
    }
    public function setSearchWord( $search_word = '' ) {
        if( strlen(str_replace( $this->terminals, '', $search_word ) ) > 0) throw new Exception( "Word has incorrect terminals");
        $this->search_word = $search_word;
    }
    public function setDeltaFunction( array $delta_function ) {
        $this->delta_function = $delta_function;
    }
    public function getSearchWord() {
        return $this->search_word;
    }
    public function status() {
        return $this->found;
    }

    public function start() {
        if( empty( $this->start_state ) ) return;
        $this->checkWord( $this->search_word, $this->start_state, $this->start_symbol );
        return;
    }
    public function checkWord( $word = '', $current_state = '',  $stack = '' ) {

        var_dump($current_state);
        var_dump($stack);
        var_dump($word);
        echo "<br/>";
        $letter       = !empty($word) ? $word[0] : '';
        $word_left    = substr($word, 1); // vārds, vai false... attiecīgi false būs empty vārds, utt.

        $stack_letter = !empty($stack) ? $stack[0] : '';
        $stack_left   = ( substr($stack, 1) === false ) ? '' : substr( $stack, 1);

        //epsilon parejas
        foreach( $this->delta_function[ $current_state ] as $df ) {
            if( empty( $df[0] ) and $stack_letter == $df[1] ) {
                $this->checkWord( $letter.$word_left, $df[2], $df[3].$stack_left);
            }
        }
        // ja vārds ir tukšš un esam akceptējošā stāvoklī
        if( empty( $word ) ) {
            if( in_array( $current_state, $this->acceptable_states ) ) {
                $this->found = true;
                return;
            }
            // no else, vienkārši vārds nepieder.., metam nost.
            return;
        }

        // te vajag epsilon pārjeas izpildīt.


        // iegūstam apstrādājamo symbolu
        // padotais stāvoklis nav pieejamajos
        if( !is_array( $this->delta_function[ $current_state ] ) ) {
            return;
        }

        // pārejas funkcija, neņem vērā stāvokļus, nav īsti vajadzīga
        foreach( $this->delta_function[ $current_state ] as $df) {
            if( $df[0] == $letter and $df[1] == $stack_letter) {
                $this->checkWord( $word_left, $df[2], $df[3].$stack_left );
            }
        }

        // var_dump($current_state);
        // var_dump($stack_letter);
        // echo "<br/>";
        // do the epsilon goes
        return;
    }


}


try {

    $a = new Automata();
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

    /*
    // test case #
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
    */
    $a->start();

} catch ( Exception $e ) {
    var_dump( $e->getMessage() );
}


var_dump( $a->status() );
