<?php

namespace App\Linkedin\Repositories;

use App\Linkedin\Client;
use App\Linkedin\Constants;
use Illuminate\Support\Arr;

class Profile extends Repository
{

    /**
     * @var Client
     */
    protected Client $client;

    /**
     * Repository constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @return array
     */
    public function getOwnProfile(): array
    {
        return $this->client->setHeaders($this->login)->get(Constants::API_URL . '/me');
    }

    /**
     * @param string $urn_id
     * @param string $keyword
     * @return array
     */
    public function getProfileConnections(string $urn_id, string $keyword = ''): array
    {
        return $this->searchPeople($keyword, 0, 20, $urn_id, 'F');
    }

    /**
     * @param string $public_identifier
     * @return array
     */
    public function getProfile(string $public_identifier): array
    {
        return $this->client->setHeaders($this->login)->get(Constants::API_URL . '/identity/profiles/' . $public_identifier . '/profileView');
    }

    /**
     * @param string $key_word
     * @param array $options
     * @return array
     */
    public function searchPeople(string $key_word = '', array $options = []): array
    {
        $query_params = [
            'count' => $options['limit'] ?? 50,
            'filters' => [
                'resultType->PEOPLE',
                'geoUrn->103030111',
            ],
            'origin' => 'GLOBAL_SEARCH_HEADER',
            "queryContext" => "List(spellCorrectionEnabled->true,relatedSearchesEnabled->true,kcardTypes->PROFILE|COMPANY)",
            'q' => 'all',
            'start' => $options['skip'] ?? 0

        ];

//        dd($query_params);

        if ($key_word) {
            $query_params['keywords'] = $key_word;
        }

        if (isset($options['urn_id'])) {
            array_push($query_params['filters'], 'connectionOf->' . $options['urn_id']);
        }
        if ($options['network_depth']) {
            // array_push($query_params['filters'], 'network->S');
        }

        return $this->client->setHeaders($this->login)->get(Constants::API_URL . '/search/blended', $query_params);
    }

}
