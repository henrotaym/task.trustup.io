<?php
namespace App\Api\Auth\Credentials;

use Deegitalbe\ServerAuthorization\Credential\AuthorizedServerCredential;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;

class AuthCredential extends AuthorizedServerCredential
{
    public function prepare(RequestContract &$request)
    {
        parent::prepare($request);
        $request->setBaseUrl(env('TRUSTUP_AUTH_IO_URL'). '/api');
    }
}