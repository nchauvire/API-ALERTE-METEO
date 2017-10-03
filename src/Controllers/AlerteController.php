<?php
namespace Src\Controllers;

use GuzzleHttp\Client;
use SimpleXMLElement;
use Slim\Http\Request;
use Slim\Http\Response;

class AlerteController {

    public function getData(Request $request, Response $response, array $args){

        if (! $args['city']) {
            $args['city'] = 'nantes';
        }

        //convertion de la ville en departement
        $client1 = new Client();
        $res = $client1->request(
            'GET',
            "http://vicopo.selfbuild.fr/?city=".$args['city']
        );

        foreach (json_decode($res->getBody()->getContents())->cities as $city){
            if(strtolower($city->city) == strtolower($args['city'])){
                $depCode = substr($city->code,0,2);
            }
        }
        $client = new Client();
        $res = $client->request(
            'GET',
            "http://vigilance.meteofrance.com/data/NXFR49_LFPW_.xml?9327430"
        );
        $result = new SimpleXMLElement($res->getBody()->getContents());


        // recherche du departement souhaite
        foreach ($result->PHENOMENE as $dep){

            if($dep['departement'] == $depCode){
                foreach($dep[0]->attributes() as $a => $b) {
                    $data[$a]= $b;
                }
                break;
            };
        }

        return $response->withJson($data);

    }

}
