<?php

namespace speedy\modules;

class TestModule implements \speedy\common\Module {
    public function execute() {
        putenv('GOOGLE_APPLICATION_CREDENTIALS=./config/api_key.json');
        $client = new \Google_Client();
        $client->useApplicationDefaultCredentials();

        $service = new \Google_Service_Drive($client);
        $optParams = array(
            'pageSize' => 10,
            'fields' => 'nextPageToken, files(id, name)'
          );
        $results = $service->files->listFiles($optParams);
        echo("EY!!");
        $response = new \speedy\common\TemplateResponse();
        $response->setTemplateName("login.htpl");
        return $response;
    }
}
