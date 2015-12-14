<?php
    //Run: php script.php csv_file.csv json_file.json xml_file.xml   

    define('CSV_FILE', $argv[1]);
    define('JSON_FILE', $argv[2]);
    define('XML_FILE', $argv[3]);
    define('ARRAY_SIZE', 26);    

    function generate($key, $value, $type){        
        if($type == 'json'){        
            $str = "\t{\n";
            for($i = 0; $i < ARRAY_SIZE; $i++){
                if($i != 25)
                    $str .= "\t\t\"".$key[$i]."\":\"".$value[$i]."\",\n";
                else
                    $str .= "\t\t\"".$key[$i]."\":\"".$value[$i]."\"\n";
            }
            if($i != 25)
                $str .= "\t},\n";
            else
                $str .= "\t}\n";
        }
        else if($type == 'xml'){
            $str = "\t<territory>\n";
            for($i = 0; $i < ARRAY_SIZE; $i++){
                $str .= "\t\t<".$key[$i].">".$value[$i]."</".$key[$i].">\n";
            }
            $str .= "\t</territory>\n";        
        }
        return $str;  
    }
    
    $handle = fopen(CSV_FILE, "r");
    $keys = array();    
    $firstly = true;

    $json = "{\n";
    $xml = "<?xml version=\"1.0\" charset=\"utf-8\"?>\n";

    $xml .= "<earth>\n";    

    if($handle != false){
            echo "Working... \n";
            while(($data = fgetcsv($handle, 0, ",")) != false){
                if($firstly){
                    $keys = $data;
                    $firstly = false;
                }
                else if(!$firstly){
                        $json .= generate($keys, $data, 'json');
                        $xml .= generate($keys, $data, 'xml');
                }            
            }

            $json .= "}";
            $xml .= '</earth>';                        

            file_put_contents(JSON_FILE, $json);
            file_put_contents(XML_FILE, $xml);
            echo "Complete \n";
    }
    fclose($handle);
