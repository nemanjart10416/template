<?php
ini_set('session.cookie_httponly', 1);  //The 'httpOnly' flag
session_name('__Secure-PHPSESSID'); //cookies that have the __Secure- prefix:
session_start(['cookie_lifetime' => 43200, 'cookie_secure' => true, 'cookie_httponly' => true, 'cookie_samesite' => "Strict"]); //session

include_once("classes/load.php");
include_once("errors.php");
include_once("headers.php");
include_once("templates/templates.php");

$db_servername= "localhost";
$db_username = "root";
$db_password = "";
$db_database = "0_taxi_database";

if(false){
    //server database
    $db_servername = "localhost";
    $db_username = "privatnirs_0_taxi";
    $db_password = "29C_P?-?35yq5TL82Bg^(\:(\@AFJHbb";
    $db_database = "privatnirs_0_taxi_database";
}

function konekcija_prepared(){
    global $db_username, $db_servername, $db_password, $db_database;

    $dbh = new PDO('mysql:host='.$db_servername.';dbname='.$db_database.";charset=utf8mb4", $db_username, $db_password);
    /**
     * Use PDO::ERRMODE_EXCEPTION, to capture errors and write them to
     * a log file for later inspection instead of printing them to the screen.
     */
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $dbh;
}

function konekcija(){
    global $db_username, $db_servername, $db_password, $db_database;

    // Create connection
    $conn = new mysqli($db_servername, $db_username, $db_password, $db_database);
    $conn->set_charset("utf8");
    // Check connection
    if ($conn->connect_error) {
        //die("Connection failed: " . $conn->connect_error);
        die("Connection error");
    }


    return $conn;
}

function access_logs(){
    $konekcija = konekcija();
    $val = $konekcija->query("SELECT * FROM website_access");
    if($val===false){
        set("
            CREATE TABLE `website_access` (
              `access_id` int PRIMARY KEY AUTO_INCREMENT,
              `access_ip` varchar(90) NOT NULL,
              `access_time` timestamp NOT NULL DEFAULT current_timestamp(),
              `access_page` varchar(200) DEFAULT NULL
            );
        ");
    }

    /*id,ip,date and time,page*/
    $ip = $_SERVER['REMOTE_ADDR'];
    $page = basename($_SERVER['PHP_SELF']);

    if($page=="ajax.php"){
        return;
    }

    $access = new Access_logs(NULL, $ip, "", $page);
    $access->add();
}

function database_backup(){
    $tables = '*';

    try{
        $link = konekcija();

        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit;
        }

        mysqli_query($link, "SET NAMES 'utf8'");

        //get all of the tables
        if($tables == '*')
        {
            $tables = array();
            $result = mysqli_query($link, 'SHOW TABLES');
            while($row = mysqli_fetch_row($result))
            {
                $tables[] = $row[0];
            }
        }
        else
        {
            $tables = is_array($tables) ? $tables : explode(',',$tables);
        }

        $return = '';
        //cycle through
        foreach($tables as $table)
        {
            $result = mysqli_query($link, 'SELECT * FROM '.$table);
            $num_fields = mysqli_num_fields($result);
            $num_rows = mysqli_num_rows($result);

            $return.= 'DROP TABLE IF EXISTS '.$table.';';
            $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table));
            $return.= "\n\n".$row2[1].";\n\n";
            $counter = 1;

            //Over tables
            for ($i = 0; $i < $num_fields; $i++)
            {   //Over rows
                while($row = mysqli_fetch_row($result))
                {
                    if($counter == 1){
                        $return.= 'INSERT INTO '.$table.' VALUES(';
                    } else{
                        $return.= '(';
                    }

                    //Over fields
                    for($j=0; $j<$num_fields; $j++)
                    {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = str_replace("\n","\\n",$row[$j]);
                        if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                        if ($j<($num_fields-1)) { $return.= ','; }
                    }

                    if($num_rows == $counter){
                        $return.= ");\n";
                    } else{
                        $return.= "),\n";
                    }
                    ++$counter;
                }
            }
            $return.="\n\n\n";
        }

        //save file
        $fileName = 'db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql';

        $handle = fopen($fileName,'w+');
        fwrite($handle,$return);
        if(fclose($handle)){
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($fileName));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileName));
            ob_clean();
            flush();
            readfile($fileName);
            unlink($fileName);
            exit;
        }
    }catch(Exception $e){}
}

