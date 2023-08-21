<?php

set_time_limit( 24192000 );
ini_set( 'memory_limit', '-1' );

system("clear") ;
echo "\t-----------------------------" ;
echo "\n\t   Conversion de DBF a CSV" ;
echo "\n\t-----------------------------" ;
echo "\n" ;


class DBFTools {
    private string $inputFolder ; 
    private string $outputFolder;
    public function __construct( $inputFolder , $outputFolder ) {
        $this->inputFolder = $inputFolder ; 
        $this->outputFolder = $outputFolder ; 
        self::check() ; 
    }

    public static function check() {
     
        if( ! function_exists( "dbase_open" ) ) { 
            throw new Exception("No soporta librerias DBASE para php");
        }
    }


    private function convert( $dbfFile, $csvFile ) {

        try {


            echo "\n\n\t\t************************************************************************";
            echo "\n\t\t  Procesando: $dbfFile  --- > $csvFile \n";

            if( !$dbf = dbase_open( $dbfFile, 0 ) ) die( "Could not connect to: $dbfFile" );
            $num_rec = dbase_numrecords( $dbf );
            $num_fields = dbase_numfields( $dbf );
    
            echo "\n\t\t dbase_numrecords : " . $num_rec; 
            echo "\n\t\t dbase_numfields : " . $num_fields; 

            $fields = array();
            $out = '';

            $start = true ;

            for( $i = 1; $i <= $num_rec; $i++ )
            {
                $row = dbase_get_record_with_names( $dbf, $i );
                if( $row !== false ) {
                    $firstKey = key( array_slice( $row, 0, 1, true ) );

                    if( $start ) {
                        foreach( $row as $key => $val )
                        {
                            if( $firstKey != $key ) $out .= ';';
                            $out .= trim( $key );
                        }
                        $out .= "\n";
    
                        $start = false ;
                    }
                    foreach( $row as $key => $val )
                    {
                        if( $firstKey != $key ) $out .= ';';
                        $out .= trim( $val );
                    }
                    $out .= "\n";

                }
            }
   
            file_put_contents( $csvFile, $out );
    
        }
        catch(Exception $e ) {
            echo $e->getMessage() ; 
        }


    }


    public function run() {



        $files = glob( "{$this->inputFolder}/*.DBF" );

        // var_dump( $files ) ;
        foreach( $files as $dbfFile )
        {
        
            $fileParts = explode( '/', $dbfFile );
            $endPart = $fileParts[key( array_slice( $fileParts, -1, 1, true ) )];

            $csvFileName = preg_replace( '~\.[a-z]+$~i', '.CSV', $endPart ) ;

            $csvFile = "{$this->outputFolder}/{$csvFileName}" ;

            //  echo "\n\t\tProcesando: $endPart  --- > $csvFileName \n";

            $this->convert( $dbfFile, $csvFile ) ; 

        }

    }
}

$t = new DBFTools( './files/dbf' , './files/csv' ) ;
$t->run();

?>

