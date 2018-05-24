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
        foreach ($request->all() as $request) {
            if (empty($request['msys'])) {
                $this->callEventMethod('ping', []);
            } else {
                $event = $request['msys'];
                foreach ($event as $eventType=>$event) {
                    $eventName = $eventType . '_' . $event['type'];
                    $this->callEventMethod($eventName, $event);
                }
            }
        }
        return response(null, 204);
    }

    /**
     * Call the associated event method if it exists
     * in derived class
     *
     * @param $eventName
     * @param $payload
     */
    private function callEventMethod($eventName, $payload)
    {
        $method = 'handle' . studly_case($eventName);

        if (method_exists($this, $method)) {
            $this->{$method}($payload);
        }        
    }
}
