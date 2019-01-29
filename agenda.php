<?php
/*
 * public agenda .php
 *
 * Copyright 2019 SCHEINDORF HERLJOS <herljos@hyenetics.science>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 *
 *
 */

define("PASSWORD","PASSWORD") ;// mot de passe ajout evenements

class evenement {
    public $name;
    public $description;
    public $day;
    public $month;
    public $year;
    public $hour;
    public $minutes;
    public $lieu;
    public $contact;
    function __construct($day,$month,$year,$hour,$minutes,$name,$description,$lieu,$contact) {
        $this->name = $name;
        $this->description = $description;
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
        $this->hour = $hour;
        $this->minutes = $minutes;
        $this->lieu = $lieu;
        $this->contact = $contact;
    }
}

if (isset($_GET['newevent']) and $_GET['newevent'] == PASSWORD ) {
    $jours = '';
    for ($i = 1;$i <= 31;$i++) {
        $jours .= "<option>$i</option>";
    }
    $mois = '';
    for ($i = 1;$i <= 12;$i++) {
        $mois .= "<option>$i</option>";
    }
    $annee = '';
    for ($i = 2000;$i <= 2500;$i++) {
        $annee .= "<option>$i</option>";
    }
    $heure = '';
    for ($i = 0;$i <= 23;$i++) {
        $heure .= "<option>$i</option>";
    }
    $minute = '';
    for ($i = 0;$i <= 59;$i++) {
        $minute .= "<option>$i</option>";
    }
    $html = <<<EOT
    <h1>add new event</h1>
    <form name="addevent" id="addevent" action="./agenda.php" method="post">
        <fieldset id="date">
            <legend>Date evenement</legend>
            <label for="day">Jour:</label>
            <select id="day" name="day">
            $jours
            </select>
            <label for="month">Mois:</label>
            <select id="month" name="month">$mois</select>
            <label for="year">Année</label>
            <select id="year" name="year">$annee</select>
            <label for="hour">Heure :</label>
            <select id="hour" name="hour">
            $heure</select>
            :
            <select id="minutes" name="minutes">
            $minute</select>
        </fieldset>
        <fieldset id="eventdata">
            <legend>Description de l'evenement</legend>
            <label for="name">Nom :</label>
            <input type="text" value="" id="name" name="name"></input>
            <label for="place">Lieu :</label>
            <input type="text" value="" id="place" name="place"></input>
            <label for="contact">Referent contact :</label>
            <input type="text" value="" id="contact" name="contact"></input>
            <br/>
            <label for="description">Description :</label>
            <textarea id="description" name="description"></textarea>
        </fieldset>
        <fieldset>
            <legend>Envoyer</legend>
            <input type="hidden" value="addevent" id="action" name="action"></input>
            <input type="submit"></input>
        </fieldset>
    </form>
EOT;
    echo $html;
    exit();
}
//var_dump($_GET);
if (isset($_POST['action']) and $_POST['action'] =="addevent") {
    $evt = new evenement($_POST['day'],$_POST['month'],$_POST['year'],$_POST['hour'],$_POST['minutes'],$_POST['name'],$_POST['description'],$_POST['place'],$_POST['contact']);
    saveevent($evt);
    echo <<<EOF
    <p>Evenement normalement enregistré</p><br/>
    <a href="./agenda.php">Continuer</a>
EOF;
    exit();
}

$selday = false; $selmonth = false; $selyear = false;

//var_dump($_POST);
if (isset($_POST['action']) and $_POST['action'] =="selectdate") {
 $selday = isset($_POST['day']) ? $_POST['day'] : false;
 $selmonth = isset($_POST['month']) ? $_POST['month'] : false;
 $selyear = isset($_POST['year']) ? $_POST['year'] : false;
}
//var_dump($selday,$selmonth,$selyear);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <title>calendrier</title>
    <style>
    header {
        width: 100%;
        height: 100px;
        position: absolute;
        top: 0%;
        left: 0%;
        padding: 20px;
        margin: 5px;
        border-bottom-style:double;
        border-bottom-width:15px;
        border-bottom-color: black;
        border-top-style:double;
        border-top-width:15px;
        border-top-color: black;
    }
    section {
        width: 100%;
        float: left;
        min-height: 5%;
        max-height: 50%;
        margin-top: 10px;
        border-bottom-style:dotted;
        border-bottom-width:5px;
        border-bottom-color: black;

    }
    #today {
        margin-top: 200px;
    }
    .evenement {
        margin-botton: 5px;
        margin-top: 5px;
        float:left;
        background-color: rgb(127,127,127);
        font-size: 20pt;
        text-align: justify;
        border: inset 5px ;
        max-width: 50%;
        min-width: 10%;
        min-height: 100px;
        max-height: 500px;
        overflow: scroll;
    }
    .evenement p {
        font-size: 15pt;
        text-align: justify;
    }
    .floatleft {
        float: left;
        display: inline-block;
        margin-right: 30px;
    }
    .floatright {
        margin-left: 30px;
        float: right;
        display: inline-block;
    }
    h3 {
        margin: 0px;
        font-size: 30px;
        text-align: center;
    }
    h2 {
        margin: 0px;
        font-size: 25pt;
        text-align: center;
    }
    </style>
