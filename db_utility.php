<?php

session_start();
include('system/config.php');
include('system/db_connect.php');

$baseurl  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$baseurl .= $_SERVER['SERVER_NAME'];
if (strpos($baseurl, 'localhost') !== false) {
    $baseurl .= ":".$_SERVER['SERVER_PORT'];
}
//$baseurl .= htmlspecialchars($_SERVER['REQUEST_URI']);
$cleanuri = explode('?', $_SERVER['REQUEST_URI'], 2);
$baseurl .= htmlspecialchars($cleanuri[0]);

try{

    //postgres for prod
    $db = new PDO($dsn);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //delete tool
    //$deleteid = [val];
    //$db->exec("DELETE FROM tablname WHERE colname = value");

    //table create tool
    // $db->exec("CREATE TABLE IF NOT EXISTS users (email TEXT PRIMARY KEY, password TEXT, fname TEXT, lname TEXT)");

    //add row tool
    // $input_email = "email@email.com";
    // $input_password = "password";
    // $password_store = password_hash($input_password, PASSWORD_BCRYPT);
    // $input_fname = "Firsty";
    // $input_lname = "Lasterson";

    //FYI $checkpass = password_verify($inputpass, $storedpass) yields t or f for pw check

    // $insert = $db->prepare("INSERT INTO users (email, password, fname, lname) VALUES (?, ?, ?, ?)");
    // $insertarray = array($input_email, $password_store, $input_fname, $input_lname);
    // $insert->execute($insertarray); 

    //update row tool
    // $update = $db->prepare("UPDATE tablename SET colname = :inputbind, anothercol = :secondbind WHERE uid = $uid");
    // $update->bindParam(':inputbind', $newinput, PDO::PARAM_STR);
    // $update->bindParam(':secondbind', $secondinput, PDO::PARAM_STR);
    // $update->execute();

    //add a column
    //$db->exec("ALTER TABLE tablename ADD COLUMN colname TEXT");

    //table delete tool
    $db->exec("DROP TABLE budget6");

    //row delete tool
    //$db->exec("DELETE FROM budgets WHERE autorefill = 0");


    //queries
    // get all tables
    $tables = $db->query("SELECT * FROM sqlite_master where type='table';");

    // loop through all tables and create individual queries
    foreach ($tables as $table) {
        $tablename = $table['name'];
        $tablequery = $tablename . "query";
        $$tablequery = $db->query("SELECT * FROM $tablename");
        $tablearray[$tablename] = $tablequery;
    }

    //$users = $db->query("SELECT * FROM users");

    // close the database connection
    $db = NULL;
}
catch(PDOException $e){
    $statusMessage = $e->getMessage();
    $statusType = "danger";
}

?>

<?php include('views/header.php'); ?>

<div class="container utility">
    <div class="row">
        <div class="col-xs-12" style="margin-top: 24px;">

            <?php
                if (!empty($statusMessage)){
                    echo "<div id='' class='alert alert-" . $statusType . " notif-alert' role='alert'>". $statusMessage . "</div>";
                }
            ?>

            <h1>TABLES</h1>

            <? foreach ($tablearray as $tablename => $tablequery): ?>
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading"><?php echo $tablename; ?></div>
                <!-- Table -->
                <table class="table table-striped">

                <?php
                    $firstrow = true;
                    $tablerows = $$tablequery->fetchAll(PDO::FETCH_ASSOC);
                    foreach($tablerows as $tablerow){
                        if($firstrow){
                            foreach($tablerow as $columnvalue => $cellvalue){
                                $columns[] = $columnvalue;
                                $cellvalues[] = $cellvalue;
                            }
                            echo "<thead><tr>";
                            foreach($columns as $column){
                                echo "<th>" . $column . "</th>";
                            }
                            echo "</tr></thead><tbody>";
                            echo "<tr>";
                            foreach($cellvalues as $cellvalue){
                                echo "<td>" . $cellvalue . "</td>";
                            }
                            echo "</tr>";
                        }
                        else{
                            echo "<tr>";
                            foreach($tablerow as $column => $cellvalue){
                                echo "<td>" . $cellvalue . "</td>";
                            }
                            echo "</tr>";
                        }
                        $firstrow = false;
                        unset($columns);
                        unset($cellvalues);
                    }
                ?>
                    </tbody>
                </table>
            </div>
            <? endforeach; ?>

        </div>
    </div>
</div>

<?php include('views/ender.php'); ?>