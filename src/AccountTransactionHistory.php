<?php namespace CSApi;


class AccountTransactionHistory extends CSApi
{
    /**
     * Requests transaction history
     *
     * @param string $account
     * @param array $parametersArray
     *
     * @return object
     */
    public function apiRequest($account, array $parametersArray = [])
    {
        $parameters = http_build_query($parametersArray);
        $url = str_replace(['{account}', '{parameters}'], [$account, $parameters], $this->config['urlTransactions']);
        $authorizationToken = $this->accessToken->getValues()['token_type'] . ' ' . $this->accessToken->getToken();

        $ch = curl_init();

        if (FALSE === $ch)
            trigger_error('Failed to initialize Curl');

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "WEB-API-key: " . $this->config['webApiKey'],
            "Authorization: " . $authorizationToken
        ));

        $response = curl_exec($ch);

        if (FALSE === $response)
            echo "Curl failed with error " . curl_error($ch) . ": ".curl_errno($ch);

        curl_close($ch);

        return json_decode($response);
    }
}