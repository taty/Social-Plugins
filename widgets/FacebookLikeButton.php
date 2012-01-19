<?php
/**
 * FacebookLikeButton class file.
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 */

/**
 * FacebookLikeButton represents an ...
 *
 * Description of FacebookLikeButton
 *
 * @package
 * @since 1.1.7
 */
class FacebookLikeButton extends CWidget
{
    const API_SCRIPT_URL = 'http://connect.facebook.net/';

    const API_SCRIPT_FILE = 'all.js';

    /**
     * @var string Facebook application ID.
     */
    public $appId;

    /**
     * @var string language code.
     */
    public $language = 'en_US';

    /**
     * @var boolean use HTML5 or XFBML tags for widget.
     */
    public $html = false;

    /**
     * @var array default widget options
     */
    private $_options = array(
        'href'=>'',
        'send'=>'false',
        'layout'=>'box_count',
        'width'=>'',
        'show_faces'=>'true',
        'font'=>'',
    );

    /**
     * @var array possible button layout styles
     */
    private $_layoutStyles = array(
        'standard',
        'button_count',
        'box_count'
    );

    public function __construct($owner=null)
    {
        parent::__construct($owner);
        $this->_options = new CMap($this->_options, false);
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        Yii::app()->clientScript
                  ->registerScriptFile($this->getScriptFile(), CClientScript::POS_END);
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
//        echo CHtml::tag('div', array(
//            'id'=>'fb-root'
//        ));

        echo CHtml::tag($this->tagName, $this->getTagOptions());
    }

    /**
     * @return CMAp widget options map
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * @param mixed $value The URL to like. The XFBML version defaults to the current page.
     */
    public function setHref($value)
    {
        if (false !== is_array($value))
        {
            $value = CHtml::normalizeUrl($value);
        }
        $this->getOptions()->add('href', $value);
    }

    /**
     * @param boolean $value specifies whether to include a Send button with the Like button. This only works with the XFBML version.
     */
    public function setSend($value)
    {
         $this->getOptions()->add('send', true === CPropertyValue::ensureBoolean($value) ? 'true' : 'false');
    }

    /**
     * Set button layout style. There are three options:
     * <ul>
     * <li>standard - displays social text to the right of the button and friends' profile photos below. Minimum width: 225 pixels. Default width: 450 pixels. Height: 35 pixels (without photos) or 80 pixels (with photos).</li>
     * <li>button_count - displays the total number of likes to the right of the button. Minimum width: 90 pixels. Default width: 90 pixels. Height: 20 pixels.</li>
     * <li>box_count - displays the total number of likes above the button. Minimum width: 55 pixels. Default width: 55 pixels. Height: 65 pixels.</li>
     * </ul>
     * @param string $value
     */
    public function setLayoutStyle($value)
    {
        if (false === in_array($value, $this->_layoutStyles))
        {
            throw new CException(Yii::t(__CLASS__.'.general','Invalid layout style value "{value}". Please make sure it is among ({enum}).',
                array('{value}'=>$value, '{enum}'=>implode(', ',$this->_layoutStyles))));
        }
        $this->getOptions()->add('layout', $value);
    }

    /**
     * @param integer $value the width of the Like button.
     */
    public function setWidth($value)
    {
        $this->getOptions()->add('width', $value);
    }

    /**
     * @param boolean $value Specifies whether to display profile photos below the button (standard layout only).
     */
    public function setShowFaces($value)
    {
        $this->getOptions()->add('show_faces', $value);
    }

    /**
     * @param string $value the verb to display on the button. Options: 'like', 'recommend'.
     */
    public function setRecommend($value)
    {
        if ('recommend' === $value)
            $this->getOptions()->add('action', 'recommend');
        else
            $this->getOptions()->remove('action');
    }

    /**
     * The color scheme for the like button. Options: 'light', 'dark'.
     * @param string $value
     */
    public function setColorScheme($value)
    {
        $this->getOptions()->add('colorscheme', $value);
    }

    /**
     * @param string $value The font to display in the button.
     * Options: 'arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana'.
     */
    public function setFont($value)
    {
        $this->getOptions()->add('font', $value);
    }

    /**
     * @return string Script file name
     */
    public function getScriptFile()
    {
        $options = array_filter(array(
            'appId' => $this->appId,
            'xfbml' => 1,
        ));

        return  self::API_SCRIPT_URL
                . '/'
                . $this->language
                . '/'
                . self::API_SCRIPT_FILE
                . '#'
                . http_build_query($options);
    }

    /**
     * Returns the widget tag name. 
     * @return string
     */
    public function getTagName()
    {
        return $this->html ? 'div' : 'fb:like';
    }

    /**
     * @return array widget tag options
     */
    private function getTagOptions()
    {
        if (true === CPropertyValue::ensureBoolean($this->html))
        {
            $options = array('class'=>'fb-like');
            foreach($this->options as $key=>$value)
            {
                $options['data-'.$key] = $value;
            }
            return $options;
        }
        return $this->getOptions()->toArray();
    }
}