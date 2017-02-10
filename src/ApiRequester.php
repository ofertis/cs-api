<?php namespace CSApi;


class ApiRequester extends CSApi
{
    /**
     * Requests transaction history
     *
     * @param string $apiUrl
     * @param array $parametersArray
     * @param array $postData
     *
     * @return object
     */
    public function apiRequest($apiUrl, array $parametersArray = [], array $postData = null)
    {
        $url = vsprintf($this->config[$apiUrl], $this->buildQuery($parametersArray));
        $authorizationToken = $this->accessToken->getValues()['token_type'] . ' ' . $this->accessToken->getToken();

        $ch = curl_init();

        if (FALSE === $ch)
            trigger_error('Failed to initialize Curl');

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        if(isset($postData)){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            isset($postData) ? "Content-Type: application/json" : "",
            "WEB-API-key: " . $this->config['webApiKey'],
            "Authorization: " . $authorizationToken
        ));

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