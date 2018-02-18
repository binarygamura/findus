<?php

namespace findus\controller;

use \RedBeanPHP\R;

    Const SPINNER_TIME = 3;
    Const SPINNER_DAYS = 30;
    Const SPINNER_MIN = 3;
    Const SPINNER_MAX = 20;

    
/**
 * Description of ConfigurationController
 *
 * @author tierhilfe
 */
class ConfigurationController {
    
        
    public static function getConfiguration(){
        $configuration = R::findOne('configuration', 'id = 1');
        if (!$configuration) {
            $defaultConfiguration = R::dispense('configuration');
            // Spinner: Anzeigedauer eines Fotos in sec
            $defaultConfiguration['spinnerTime']=SPINNER_TIME;
            // Spinner: Anzahl der Tage für die Tiersuche (Eingangsdatum)
            $defaultConfiguration['spinnerDays']=SPINNER_DAYS;
            // Spinner: Minimale Anzahl der Fotos 
            //          auch wenn im Zeitraum weniger da waren
            //          0 heißt, dann nur die im Zeitraum liegenden Fotos
            $defaultConfiguration['spinnerMin']=SPINNER_MIN;
            // Spinner: Maximale Anzahl der Fotos 
            //          auch wenn im Zeitraum mehr da waren
            //          0 heißt unendlich
            $defaultConfiguration['spinnerMax']=SPINNER_MAX;

            // Zeilen im Kontakt-Bereich
            $defaultConfiguration['contactLine1']="Zeile Verein";
            $defaultConfiguration['contactLine2']="Zeile Straße";
            $defaultConfiguration['contactLine3']="Zeile Ort";
            $defaultConfiguration['contactLine4']="Zeile Homepage";
            $defaultConfiguration['contactLine5']="Zeile Mail";

            R::store($defaultConfiguration);
        }
            
        return R::findOne('configuration', 'id = 1');
    }
    
    public static function updateConfiguration(array $configurationData){
        $spinnerTime=trim($configurationData['configuration_spinnerTime']);
        if (!$spinnerTime){
            $spinnerTime=SPINNER_TIME;
        }
        $spinnerDays=trim($configurationData['configuration_spinnerDays']);
        if (!$spinnerDays){
            $spinnerDays=SPINNER_DAYS;
        }
        $spinnerMin=trim($configurationData['configuration_spinnerMin']);
        if (!$spinnerMin){
            $spinnerMin=SPINNER_MIN;
        }
        $spinnerMax=trim($configurationData['configuration_spinnerMax']);
        if (!$spinnerMax){
            $spinnerMax=SPINNER_MAX;
        }
        
        $configuration = R::findOne('configuration', 'id = 1');
        if(!$configuration){
            throw new ControllerException("Keine Konfiguration gefunden.");
        }

        $configuration['spinnerTime'] = $spinnerTime;
        $configuration['spinnerDays'] = $spinnerDays;
        $configuration['spinnerMin'] = $spinnerMin;
        $configuration['spinnerMax'] = $spinnerMax;
        $configuration['contactLine1'] = $configurationData['configuration_contactLine1'];
        $configuration['contactLine2'] = $configurationData['configuration_contactLine2'];
        $configuration['contactLine3'] = $configurationData['configuration_contactLine3'];
        $configuration['contactLine4'] = $configurationData['configuration_contactLine4'];
        $configuration['contactLine5'] = $configurationData['configuration_contactLine5'];

        R::store($configuration);
    } 
    
}
