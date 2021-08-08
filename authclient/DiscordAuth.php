<?php

/**
 * @link https://www.greenmeteor.net/
 * @copyright Copyright (c) 2020 Green Meteor Co.
 * @license https://greenmeteor.net/p/licences
 */

namespace gm\humhub\modules\auth\discord\authclient;

use Yii;
use yii\authclient\OAuth2;
use yii\authclient\OAuthToken;

/**
 * Discord allows authentication via Discord OAuth.
 */
class DiscordAuth extends OAuth2
{
  /**
   * @inheritdoc
   */
  public $authUrl = 'https://discord.com/api/oauth2/authorize';

  /**
   * @inheritdoc
   */
  public $tokenUrl = 'https://discord.com/api/oauth2/token';

  /**
   * @inheritdoc
   */
  public $apiBaseUrl = 'https://discord.com/api/v8';

  /**
   * @inheritdoc
   */
  public $scope = 'identify email';

  /**
   * @inheritdoc
   */
  public $autoRefreshAccessToken = true;

  /**
   * @inheritdoc
   */
  public $autoExchangeAccessToken = false;

  /**
   * @inheritdoc
   */
   protected function defaultViewOptions()
   {
     return [
       'popupWidth' => 860,
       'popupHeight' => 480,
       'cssIcon' => 'fab fa-discord',
       'buttonBackgroundColor' => '#7289DA',
     ];
   }

  /**
   * @inheritdoc
   */
   protected function defaultNormalizeUserAttributeMap()
   {
     return [
       'username' => 'displayName',
       'email' => function ($attributes) {
         return $attributes['email'];
       },
     ];
   }

  /**
   * @inheritdoc
   */
   public $attributeNames = [
     'id',
     'email'
   ];

  /**
   * @inheritdoc
   */
   protected function initUserAttributes()
   {
     return $this->api('users/@me', 'GET');
   }

  /**
   * @inheritdoc
   */
   protected function sendMessage($msg, $webhook)
   {
       $config = ConfigureForm::getInstance();
       $webhook = $config; 
       $timestamp = date('c', strtotime("now"));
       $msg = json_encode(['content' => 'New Member joined!', 'tts' => false, 'timestamp' => $timestamp,], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

       if ($webhook != $config) {
           $ch = curl_init( $webhook );
           curl_setopt( $ch, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
           curl_setopt( $ch, CURLOPT_POST, 1);
           curl_setopt( $ch, CURLOPT_POSTFIELDS, $msg);
           curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
           curl_setopt( $ch, CURLOPT_HEADER, 0);
           curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

           $response = curl_exec( $ch );
           // If you need to debug, or find out why you can't send message uncomment line below, and execute script.
           echo $response;
           curl_close( $ch );

       }
       sendMessage($msg, $webhook); // SENDS MESSAGE TO DISCORD
       echo "sent?";
   }

  /**
   * @inheritdoc
   */
   protected function initChannelAttributes()
   {
       $webhook = ''; 
       $msg = json_encode([], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
     return $this->api('/channels/{channel.id}/messages', 'POST');
   }

  /**
   * @inheritdoc
   */
   public function applyAccessTokenToRequest($request, $accessToken)
   {
     $request->getHeaders()->set('Authorization', 'Bearer '. $accessToken->getToken());
   }

  /**
   * @inheritdoc
   */
   public function fetchAccessToken($authCode, array $params = [])
   {
     $token = parent::fetchAccessToken($authCode, $params);
     if ($this->autoExchangeAccessToken) {
       $token = $this->exchangeAccessToken($token);
     }
     return $token;
   }

  /**
   *
   * @param OAuthToken $token short-live access token.
   * @return OAuthToken long-live access token.
   */
   public function exchangeAccessToken(OAuthToken $token)
   {
     $params = [
       'grant_type' => 'exchange_code',
       'exchange_code' => $token->getToken(),
     ];

     $request = $this->createRequest()
       ->setMethod('POST')
       ->setUrl($this->tokenUrl)
       ->setData($params);

       $this->applyClientCredentialsToRequest($request);

       $response = $this->sendRequest($request);

       $token = $this->createToken(['params' => $response]);

       $this->setAccessToken($token);

       return $token;
     }

  /**
   *
   * @param string $authCode client auth code.
   * @param array $params
   * @return OAuthToken long-live client-specific access token.
   */
   public function fetchClientAccessToken($authCode, array $params = [])
   {
     $params = array_merge([
       'code' => $authCode,
       'redirect_uri' => $this->getReturnUrl(),
       'client_id' => $this->clientId,
     ], $params);

     $request = $this->createRequest()
       ->setMethod('POST')
       ->setUrl($this->tokenUrl)
       ->setData($params);

    $response = $this->sendRequest($request);

    $token = $this->createToken(['params' => $response]);

    $this->setAccessToken($token);

    return $token;
  }

  /**
   * @inheritdoc
   */
   protected function defaultName() {
     return 'discord';
   }

  /**
   * @inheritdoc
   */
   protected function defaultTitle() {
     return 'Discord';
   }
}