</head>

<body>
    <header>
        <h1>Online Public Agenda</h1>
        <p>de Scheindorf Herljos</p>
    </header>
<?php
    $logs = '';
    $date = @date('d n Y');
    list($day,$month,$year)  = explode(' ',$date);

     if (!($selday and $selmonth and $selyear)) {
     if (!$selday) $selday = $day;
     if (!$selmonth) $selmonth = $month;
     if (!$selyear) $selyear = $year;
    }
    //var_dump($_SERVER);

    function opensqlite() {
        global $logs;
        static $init = false;
        static $sql;
        if (!$init) {
            $path = $_SERVER["DOCUMENT_ROOT"] . '/agenda.sqlite';
            $sql = new SQLite3($path);
            $sql->enableExceptions(true);
            $logs .= "open $path\n";
            if ($sql->exec('create table if not exists evenements' .
                            '(day INTEGER,month integer,year integer,hour integer,minute integer,' .
                            'name text,desc text,place text,contact text)')) {
                                $logs .= "table evenements created if not exists \n";
                            } else {
                                throw new Exception('cant create table evenements');
                            }
            $init = true;
        }
        $logs .= "oppened sql";
        return $sql;
    }

    function dayevent($day,$month,$year) {
        global $logs;
        $return = Array();
        $sql = opensqlite();
        $stmt = 'select * from evenements where day=:d and month=:m and year=:y;';
        $query = $sql->prepare($stmt);
        $query->bindValue(':d',$day,SQLITE3_INTEGER);
        $query->bindValue(':m',$month,SQLITE3_INTEGER);
        $query->bindValue(':y',$year,SQLITE3_INTEGER);
        $result = $query->execute() ;
        //var_dump($day,$month,$year);
        if ($result != false) {
            while ($data = $result->fetchArray(SQLITE3_ASSOC)) {
                if ($data) {
                    $evt = new evenement($data['day'],$data['month'],$data["year"],
                                        $data['hour'],$data['minute'],
                                        $data['name'],$data['desc'],$data['place'],$data['contact']);
                    $return[] = $evt;
                }
            }
            $logs .= "selected date $day/$month/$year\n";
        } else {
            throw new Exception('cant select database');
        }
        return $return;
    }

    function monthevent($month,$year) {
        global $logs;
        $return = Array();
        $sql = opensqlite();
        $stmt = 'select * from evenements where month=:m and year=:y;';
        $query = $sql->prepare($stmt);
        $query->bindValue(':m',$month,SQLITE3_INTEGER);
        $query->bindValue(':y',$year,SQLITE3_INTEGER);
        $result = $query->execute() ;
        if ($result != false) {
            while ($data = $result->fetchArray(SQLITE3_ASSOC)) {
                if ($data) {
                    $evt = new evenement($data['day'],$data['month'],$data["year"],
                                        $data['hour'],$data['minute'],
                                        $data['name'],$data['desc'],$data['place'],$data['contact']);
                    $return[] = $evt;
                }
            }
            $logs .= "selected date $month/$year\n";
        } else {
            throw new Exception('cant select database');
        }
        return $return;
    }

    function saveevent(evenement $evt) {
        global $logs;
        $sql = opensqlite();
        $stmt = "insert into evenements (day,month,year,hour,minute,name,desc,place,contact) ";
        $stmt .= "VALUES (:d,:m,:y,:h,:min,:name,:desc,:place,:contact);";
        $query = $sql->prepare($stmt);
        $query->bindValue(':d',$evt->day,SQLITE3_INTEGER);
        $query->bindValue(':m',$evt->month,SQLITE3_INTEGER);
        $query->bindValue(':y',$evt->year,SQLITE3_INTEGER);
        $query->bindValue(':h',$evt->hour,SQLITE3_INTEGER);
        $query->bindValue(':min',$evt->minutes,SQLITE3_INTEGER);
        $query->bindValue(':name',$evt->name,SQLITE3_TEXT);
        $query->bindValue(':desc',$evt->description,SQLITE3_TEXT);
        $query->bindValue(':place',$evt->lieu,SQLITE3_TEXT);
        $query->bindValue(':contact',$evt->contact,SQLITE3_TEXT);
        $result = $query->execute();
        if ($result != false) {
            $logs .= "inserted event {$evt->name} {$evt->day}/{$evt->month}/{$evt->year} into database\n";
        } else {
            throw new Exception('failed to insert a row');
        }
        return true;
    }

    $todayevents = dayevent($day,$month,$year);
    if (count($todayevents) == 0) {
        $todayevents = "aucun evenements";
    } else {
        $str = ' : <br/><pre>';
        foreach ($todayevents as $key=>$value) {
            $str = $str . $value->name . " \n ";
        }
        $str = $str . "</pre><br/>";
        $todayevents = $str;
    }

    $monthevents = monthevent($month,$year);
    if (count($monthevents) == 0) {
        $monthevents = "aucun evenements";
    } else {
        $str = ' : <br/><pre>';
        foreach ($monthevents as $key=>$value) {
            $str = $str . $value->name . ' le ' . $value->day . '/' . $value->month . '/' . $value->year . " \n ";
        }
        $str = $str . "</pre><br/>";
        $monthevents = $str;
    }
    //mois suivant
    $nextmonthevents = monthevent(($month==12)?1:$month+1,$year);
    if (count($nextmonthevents) == 0) {
        $nextmonthevents = "aucun evenements";
    } else {
        $str = ' : <br/><pre>';
        foreach ($nextmonthevents as $key=>$value) {
            $str = $str . $value->name . ' le ' . $value->day . '/' . $value->month . '/' . $value->year . " \n ";
        }
        $str = $str . "</pre><br/>";
        $nextmonthevents = $str;
    }

