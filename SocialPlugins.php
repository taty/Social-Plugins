<?php

/**
 * SocialPlugin class.
 *
 * @author Vakulenko Tatiana <tvakulenko@gmail.com>
 * @package packageName
 * @since 1.0
 *
 */

/**
 * SocialPlugin class.
 *
 * SocialPlugin allows you to add social icons to your site
 */
class SocialPlugins extends CWidget
{

    /**
     * Description of visible variable.
     *
     * @var string Visible.
     */
    public $visible = '1';
    
    /**
     * Description of options variable.
     *
     * @var array Options.
     */
    private $_options = array(
        'facebooklike' => array(),
        'tweet' => array(),
        'googleplus' => array(),
        'twitterconnect' => array(),
    );
    /**
     * Description of config variable.
     *
     * @var array Config.
     */
    private $_config = array(
        'facebooklike' => array('class' => 'FacebookLikeButton'),
        'tweet' => array('class' => 'TweetButton'),
        'googleplus' => array('class' => 'GooglePlusoneButton'),
        'twitterconnect' => array('class' => 'TwitterConnectButton'),
    );

    /**
     * Function Constructor.
     *
     * This method set the сonstructor.
     *
     * @param string $owner The default owner variable.
     *
     * @return
     */
    public function __construct($owner = null) {
        parent::__construct($owner);
    }

    /**
     * Function run.
     *
     * This method run the controller.
     *
     * @return
     */
    public function run() {
        $this->renderWidget();
    }

    /**
     * Function getOptions.
     *
     * This method get the options.
     *
     * @return
     */
    public function getOptions() {
        if (is_null($this->_options) !== true) {
            $this->_options = new CMap($this->_options, false);
        }
        return $this->_options;
    }

    /**
     * Function getTagOptions.
     *
     * This method get tag options.
     *
     * @return
     */
    private function getTagOptions() {
        return $this->getOptions()->toArray();
    }

    /**
     * Function renderWidget.
     *
     * This method render the widget.
     *
     * @return
     */
    protected function renderWidget() {
        $options = array_merge_recursive($this->getTagOptions(), $this->_config);

        $sort = new CSort;
        $sort->defaultOrder = 'id ASC';
        $sort->attributes = array('id');
        $dataProvider = new CArrayDataProvider($options,
                        array('sort' => $sort)
        );
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'itemView' => '_view',
            'summaryText' => ''
        ));
    }

    /**
     * Function setFacebooklike.
     *
     * This method set the facebooklike.
     *
     * @param integer $value The Facebooklike button.
     *
     * @return
     */
    public function setFacebooklike($value) {
        $this->getOptions()->add('facebooklike', $value);
    }

    /**
     * Function setTweet.
     *
     * This method set the tweet.
     *
     * @param integer $value The tweet button.
     *
     * @return
     */
    public function setTweet($value) {
        $this->getOptions()->add('tweet', $value);
    }

    /**
     * Function setGoogleplus.
     *
     * This method set the googleplus.
     *
     * @param integer $value The googleplus button.
     *
     * @return
     */
    public function setGoogleplus($value) {
        $this->getOptions()->add('googleplus', $value);
    }

    /**
     * Function setTwitterconnect.
     *
     * This method set the twitterconnect.
     *
     * @param integer $value The twitterconnect button.
     *
     * @return
     */
    public function setTwitterconnect($value) {
        $this->getOptions()->add('twitterconnect', $value);
    }

}

