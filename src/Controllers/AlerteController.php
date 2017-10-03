<?php
namespace Src\Controllers;

use GuzzleHttp\Client;
use SimpleXMLElement;
use Slim\Http\Request;
use Slim\Http\Response;

class AlerteController {

    public function getData(Request $request, Response $response, array $args){

        if (! $args['departement']) {
            $args['departement'] = '44';
        }

        $client = new Client();
        $res = $client->request(
            'GET',
            "http://vigilance.meteofrance.com/data/NXFR49_LFPW_.xml?9327430"
        );
        $result = new SimpleXMLElement($res->getBody()->getContents());


        // recherche du departement souhaite
        foreach ($result->PHENOMENE as $dep){

            if($dep['departement'] == $args['departement']){
                foreach($dep[0]->attributes() as $a => $b) {
                    $data[$a]= $b;
                }
                break;
            };
        }

        return $response->withJson($data);

    }

}
