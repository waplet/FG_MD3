<?php

/**
 * Pushdown Automata
 * Author: Māris Jankovskis, mj12015
 */

class Pushdown_Automata {

    private $states            = [];
    private $terminals         = [];
    private $stack_symbols     = [];
    private $start_state       = '';
    private $start_symbol      = '';
    private $acceptable_states = [];
    private $search_word       = '';
    private $delta_function    = '';
    private $current_state     = '';
    private $found             = false;

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
        /**
         * The keys of delta function are states
         * Each state can have several transitions
         * Each transition has 4 keys [0..3]
         * 0 - read symbol (can be empty)
         * 1 - read stack symbol (can be empty)
         * 2 - upcoming state
         * 3 - stack replacement (can be empty)
         * see examples
         */
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

        // var_dump($current_state);
        // var_dump($stack);
        // var_dump($word);
        // echo "<br/>";
        // iegūstam apstrādājamo symbolu
        $letter       = !empty($word) ? $word[0] : '';
        $word_left    = substr($word, 1); // vārds, vai false... attiecīgi false būs empty vārds, utt.

        $stack_letter = !empty($stack) ? $stack[0] : '';
        $stack_left   = ( substr($stack, 1) === false ) ? '' : substr( $stack, 1);

        //epsilon pārejas
        foreach( $this->delta_function[ $current_state ] as $df ) {
            if( empty( $df[0] ) and $stack_letter == $df[1] ) {
                //  konfiguracija, kur pirmais ir epsilons - ('', '...' ) / '..'
                //var_dump( $df[3] );die;
                $this->checkWord( $word, $df[2], $df[3].$stack_left);
            } else if( empty( $df[0] ) and empty( $df[1] ) ) {
                // konfiguracija, kur abi ir epsiloni -  ('', '' ) / '..'.esošais stacks.
                $this->checkWord( $word, $df[2], $df[3].$stack );
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



        // padotais stāvoklis nav pieejamajos
        if( !is_array( $this->delta_function[ $current_state ] ) ) {
            return;
        }

        // pārejas funkcija, neņem vērā stāvokļus, nav īsti vajadzīga
        foreach( $this->delta_function[ $current_state ] as $df) {
            if( $df[0] == $letter and $df[1] == $stack_letter) {
                // parastā pāreja, kad nolasa gan steku, gan vārdu
                $this->checkWord( $word_left, $df[2], $df[3].$stack_left );
            } else if( $df[0] == $letter and empty( $df[1] ) ) {
                // pāreja, kad no steka neko neizņem un neieliek
                $this->checkWord( $word_left, $df[2], $df[3].$stack );
            }
        }

        // var_dump($current_state);
        // var_dump($stack_letter);
        // echo "<br/>";
        return;
    }
}