<?php
/**
 * GooglePlusoneButton class file.
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 */

/**
 * GooglePlusoneButton represents an ...
 *
 * Description of GooglePlusoneButton
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 * @version $Id$
 * @package
 * @since 1.1.7
 */
class GooglePlusoneButton extends CWidget
{
    const API_SCRIPT_URL = 'https://apis.google.com/js/plusone.js';

    const DEFAULT_ANNOTATION = 'bubble';

    /**
     * @var boolean use HTML5 or standard +1 tag syntax for widget.
     */
    public $html = false;

    private $_sizeEnum = array(
        'small',
        'medium',
        'standard',
        'tall'
    );

    private $_annotationEnum = array(
        'none',
        'bubble',
        'inline',
    );

    private $_expandToEnum = array(
        'top',
        'right',
        'bottom',
        'left'
    );


    /**
     * @var array default widget options
     */
    private $_options = array();

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
                  ->registerScriptFile(self::API_SCRIPT_URL, CClientScript::POS_END);
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        echo CHtml::tag($this->tagName, $this->getTagOptions());
    }

    /**
     * Returns the widget tag name.
     * @return string
     */
    public function getTagName()
    {
        return $this->html ? 'div' : 'g:plusone';
    }

    /**
     * @return CMAp widget options map
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * The URL to +1. Set this attribute when you have a +1 button next to an item description for another
     * page and want the button to +1 the referenced page (not the current page).
     * @param mixed $value
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
     * The button size to render. There are 4 options:
     * <ul>
     * <li>small</li>
     * <li>medium</li>
     * <li>standard</li>
     * <li>tall</li>
     * </ul>
     * @see https://developers.google.com/+/plugins/+1button/#button-sizes
     * @param string $value
     */
    public function setSize($value)
    {
        if (false === in_array($value, $this->_sizeEnum))
        {
            throw new CException(Yii::t(__CLASS__.'.general','Invalid size value "{value}". Please make sure it is among ({enum}).',
                array('{value}'=>$value, '{enum}'=>implode(', ',$this->_sizeEnum))));
        }
        $this->getOptions()->add('size', $value);
    }

    /**
     * Set button layout style. There are three options:
     * <ul>
     * <li>none - do not render any additional annotations.</li>
     * <li>button_count - display the number of users who have +1'd the page in a graphic next to the button.</li>
     * <li>box_count - display profile pictures of connected users who have +1'd the page and a count of users who have +1'd the page.</li>
     * </ul>
     * @param string $value
     */
    public function setAnnotation($value)
    {
        if (false === in_array($value, $this->_annotationEnum))
        {
            throw new CException(Yii::t(__CLASS__.'.general','Invalid annotation value "{value}". Please make sure it is among ({enum}).',
                array('{value}'=>$value, '{enum}'=>implode(', ',$this->_annotationEnum))));
        }
        $this->getOptions()->add('annotation', $value);
    }

    /**
     * @return string The current annotation value.
     * @see ZGooglePusoneButton::setAnnotation
     */
    public function getAnnotation()
    {
        if (false !== $this->getOptions()->contains('annotation'))
        {
            return $this->getOptions()->itemAt('annotation');
        }
        return self::DEFAULT_ANNOTATION;
    }

    public function setWidth($value)
    {
        $this->getOptions()->add('width', $value);
    }

    public function setExpandTo($value)
    {
        $this->getOptions()->add('expandTo', $value);
    }

    /**
     * @param boolean $value disable | enable count display
     */
    public function setCount($value)
    {
        $this->setAnnotation($value?$this->getAnnotation():'none');
    }

    /**
     * @return array widget tag options
     */
    private function getTagOptions()
    {
        if (true === CPropertyValue::ensureBoolean($this->html))
        {
            $options = array('class'=>'g-plusone');
            foreach($this->options as $key=>$value)
            {
                $options['data-'.$key] = $value;
            }
            return $options;
        }
        return $this->getOptions()->toArray();
    }
}