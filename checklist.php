<?php

/*
 * Copyright 2017 binary gamura.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

$classLoader = require_once './vendor/autoload.php';
$classLoader->add('findus', "./classes");

use \RedBeanPHP\R;

//include the global config.
require_once './config/config.php';
require './config/custom_config.php';

//merge your custom config with the global one.
$config = array_replace($config, $customConfig);

class PhpVersionCheck extends Check {
    public function __construct() {
        parent::__construct("PHP Version", "Prüfung ob die vorhandene PHP-Version den Mindestanforderungen genügt.");
        $this->critical = true;
    }
    
    public function check() {
        $minVersion = "5.2.0";
        if (version_compare(phpversion(), $minVersion, "<")) {
            return new CheckResult(false, "Die PHP-Version ist nicht kompatibel mit Findus. Bitte aktualisieren Sie bitte mind. auf Version \"".$minVersion."\".");
        }
        return new CheckResult(true);
    }
}

class LibsExistCheck extends Check {
    
    public function __construct() {
        parent::__construct("Libs vorhanden", "Prüft ob die Libs (siehe composer.json) vorhanden sind.");
        $this->critical = true;
    }
    
    public function check() {
        if(!is_dir("vendor")){
            return new CheckResult(false, "Scheinbar sind die notwendigen Libs nicht vorhanden. Bitte <i>composer install</i> ausführen oder manuell die Libs kopieren.");
        }
        return new CheckResult(true);
    }
}

class CompileDirCheck extends Check {

    public function __construct() {
        parent::__construct("Compile Verzeichnis", "Verzeichnis in dem die kompilierten Templates liegen.");
    }

    public function check() {
        global $config;
        $result = new CheckResult();
        $result->setSuccessful(true);
        $templateDir = $config['templating']['compileDir'];
        if(!is_dir($templateDir)){
            $result->setSuccessful(false);
            $result->setMessage("Das Compile-Verzeichnis \"".$templateDir."\" ist nicht vorhanden. Bitte legen Sie dieses selbst an.");
        }
        else {
            if(!is_writable($templateDir)){
                $result->setSuccessful(false);
                $result->setMessage("Das Compile-Verzeichnis muss mit den Rechten des Webservers beschreibbar sein.");
            }
        }
        return $result;
    }
}

class DatabaseCheck extends Check{
    
    function __construct() {
        parent::__construct("Verbindung zur Datenbank", "Ablageort für alle Daten der Anwendung.");
    }
    
    public function check() {
        global $config;
        R::setup($config['database']['dsn'], $config['database']['username'], $config['database']['password']);
        if(!R::testConnection()){
            return new CheckResult(false, "Die Verbindung zur Datenbank konnte nicht hergestellt werden.");
        }
        return new CheckResult(true);
    }

}

class PortraitDirCheck extends Check {

    public function __construct() {
        parent::__construct("Portrait Verzeichnis", "Ablageort für Portraitbilder der Tiere.");
    }

    public function check() {
        $result = new CheckResult();
        $result->setSuccessful(true);
        $portraitDir = "./images/portraits";
        if(!is_dir($portraitDir)){
            $result->setSuccessful(false);
            $result->setMessage("Das Portrait-Verzeichnis \"".$portraitDir."\" ist nicht vorhanden. Bitte legen Sie dieses selbst an.");
        }
        else {
            if(!is_writable($portraitDir)){
                $result->setSuccessful(false);
                $result->setMessage("Das Portrait-Verzeichnis muss mit den Rechten des Webservers beschreibbar sein.");
            }
        }
        return $result;
    }
}

abstract class Check {
    
    private $name;
    
    private $description;
    
    protected $critical = false;

    public function __construct($name, $description) {
        $this->name = $name;
        $this->description = $description;
    }
    
    function isCritical() {
        return $this->critical;
    }

    public abstract function check();
    
    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }
}

class CheckResult {
    private $successful;
    
    private $message;
    
    public function __construct($successful = false, $message = ""){
        $this->successful = $successful;
        $this->message = $message;
    }
    
    function isSuccessful() {
        return $this->successful;
    }

    function getMessage() {
        return $this->message;
    }

    function setSuccessful($successful) {
        $this->successful = $successful;
    }

    function setMessage($message) {
        $this->message = $message;
    }
}

?>
<html>
    <head>
        <title>Installer</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    </head>
    <body>
        <h1>Checkliste</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Beschreibung</th>
                    <th>Status</th>
                    <th>Fehlermeldung</th>
                </tr>
            </thead>
            <tbody>
<?php

$checks = [
    new PhpVersionCheck(),
    new LibsExistCheck(),
    new CompileDirCheck(),
    new DatabaseCheck(),
    new PortraitDirCheck()];
foreach($checks as $check){
    $result = $check->check();
    echo("<tr>
            <td><img src=\"images/".($result->isSuccessful() ? "accept_button.png" : "cancel.png")."\"/></td>
            <td>".$check->getName()."</td>
            <td>".$check->getDescription()."</td>
            <td>".($result->isSuccessful() ? "" : $result->getMessage())."</td>
          </tr>");
    if(!$result->isSuccessful() && $check->isCritical()){
        break;
    }
}
?>
            </tbody>
        </table>
    </body>
</html>



