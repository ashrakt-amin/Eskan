<?php
namespace App\Http\Traits;

Trait ResponseTrait
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($data, $message, $code = 200, $additional = [])
    {
    	$response = [
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ] + $additional;


        return response()->json($response, $code);
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginateResponse($data, $collection, $message = "", $code = 200)
    {

        $meta = $collection->toArray();

        return $this->sendResponse($data, $message, $code, $meta);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    /**
     * response codes.
     */
    // Informational responses (100 – 199) {
        // 100 Continue --> This interim response indicates that the client should continue the request or ignore the response if the request is already finished.
        // 101 Switching Protocols--> This code is sent in response to an Upgrade request header from the client and indicates the protocol the server is switching to.
        // 102 Processing --> This code is used internally by Browser Transfer to indicate that processing is being done on the server.
        // 103 Early Hints --> This code is used internally by the Server to indicate to the server that no response is coming back from the browser and that this is not the result of a user action.
        // 104 Informational --> This response is sent by the browser when the browser has finished loading the requested resource. This is the status code that is sent after the user-agent has loaded the requested page.
        // 105 OK --> This code is used internally by the Server to indicate that no response is coming back from the server.
        // 106 Reset Content --> This code is used internally by the Server to indicate to the server that the requested content has been reset.
    // }
    // Successful responses (200 – 299) {
        // 200 OK
        // 201 Created
        // 202 Accepted
        // 203 Non-Authoritative Information
        // 204 No Content
        // 205 Reset Content
        // 206 Partial Content
        // 207 Multi-Status
        // 208 Already Reported
        // 226 IM Used
    // }
    // Redirection messages (300 – 399) {
        // 300 Multiple Choices
        // 301 Moved Permanently
        // 302 Found
        // 303 See Other
        // 304 Not Modified
        // 305 Use Proxy
        // 307 Temporary Redirect
        // 308 Permanent Redirect
    // }
    // Client error responses (400 – 499) {
        // 400 Bad Request
        // 401 Unauthorized
        // 402 Payment Required
        // 403 Forbidden
        // 404 Not Found
        // 405 Method Not Allowed
        // 406 Not Acceptable
        // 407 Proxy Authentication Required
        // 408 Request Timeout
    // }
    // Server error responses (500 – 599) {
        // 500 Internal Server Error
        // 501 Not Implemented
        // 502 Bad Gateway
        // 503 Service Unavailable
        // 504 Gateway Timeout
    // }
}