$nbdays = 31;//cal_days_in_month(CAL_GREGORIAN,$selmonth,$selyear);

$dayopts = "";
for ($x = 1;$x < $nbdays;$x++) {
    $dayopts = $dayopts . "<option " . (($selday == $x) ? "selected" : "") . ">$x</option>";
}
$monthopts = "";
for ($x = 1;$x <= 12;$x++) {
    $monthopts = $monthopts . "<option " . (($selmonth == $x) ? "selected" : "") . ">$x</option>";
}
$yearopts = "";
for ($x = 2000;$x <= 2200;$x++) {
    $yearopts = $yearopts . "<option " . (($selyear == $x) ? "selected" : "") . ">$x</option>";
}

$dayresult = dayevent($selday,$selmonth,$selyear);
//var_dump($dayresult);
if (count($dayresult) == 0) {
    $dayresult = "aucun evenements ce jour ci";
} else {
    $str = '';
    foreach ($dayresult as $key=>$value) {
        $str = $str . '<div class="evenement"><h2>' ;
        $str = $str . $value->name . "</h2>";
        $str = $str . "<h3>le {$value->day}/{$value->month}/{$value->year}</h3>";
        $str = $str . '<p>' . $value->description . '</p>';
        $str = $str . '<p class="floatleft">A ' . $value->lieu . " /\/\/\ Contact: " . $value->contact . '</p>';
        $str = $str . '<p class="floatright">Heure: ' . $value->hour ;
        $str = $str . ':' . $value->minutes . '</p></div>';
    }
    $dayresult = $str;
}

    echo <<<EOT
<section id="today"><h2>Aujourd'hui le $day/$month/$year</h2>
        <h3>est prévu $todayevents</h3>
</section>
<section id="thismonth">
    <h3>Ce mois ci :</h3>
    $monthevents
</section>
<section>
    <h4>le mois prochain :</h4>
    $nextmonthevents
</section>
<section id="calendar">
<form id="dateselect" name="dateselect" method="post" action="./agenda.php">
<label for="jour">Jour :</label>
<select id="jour" name="day">
    $dayopts
</select>
<label for="mois"> mois :</label>
<select id="mois" name="month">
    $monthopts
</select>
<label for="annee"> année : </label>
<select id="annee" name="year">
    $yearopts
</select>
<input type="hidden" name="action" value="selectdate"></input>
<input type="submit" name="submit" id="submit" value="go"></input>
</form>
</section>
<section id="showtime">
    $dayresult
</section>
EOT;
?>

<?php
    //saveevent(new evenement(15,1,2019,8,30,'lever du soleil','le soleil commence a apparaitre','paris','observatoire meteo'));
    echo '<pre>'.$logs.'</pre>';

?>
</body>

</html>