function error_login($err){
    //check if error_logs table exist
    $konekcija = konekcija();
    $val = $konekcija->query("SELECT * FROM error_logs");
    if($val===false){
        set("
            CREATE TABLE error_logs(
                error_logs_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                error_logs_date TIMESTAMP NOT NULL,
                error_logs_message VARCHAR(600) NOT NULL
            )
        ");
    }

    try{
        $konekcija_prepared = konekcija_prepared();
        $query = "INSERT INTO error_logs (error_logs_id,error_logs_date,error_logs_message) VALUES (NULL,:err_date,:message)";
        $sth = $konekcija_prepared->prepare($query);
        $date = date("Y/m/d h:i:sa");
        $sth->bindParam(':err_date', $date);
        $sth->bindParam(':message', $err);
        $sth->execute();
    }catch(PDOException $e){}
}

function get($sql){
    $conn = konekcija();
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

function set($sql){
    $conn = konekcija();
    $ans = $conn->query($sql);
    $conn->close();

    return $ans;
}

function sanitise($string) {
    //preg_replace('/[^a-zA-Z0-9]+/', '', $text)

    //Convert all applicable characters to HTML entities
    //identical to htmlspecialchars() in all ways, except with htmlentities(), all characters which have HTML character entity equivalents are translated into these entities
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function user_input($data) {
    //returns a string with whitespace stripped from the beginning and end of string
    $data = trim($data);

    //Strip HTML and PHP tags from a string. This function tries to return a string with all NULL bytes, HTML, and PHP tags stripped from a given string
    $data = strip_tags($data);

    //Convert special characters to HTML entities. This is one of the famous methods to prevent XSS
    $data = htmlspecialchars($data);

    //NULL byte %00
    $data = str_replace(chr(0), '', $data);
    $data = str_replace("%00", "", $data);
    $data = str_replace("%0", "", $data);
    $data = str_replace("\0", "", $data);

    return $data;
}

function generate_csrf_token(){
    $_SESSION["csrf_token"] = md5(uniqid(mt_rand(), true));
}

function get_csrf_token(){
    return $_SESSION["csrf_token"];
}

function check_current($curr){
    $page = ucfirst(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME));
    $page = strtolower($page);

    if($page==$curr){
        echo "active";
    }
}

function success($txt){
    return '<div class="alert alert-success alert-dismissible fade show" role="alert">
              '.$txt.'
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
}

function danger($txt){
    return '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              '.$txt.'
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
}

function warning($txt){
    return '<div class="alert alert-warning alert-dismissible fade show" role="alert">
              '.$txt.'
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
}

function nazad($s){
    return $s." <a href='javascript:history.back()'>nazad</a>";
}

function send_mail($naslov, $poruka){
    $to = "miroslavpavlovic21@gmail.com";

    $header = "<From:kontakt@registracija-svih-vozila.rs> \r\n";
    $header .= "<Cc:kontakt@registracija-svih-vozila.rs> \r\n";
    $header .= "X-Sender: testsite <mail@testsite.com>\n";
    $header .= 'X-Mailer: PHP/' . phpversion();
    $header .= "X-Priority: 1\n"; // Urgent message!
    $header .= "Return-Path: mail@testsite.com\n"; // Return path for errors
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    $retval = mail ($to,$naslov,$poruka,$header);

    if( $retval == true ) {
        return false;
    }else {
        return false;
    }
}

//opensssl_encrypt i decript
//id je sifrovan pre prikaza
function encrypt($text)
{
    $secret_key = 'CC6pxqR1nXZ213sk6Y4R';
    $key = hash('sha256', $secret_key);
    return openssl_encrypt($text, "AES-256-CBC", $key);
}

function decrypt($text)
{
    $secret_key = 'CC6pxqR1nXZ213sk6Y4R';
    $key = hash('sha256', $secret_key);

    return openssl_decrypt($text, "AES-256-CBC", $key);
}

function logout(){
    $params = session_get_cookie_params();
    setcookie(session_name(), '', 0, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));
    session_unset();
    session_destroy();
    session_write_close();
}

?>