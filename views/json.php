<?php
trait output_json
{
    function output_json($data)
    {
        $output = json_encode($data);
        header('Content-Type: application/json');
        echo($output);
    }
}
?>