<?php
    require_once( "./src/DBFTools.php" );

    set_time_limit( 24192000 );
    ini_set( 'memory_limit', '-1' );

    system("clear") ;
    echo "\t-----------------------------" ;
    echo "\n\t   Conversion de DBF a CSV" ;
    echo "\n\t-----------------------------" ;
    echo "\n" ;


    (new DBFTools( './files/dbf' , './files/csv' ) )->run() ;

?>

