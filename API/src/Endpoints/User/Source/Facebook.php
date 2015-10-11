<?php
namespace API\src\Endpoints\User\Source;

use API\src\Endpoints\Endpoints;
use API\src\Request\Request;
use API\src\Error\Error;
use Facebook\Facebook as Fb;
use API\src\Config\Config;
use Facebook\FacebookRequest;
use Facebook\FacebookApp;

class Facebook extends Endpoints
{

    public $request;

    public function get()
    {
        $fb = new Fb([
            'app_id' => Config::getConfig('FacebookAppId'),
            'app_secret' => Config::getConfig('FacebookSecret'),
            'default_graph_version' => Config::getConfig('FacebookAPIVersion')
        ]);
        $fields = $this->request->get('facebookFields_text', false, '');
        $edge = $this->request->get('facebookEdge_text', false, '');
        $response = $fb->sendRequest('GET', '/' . $this->request->get('facebookUserId_text') . $edge, array(
            'fields' => $fields
        ), $this->request->get('facebookAccessToken_text'));
        $facebookBody = $response->getDecodedBody();
        $body = $this->request->body;
        $body['facebookResponse_text'] = $facebookBody;
        $this->request->response->body = $body;
        $this->request->response->code = r_success;
    }

    public function post()
    {
        Error::throwApiException('`POST` operations are not currently supported for the endpoint ' . $this->request->endpoint, r_missing);
    }

    public function put()
    {
        Error::throwApiException('`PUT` operations are not currently supported for the endpoint ' . $this->request->endpoint, r_missing);
    }

    public function delete()
    {
        Error::throwApiException('`DELETE` operations are not currently supported for the endpoint ' . $this->request->endpoint, r_missing);
    }

    public function getResponse()
    {
        //
    }
}