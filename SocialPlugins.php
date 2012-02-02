<?php
/**
 * SocialPlugins class file.
 *
 * @author Tatiana Vakulenko <tvakulenko@gmail.com>
 */
Yii::import('zii.widgets.CListView');
/**
 * SocialPlugins represents an ....
 *
 * SocialPlugin allows you to add social icons to your site
 *
 * @author Tatiana Vakulenko <tvakulenko@gmail.com>
 * @version $Id$
 * @package SocialPlugins
 * @since 1.0
*/
class SocialPlugins extends CListView
{  
        
    private $_buttons = array(
        'FacebookLikeButton',
        'TweetButton',
        'GooglePlusoneButton',
        'TwitterConnectButton'
    );
    private $_additionalButtons = array();
    /**
     * This is a list of paths to extra buttons.
     * Example:
     * 'additionalButtons' => array(
     *    'application.extensions.social-widgets.newButtonWidget'=>array(), // added button as last
     * )
     * @var array
     */
   
    public function init()
    {
        $sort = new CSort;
        $sort->defaultOrder = 'id ASC';
        $sort->attributes = array('id');
        $dataProvider = new CArrayDataProvider($this->getButtons(), array('sort' => $sort));
        $this->dataProvider = $dataProvider;
        $this->summaryText = '';
        $this->itemView = '_view';        
        parent::init();
        
    }

    public function setButtons(array $buttons)
    {
        $this->_buttons = $buttons;
    }

    public function getButtons()
    {
       $arr = array();
       foreach($this->_buttons as $key=>$button)
       {
            $arr['ext.socialplugins.widgets.'.$key] = $button;
       }        
       return CMap::mergeArray($arr, $this->_additionalButtons);
    }

    public function setAdditionalButtons(array $additionalButtons)
    {
        $func = function($value) {
             Yii::import($value);
        };
        foreach($additionalButtons as $value)
        {
            array_map($func, $value);
        }
        $this->_additionalButtons = $additionalButtons;
    }
    
    public function getOwner()
    {
        return $this;
    }
        
}

