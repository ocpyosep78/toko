<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_column_names($table_name){
    $query="SHOW COLUMNS FROM {$table_name}";
    if(($result=mysql_query($query))){
        /* Store the column names retrieved in an array */
        $column_names=array();
        while($row=mysql_fetch_array($result)){
            $column_names[] = $row['Field'];
        }
        return $column_names;
    }
    else
        return 0;
}

function create_statement($table_name, array $exclude  ) //array
{
    /* $exclude contains the columns we do not want */
    $column_names = get_column_names($table_name);
    $statement="";
    foreach($column_names as $name) {
        
        if(!in_array($name, $exclude)) {
            if($statement == "")
                $statement = $name;
            else
                $statement .= "," . $name;
        }
    }
    return $statement;
}

function seoUrl($string) {
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}
?>