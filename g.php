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
        $this->checkWord( $this->search_word, $this->start_state, $this->start_symbol );
        return;
    }
    public function checkWord( $word = '', $current_state = '',  $stack = '' ) {

        // ja vārds ir tukšš un esam akceptējošā stāvoklī
        if( empty( $word ) ) {
            if( in_array( $current_state, $this->acceptable_states ) ) {
                $this->found = true;
                return;
            }
            // no else, vienkārši vārds nepieder.., metam nost.
            return;
        }

        // iegūstam apstrādājamo symbolu
        $letter = $word[0];
        $word_left = substr($word, 1); // vārds, vai false... attiecīgi false būs empty vārds, utt.

        // padotais stāvoklis nav pieejamajos
        if( !is_array( $this->delta_function[ $current_state ] ) ) {
            return;
        }

        // pārejas funkcija, neņem vērā stāvokļus, nav īsti vajadzīga
        foreach( $this->delta_function[ $current_state ] as $df) {
            if( $df[0] == $letter ) {
                $this->checkWord( $word_left, $df[1], '');
            }
        }
        return;
    }


}


try {

    $a = new Automata();
    $a->setStates( ['Q1', 'Q2']);
    $a->setTerminals( ['a','b'] ); // termināļi
    // stack alphabet
    $a->setStartState('Q1');
    // stack start
    $a->setAcceptableStates( ['Q2'] );
    $a->setSearchWord('cb');
    $a->setDeltaFunction( [
        'Q1' => [
            ['a', 'Q2']
        ],
        'Q2' => [
            ['b', 'Q2']
        ]
    ]);

    $a->start();

} catch ( Exception $e ) {
    var_dump( $e->getMessage() );
}


var_dump( $a->status() );
