<?php
/**
 * TwitterConnectController class file.
 *
 * @author Tatiana Vakulenko <tvakulenko@gmail.com>
 */

/**
 * TwitterConnectController represents an ...
 *
 * TwitterConnectController allows you to authorizate with twitter
 *
 * @author Tatiana Vakulenko <tvakulenko@gmail.com>
 * @version $Id$
 * @package
 * @since 1.0
 */
class TwitterConnectController extends Controller
{

    public function actionIndex()
    {
        if (true === is_null(Yii::app()->session->get('twitter')))
        {
            Yii::app()->socialplugins->userOAuth();
            Yii::app()->session->add('twitter', Yii::app()->socialplugins->getUserInfo(
                Yii::app()->session->get('oauth_token'),
                Yii::app()->session->get('oauth_token_secret'))
            );
        }
    }
          
    public function actionLogout()
    {
        Yii::app()->session->destroy();
        $this->redirect(Yii::app()->request->getUrlReferrer());
    }
} 
