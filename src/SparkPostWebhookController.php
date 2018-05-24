<?php

namespace Brentnd\Api\Webhooks;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class SparkPostWebhookController extends Controller
{

    /**
     * Handle the SparkPost webhook and call
     * method if available
     *
     * @return Response
     */
    public function handleWebHook(Request $request)
    {
        $events = $this->getJsonPayloadFromRequest($request);

        foreach ($events as $event) {
            $eventName = isset($event['event']) ? $event['event'] : 'undefined';
            if($eventName == 'undefined' && isset($event['type'])){
                $eventName = $event['type'];
            }
            $method = 'handle' . studly_case(str_replace('.', '_', $eventName));

            if (method_exists($this, $method)) {
                $this->{$method}($event);
            }
        }

        return new Response;
    }

    /**
     * Pull the SparkPost payload from the json
     *
     * @param $request
     *
     * @return array
     */
    private function getJsonPayloadFromRequest($request)
    {
        return (array) json_decode($request->get('sparkpost_events'), true);
    }
}
