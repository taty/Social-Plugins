<?php
/**
 * TwitterConnect class file.
 *
 * @author Tatiana Vakulenko <tvakulenko@gmail.com>
 */

/**
 * TwitterConnect represents an ....
 *
 * Description of TwitterConnect 
 *
 * @author Tatiana Vakulenko <tvakulenko@gmail.com>
 * @version $Id$
 * @package SocialPlugins
 * @since 1.0
*/

class TwitterConnect extends CApplicationComponent
{

    /**
     * @var string consumerKey.
     */
    public $consumerKey;
    /**
     * @var string consumerSecret.
     */
    public $consumerSecret;
    /**
     * @var string twitterRequestUrl.
     */
    public $twitterRequestUrl;
    /**
     * @var string twitterAccessUrl.
     */
    public $twitterAccessUrl;
    /**
     * @var string twitterAutorizeUrl.
     */
    public $twitterAutorizeUrl;

    /**
     * This method is called by the application before the controller starts to execute.
     */
    public function init()
    {
        parent::init();

        Yii::setPathOfAlias('socialplugins', dirname(__FILE__));
        Yii::import('socialplugins.*');
        Yii::import('socialplugins.controllers.*');

        Yii::app()->configure(array('controllerMap' => CMap::mergeArray(Yii::app()->controllerMap,
                    array('twconnect' => array(
                            'class' => 'TwitterConnectController',
                        )
                    )
                ))
        );
    }

    /**
     * Setting OAuth Connection.
     * This method set oauth connection.
     * @param string $method this optional parameter defines which signature method to use.
     * @param string $type this optional parameter defines how to pass the OAuth parameters to a consumer.
     * @return OAuth the oauth object.
     */
    public function getOAuthConnection($method, $type)
    {
        $oauth = new OAuth($this->consumerKey, $this->consumerSecret, $method, $type);
        $oauth->enableDebug();
        return $oauth;
    }

    /**
     * Working with oauth tokens and recieve user data.
     */
    public function userOAuth()
    {
        $oauth = $this->getOAuthConnection(OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_FORM);

        try
        {
            if (Yii::app()->request->getParam('oauth_token') !== ''
                    && false === is_null(Yii::app()->session->get('oauth_token_secret')))
            {

                $oauth->setToken(Yii::app()->request->getParam('oauth_token'),
                        Yii::app()->session->get('oauth_token_secret'));

                $accessToken = $oauth->getAccessToken($this->twitterAccessUrl);

                Yii::app()->session->add('oauth_token', $accessToken['oauth_token']);
                Yii::app()->session->add('oauth_token_secret', $accessToken['oauth_token_secret']);

                $response = $oauth->getLastResponse();

                parse_str($response, $responseArr);
                if (false === isset($responseArr['user_id']))
                {
                    throw new Exception(Yii::t('', 'Authentication failed.'));
                }
                echo CHtml::script('window.close();');
            } 
            else
            {
                $requestToken = $oauth->getRequestToken($this->twitterRequestUrl);

                Yii::app()->session->add('oauth_token_secret', $requestToken['oauth_token_secret']);
                Yii::app()->request->redirect($this->twitterAutorizeUrl . '?oauth_token='
                        . $requestToken['oauth_token'], true);
            }
        } 
        catch (Exception $e)
        {
            echo Yii::t("", "Response: {message}", array("{message}" => $e->getMessage()));
        }
    }

    /**
     * Get user information.
     * @param string $token token.
     * @param string $secret token secret.
     * @return CJSON object.
     */
    public function getUserInfo($token, $secret)
    {

        $oauth = $this->getOAuthConnection(OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
        $oauth->setToken($token, $secret);
        $oauth->fetch('http://twitter.com/account/verify_credentials.json');
        $info = $oauth->getLastResponse();
        return CJSON::decode($info, true);
    }

}
