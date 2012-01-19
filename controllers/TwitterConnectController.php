<?php
/**
 * TwitterConnectController class.
 *
 * @author Vakulenko Tatiana <tvakulenko@gmail.com>
 * @package packageName
 * @since 1.0
 * 
 */

/**
 * TwitterConnectController class.
 * 
 * TwitterConnectController allows you to authorizate with twitter
 */

class TwitterConnectController extends Controller
{
  
    /**
    * Function actionIndex.
    * 
    * This method is Index.
    * 
    * @return 
    */
    public function actionIndex() {

        if (true === is_null(Yii::app()->session->get('twitter')))
        {
            Yii::app()->socialplugins->userOAuth();
            Yii::app()->session->add('twitter', Yii::app()->socialplugins->getUserInfo(
                Yii::app()->session->get('oauth_token'),
                Yii::app()->session->get('oauth_token_secret'))
            );
        }
    }
  
    
    /**
    * Function actionLogout.
    *
    * Function logout.
    *
    * @return
    */
    public function actionLogout()
    {
        Yii::app()->session->destroy();
        $this->redirect(Yii::app()->request->getUrlReferrer());
    }
} 
