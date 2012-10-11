<?php
    
namespace Oauth\Adapter\Oauth1;

use Oauth\Adapter\AdapterInterface;
use Oauth\Adapter\Oauth1\AbstractAdapter;


class Twitter extends AbstractAdapter implements AdapterInterface
{
    protected $requestTokenUrl = "https://api.twitter.com/oauth/request_token";

    protected $authorizeUrl = "https://api.twitter.com/oauth/authorize";

    protected $accessTokenUrl = "https://api.twitter.com/oauth/access_token";
}
