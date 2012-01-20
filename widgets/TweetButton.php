<?php
/**
 * TweetButton class file.
 *
 * @author Tatiana Vakulenko <tvakulenko@gmail.com>
 */

/**
 * TweetButton represents an ...
 *
 * Description of TweetButton
 *
 * @author Tatiana Vakulenko <tvakulenko@gmail.com>
 * @version $Id$
 * @package
 * @since 1.0
 */
class TweetButton extends CWidget
{

    const API_SCRIPT_URL = 'http://platform.twitter.com/widgets.js';

    const API_TARGET_URL = 'http://twitter.com/share';

    private $_countEnum = array(
        'none',
        'horizontal',
        'vertical'
    );

    private $_options = array(
        'url'=>'',
        'via'=>'',
        'text'=>'',
        'related'=>'',
        'count'=>'horizontal',
        'lang'=>'en',
        'counturl'=>''
    );
    
    /**
     * @var boolean use HTML5 or HTML4 standard tag syntax for widget.
     */
    public $html = false;

    public function __construct($owner=null)
    {
        parent::__construct($owner);
        $this->_options = new CMap($this->_options, false);
    }

    public function init()
    {
        Yii::app()->clientScript
                ->registerScriptFile(self::API_SCRIPT_URL, CClientScript::POS_END);
    }

    public function run()
    {
        echo CHtml::link('Tweet', $this->getApiTargetUrl(), $this->getTagOptions());
    }

    /**
     * @return CMAp widget options map
     */
    public function getOptions()
    {
        return $this->_options;
    }

    public function getApiTargetUrl()
    {
        if (false === CPropertyValue::ensureBoolean($this->html))
        {
            $params = array_filter($this->options->toArray());
            return self::API_TARGET_URL . '?' . http_build_query($params);
        }

        return  self::API_TARGET_URL;
    }

    /**
     * @return array widget tag options.
     */
    private function getTagOptions()
    {
        if (false !== CPropertyValue::ensureBoolean($this->html))
        {
            $options = array('class'=>'twitter-share-button');
            foreach($this->options as $key=>$value)
            {
                $options['data-'.$key] = $value;
            }
            return $options;
        }

        $this->getOptions()->add('class', 'twitter-share-button');
        return $this->getOptions()->toArray();
    }

    /**
     * Set URL of the page to share.
     * @param string $value
     */
    public function setUrl($value)
    {
        $this->getOptions()->add('url', $value);
    }

    /**
     * Screen name of the user to attribute the Tweet to.
     * @param string $value
     */
    public function setUsername($value)
    {
        $this->getOptions()->add('via', $value);
    }

    /**
     * Comma separated related accounts.
     * @param string $value
     */
    public function setRelatedAccount($value)
    {
        $this->getOptions()->add('related', $value);
    }

    /**
     * Default Tweet text.
     * @param string $value
     */
    public function setText($value)
    {
        $this->getOptions()->add('text', $value);
    }

    /**
     * The count box shows how many times the URL has been Tweeted.
     * You can choose to display or hide the count box, or place it above or next to the Tweet Button.
     * Possible values: none, horizontal, vertical
     * @param <type> $value
     */
    public function setCountBoxPosition($value)
    {
        if (false === in_array($value, $this->_countEnum))
        {
            throw new CException(Yii::t(__CLASS__.'.general','Invalid count box position value "{value}". Please make sure it is among ({enum}).',
                array('{value}'=>$value, '{enum}'=>implode(', ',$this->_countEnum))));
        }
        $this->getOptions()->add('count', $value);
    }

    /**
     * Shortcut for ZTweetButton::setCountBoxPosition
     * @see ZTweetButton::setCountBoxPosition
     * @param string $value
     */
    public function setCount($value)
    {
        $this->setCountBoxPosition($value);
    }

    public function setCountUrl($value)
    {
        $this->getOptions()->add('counturl', $value);
    }

    public function setLanguage($value)
    {
        $this->getOptions()->add('lang', $value);
    }


}