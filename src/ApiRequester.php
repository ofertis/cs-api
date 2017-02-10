<?php namespace CSApi;


class ApiRequester extends CSApi
{
    /**
     * Sends a request to API server
     *
     * @param string $apiUrl
     * @param array $urlParameters
     * @param array $postData
     *
     * @return object
     */
    public function apiRequest($apiUrl, array $urlParameters = [], array $postData = null)
    {
        $tokenType = $this->accessToken->getValues()['token_type'];
        $accessToken = $this->accessToken->getToken();

        $url = vsprintf($this->config[$apiUrl], $this->buildQuery($urlParameters));
        $postFields = json_encode($postData);
        $httpHeader[] = "WEB-API-key: " . $this->config['webApiKey'];
        $httpHeader[] = "Authorization: " . $tokenType . ' ' . $accessToken;
        $httpHeader[] = isset($postData) ? "Content-Type: application/json" : "";

        $ch = curl_init();

        if (FALSE === $ch)
            trigger_error('Failed to initialize Curl');

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        if(isset($postData)){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);

        $response = curl_exec($ch);

        if (FALSE === $response)
            echo "Curl failed with error " . curl_error($ch) . ": ".curl_errno($ch);

        curl_close($ch);

        return json_decode($response);
    }

    /**
     * Transforms inner array of 'query' key into http query
     *
     * @param array $arr
     *
     * @return array
     */
    protected function buildQuery(array $arr)
    {
        if(isset($arr['query'])){
            $arr['query'] = http_build_query($arr['query']);
        }
        return $arr;
    }
}