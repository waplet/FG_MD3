<?php
require_once("../Pushdown_Automata.php");
// lets read file and prepare
// read word from an input
$search_word = isset($argv) ? $argv[1] : (isset($_GET["word"]) ? $_GET["word"] : '');

$file = @file('file.txt', FILE_IGNORE_NEW_LINES);
// echo "<pre>";
// var_dump($file);

if( !$file) die("Could not read file");

// lets assume file is always correct
$states = explode( " ", array_shift( $file ) );
$delta_function = [];
foreach($states as $s) {
    $delta_function[ $s ] = [];
}
$terminals = explode( " ", array_shift( $file ) );
$stack_symbols = explode( " ", array_shift( $file ) );
$start_state = array_shift( $file );
$start_symbol = array_shift( $file );
$acceptable_states = explode( " ", array_shift( $file ) );

while( !empty( $file ) ) {
    $transition = explode( " " , array_shift( $file ) );
    if(isset( $delta_function[ $transition[0] ] ) ) {
        // viss kārtībā pievienojam delta funkcija pārejas.
        $delta_function[ $transition[0] ][] = [
            // str_replace .... - is replace for epsilon transitions, so its empty string
            $transition[1],
            str_replace('e','', $transition[2]),
            $transition[3] ,
            str_replace('e','', $transition[4])
        ];
    }
}
// var_dump($acceptable_states);
// echo "<pre>";
// var_dump($delta_function);

$a = new Pushdown_Automata();
try {
    $a->setStates( $states );
    $a->setTerminals( $terminals );
    $a->setStackSymbols( $stack_symbols );
    $a->setStartState( $start_state );
    $a->setStartSymbol( $start_symbol );
    $a->setAcceptableStates( $acceptable_states );
    $a->setDeltaFunction( $delta_function );
    $a->setSearchWord( $search_word );

    $a->start(); //starts checking acceptance of word
} catch ( Exception $e ) {
    echo $e->getMessage();die;
}

echo "Word: " . $a->getSearchWord()."<br/>";
echo $a->status() ? "Accepted" : "Not Accepted";
