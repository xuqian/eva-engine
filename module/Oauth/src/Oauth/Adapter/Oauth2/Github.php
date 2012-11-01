<?php
    
namespace Oauth\Adapter\Oauth2;

use Oauth\Adapter\Oauth2\AbstractAdapter;
use ZendOAuth\OAuth;

class Github extends AbstractAdapter
{
    protected $accessTokenFormat = 'pair';

    protected $authorizeUrl = "https://github.com/login/oauth/authorize";
    protected $accessTokenUrl = "https://github.com/login/oauth/access_token";

    protected $defaultOptions = array(
        'requestScheme' => OAuth::REQUEST_SCHEME_POSTBODY,
    );
}
