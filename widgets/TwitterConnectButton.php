<?php
/**
 * TwitterConnectButton class file.
 *
 * @author Tatiana Vakulenko <tvakulenko@gmail.com>
 */

/**
 * TwitterConnectButton represents an ...
 *
 * @author Tatiana Vakulenko <tvakulenko@gmail.com>
 * @package packageName
 * @since 1.0
 *
 */
class TwitterConnectButton extends CWidget
{
    /**
     * @var string Template.
     */
    private $_template = 'standart';
    /**
     * @var array AvailableTemplates.
     */
    private $_availableTemplates = array(
        'standart',
        'box'
    );
    /**
     * @var array Options.
     */
    private $_options = array(
        'type' => 'button',
        'class' => 'twconnect',
        'value' => 'Twitter Connect',
        'width' => '',
        'style' => '',
    );

    /**
     * This method is called by the application before the controller starts to execute.
     */

    public function init()
    {
        $this->registerConfigurationScripts();           
    }

    /**
     * Renders the view.
     * This is the main entry of the whole view rendering.
     */
    public function run()
    {
        if (false === is_null(Yii::app()->session->get('twitter')))
        {
            $twitterData = Yii::app()->session->get('twitter');
            echo CHtml::image($twitterData['profile_image_url'], 'Profile') . ' '
                    . $twitterData['screen_name'] . '<br>';
            echo CHtml::link('Sign out', '/twconnect/logout');
        } 
        else
        {
            $render = 'render' . ucfirst($this->_template);
            if (true === method_exists($this, $render))
            {
                $this->$render();
            } 
            else
            {
                throw new Exception('This method doesn\'t exist');
            }
            
        }
    }

    /**
     * Set the template.
     * @param string $value set the template.
     */
    public function setTemplate($value)
    {
        if (true === is_string($value))
        {
            if (true === in_array($this->_template, $this->_availableTemplates))
            {
                $this->_template = $value;
            }
        } 
        else
        {
            throw new Exception('This parametr must be a string');
        }
    }

    public function getOptions()
    {
        if (is_null($this->_options) !== true)
        {
            $this->_options = new CMap($this->_options, false);
        }
        return $this->_options;
    }

    private function getTagOptions()
    {
        return $this->getOptions()->toArray();
    }

    /**
     * Render the standart twitter template.
     */
    public function renderStandart()
    {
        echo CHtml::openTag('div', array('class' => 'twitter_standart'));
        echo CHtml::link('Twitter connect', '', $this->getTagOptions());
        echo CHtml::closeTag('div');
    }

    /**
     * Render the box twitter template.
     */
    public function renderBox()
    {
        echo CHtml::openTag('div', array('class' => 'twitter_box'));
        echo CHtml::button('button', $this->getTagOptions());
        echo CHtml::closeTag('div');
    }
    /**
     * Set the button width.
     * @param integer $value The width of the Twitter button.
    */
    public function setWidth($value)
    {
        $this->getOptions()->add('width', $value);
    }

    /**
     * Set the button text.
     * @param string $value set tweet button text.
     */
    public function setText($value)
    {
        $this->getOptions()->add('value', $value);
    }

    /**
     * Set the button css style.
     * @param array $params set css styles.
    */
    public function setStyle(array $params = array())
    {
        $str = '';
        foreach ($params as $param => $val)
        {
            $str .= $param . ':' . $val . ';';
        }
        $this->getOptions()->add('style', $str);
    }

    /**
     * Register configuration scripts.
     * This method register the configuration scripts.
     */
    protected function registerConfigurationScripts()
    {
        Yii::setPathOfAlias('socialplugins', dirname(__FILE__));
        $url = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.socialplugins.assets'),
                        false, -1, YII_DEBUG);

        $cs = Yii::app()->clientScript
                        // Config script.
                        ->registerScriptFile($url . '/configure.js')
                        ->registerCssFile($url . '/twitter.css')
                        // Required depencies.
                        ->registerCoreScript('jquery')
                        ->registerCoreScript('jquery.ui');
    }

}

