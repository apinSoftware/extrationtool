<?php

include('ndrfactory/individualReport.php');

class NDRConverter {

    public static function createContainer($pts, $facility, $connection) {

        try {

            ob_start();

            /*             * * a new dom object ** */
            $dom = new domDocument;
            //$dom = new DOMDocument('1.0','utf-8');

            /*             * * make the output tidy ** */
            $dom->formatOutput = true;

            /*             * * create the root element ** */
            $root = $dom->appendChild($dom->createElement("Container"));

            /*             * * create the simple xml element ** */
            $Container = simplexml_import_dom($dom);


            /*             * * add a MessageHeader element ** */
            $MessageHeader = $Container->addChild("MessageHeader");
            $MessageHeader->addChild("MessageStatusCode", "UPDATED");
            $MessageHeader->addChild("MessageCreationDateTime", date('Y-m-d\TH:i:s'));
            $MessageHeader->addChild("MessageSchemaVersion", "1.2");
            $MessageHeader->addChild("MessageUniqueID", date('YmdHis'));

            /*** add a MessageSendingOrganization element ** */
            $MessageSendingOrganization = $MessageHeader->addChild("MessageSendingOrganization");
            $MessageSendingOrganization->addChild("FacilityName", "AIDS Prevention Initiative In Nigeria");
            $MessageSendingOrganization->addChild("FacilityID", "APIN");
            $MessageSendingOrganization->addChild("FacilityTypeCode", "IP");

            /*             * * add a IndividualReport element ** */
            $IndividualReport = $Container->addChild("IndividualReport");
            IndividualReport::patientDemographics($IndividualReport ,$pts, $facility, $connection);
            $condition = $IndividualReport->addChild("Condition");
            IndividualReport::condition($condition, $pts, $facility, $connection);



            $filen = "";
            $filen .= "UPDATED_";
            $filen .= date('YmdHis') . "_";
            $filen .= $pts['IDNumber'];


            ////////////////////CREATE ndr FOLDER/////////////
            $upPath = "c:\/ndr/" . "ndr_" . str_replace(" ", "", trim($facility['facilityName'])) . "_" . date('dMY');   // full pat
            if (!file_exists('c:\ndr')) {
                mkdir('c:\ndr', 0777, true);
                $tags = explode('/', $upPath);            // explode the full path
                $mkDir = "";
                foreach ($tags as $folder) {
                    $mkDir = $mkDir . $folder . "/";   // make one directory join one other for the nest directory to make
                    if (!is_dir($mkDir)) {             // check if directory exist or not
                        mkdir($mkDir, 0777, true);            // if not exist then make the directory
                    }
                }
            } else {
                $tags = explode('/', $upPath);            // explode the full path
                $mkDir = "";
                foreach ($tags as $folder) {
                    $mkDir = $mkDir . $folder . "/";   // make one directory join one other for the nest directory to make
                    if (!is_dir($mkDir)) {             // check if directory exist or not
                        mkdir($mkDir, 0777, true);            // if not exist then make the directory
                    }
                }
            }
            /*             * * echo the xml ** */
            $Container->asXML($upPath . "/" . $filen . ".xml");
            //echo $filen.' Generated...'.'<br>';
            echo ob_get_contents();
            ob_end_flush();
        } catch (Exception $ex) {
            return null;
        }
    }

}

?>