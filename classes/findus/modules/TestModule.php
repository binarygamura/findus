<?php

//namespace findus\modules;
//
//class TestModule implements \findus\common\Module {
//    public function execute() {
//        putenv('GOOGLE_APPLICATION_CREDENTIALS=./config/api_key.json');
//        $client = new \Google_Client();
//        $client->useApplicationDefaultCredentials();
//
//        $service = new \Google_Service_Drive($client);
//        $optParams = array(
//            'pageSize' => 10,
//            'fields' => 'nextPageToken, files(id, name)'
//          );
//        $results = $service->files->listFiles($optParams);
//        $response = new \findus\common\TemplateResponse();
//        $response->setTemplateName("login.htpl");
//        return $response;
//    }
//}
