<?php
/**
 * PHPWord
 *
 * @link        https://github.com/PHPOffice/PHPWord
 * @copyright   2014 PHPWord
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt LGPL
 */

namespace PhpOffice\PhpWord\Style;

use PhpOffice\PhpWord\Exception\InvalidStyleException;

/**
 * Paragraph style
 */
class Paragraph
{
    const LINE_HEIGHT = 240;

    /**
     * Text line height
     *
     * @var int
     */
    private $lineHeight;

    /**
     * Paragraph alignment
     *
     * @var string
     */
    private $align;

    /**
     * Space before Paragraph
     *
     * @var int
     */
    private $spaceBefore;

    /**
     * Space after Paragraph
     *
     * @var int
     */
    private $spaceAfter;

    /**
     * Spacing between breaks
     *
     * @var int
     */
    private $spacing;

    /**
     * Set of Custom Tab Stops
     *
     * @var array
     */
    private $tabs;

    /**
     * Indent by how much
     *
     * @var int
     */
    private $indent;

    /**
     * Hanging by how much
     *
     * @var int
     */
    private $hanging;

    /**
     * Parent style
     *
     * @var string
     */
    private $basedOn = 'Normal';

    /**
     * Style for next paragraph
     *
     * @var string
     */
    private $next;

    /**
     * Allow first/last line to display on a separate page
     *
     * @var bool
     */
    private $widowControl = true;

    /**
     * Keep paragraph with next paragraph
     *
     * @var bool
     */
    private $keepNext = false;

    /**
     * Keep all lines on one page
     *
     * @var bool
     */
    private $keepLines = false;

    /**
     * Start paragraph on next page
     *
     * @var bool
     */
    private $pageBreakBefore = false;

    /**
     * Set style by array
     *
     * @param array $style
     * @return $this
     */
    public function setArrayStyle(array $style = array())
    {
        foreach ($style as $key => $value) {
            if ($key === 'line-height') {
                null;
            } elseif (substr($key, 0, 1) == '_') {
                $key = substr($key, 1);
            }
            $this->setStyleValue($key, $value);
        }

        return $this;
    }

    /**
     * Set Style value
     *
     * @param string $key
     * @param mixed $value
     */
    public function setStyleValue($key, $value)
    {
        if (substr($key, 0, 1) == '_') {
            $key = substr($key, 1);
        }
        if ($key == 'indent' || $key == 'hanging') {
            $value = $value * 720;
        } elseif ($key == 'spacing') {
            $value += 240; // because line height of 1 matches 240 twips
        } elseif ($key === 'line-height') {
            $this->setLineHeight($value);
            return;
        }
        $method = 'set' . $key;
        if (method_exists($this, $method)) {
            $this->$method($value);
        }
    }

    /**
     * Get Paragraph Alignment
     *
     * @return string
     */
    public function getAlign()
    {
        return $this->align;
    }

    /**
     * Set Paragraph Alignment
     *
     * @param string $pValue
     * @return \PhpOffice\PhpWord\Style\Paragraph
     */
    public function setAlign($pValue = null)
    {
        if (strtolower($pValue) == 'justify') {
            // justify becames both
            $pValue = 'both';
        }
        $this->align = $pValue;
        return $this;
    }

    /**
     * Get Space before Paragraph
     *
     * @return integer
     */
    public function getSpaceBefore()
    {
        return $this->spaceBefore;
    }

    /**
     * Set Space before Paragraph
     *
     * @param int $pValue
     * @return \PhpOffice\PhpWord\Style\Paragraph
     */
    public function setSpaceBefore($pValue = null)
    {
        $this->spaceBefore = $pValue;
        return $this;
    }

    /**
     * Get Space after Paragraph
     *
     * @return integer
     */
    public function getSpaceAfter()
    {
        return $this->spaceAfter;
    }

    /**
     * Set Space after Paragraph
     *
     * @param int $pValue
     * @return \PhpOffice\PhpWord\Style\Paragraph
     */
    public function setSpaceAfter($pValue = null)
    {
        $this->spaceAfter = $pValue;
        return $this;
    }

    /**
     * Get Spacing between breaks
     *
     * @return int
     */
    public function getSpacing()
    {
        return $this->spacing;
    }

    /**
     * Set Spacing between breaks
     *
     * @param int $pValue
     * @return \PhpOffice\PhpWord\Style\Paragraph
     */
    public function setSpacing($pValue = null)
    {
        $this->spacing = $pValue;
        return $this;
    }

    /**
     * Get indentation
     *
     * @return int
     */
    public function getIndent()
    {
        return $this->indent;
    }

    /**
     * Set indentation
     *
     * @param int $pValue
     * @return \PhpOffice\PhpWord\Style\Paragraph
     */
    public function setIndent($pValue = null)
    {
        $this->indent = $pValue;
        return $this;
    }

    /**
     * Get hanging
     *
     * @return int
     */
    public function getHanging()
    {
        return $this->hanging;
    }

    /**
     * Set hanging
     *
     * @param int $pValue
     * @return \PhpOffice\PhpWord\Style\Paragraph
     */
    public function setHanging($pValue = null)
    {
        $this->hanging = $pValue;
        return $this;
    }

    /**
     * Get tabs
     *
     * @return \PhpOffice\PhpWord\Style\Tabs
     */
    public function getTabs()
    {
        return $this->tabs;
    }

    /**
     * Set tabs
     *
     * @param array $pValue
     * @return \PhpOffice\PhpWord\Style\Paragraph
     */
    public function setTabs($pValue = null)
    {
        if (is_array($pValue)) {
            $this->tabs = new Tabs($pValue);
        }
        return $this;
    }

    /**
     * Get parent style ID
     *
     * @return  string
     */
    public function getBasedOn()
    {
        return $this->basedOn;
    }

    /**
     * Set parent style ID
     *
     * @param   string $pValue
     * @return  \PhpOffice\PhpWord\Style\Paragraph
     */
    public function setBasedOn($pValue = 'Normal')
    {
        $this->basedOn = $pValue;
        return $this;
    }

    /**
     * Get style for next paragraph
     *
     * @return string
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * Set style for next paragraph
     *
     * @param   string $pValue
     * @return  \PhpOffice\PhpWord\Style\Paragraph
     */
    public function setNext($pValue = null)
    {
        $this->next = $pValue;
        return $this;
    }

    /**
     * Get allow first/last line to display on a separate page setting
     *
     * @return  bool
     */
    public function getWidowControl()
    {
        return $this->widowControl;
    }

    /**
     * Set keep paragraph with next paragraph setting
     *
     * @param   bool $pValue
     * @return  \PhpOffice\PhpWord\Style\Paragraph
     */
    public function setWidowControl($pValue = true)
    {
        if (!is_bool($pValue)) {
            $pValue = true;
        }
        $this->widowControl = $pValue;
        return $this;
    }

    /**
     * Get keep paragraph with next paragraph setting
     *
     * @return  bool
     */
    public function getKeepNext()
    {
        return $this->keepNext;
    }

    /**
     * Set keep paragraph with next paragraph setting
     *
     * @param   bool $pValue
     * @return  \PhpOffice\PhpWord\Style\Paragraph
     */
    public function setKeepNext($pValue = false)
    {
        if (!is_bool($pValue)) {
            $pValue = false;
        }
        $this->keepNext = $pValue;
        return $this;
    }

    /**
     * Get keep all lines on one page setting
     *
     * @return  bool
     */
    public function getKeepLines()
    {
        return $this->keepLines;
    }

    /**
     * Set keep all lines on one page setting
     *
     * @param   bool $pValue
     * @return  \PhpOffice\PhpWord\Style\Paragraph
     */
    public function setKeepLines($pValue = false)
    {
        if (!is_bool($pValue)) {
            $pValue = false;
        }
        $this->keepLines = $pValue;
        return $this;
    }

    /**
     * Get start paragraph on next page setting
     *
     * @return bool
     */
    public function getPageBreakBefore()
    {
        return $this->pageBreakBefore;
    }

    /**
     * Set start paragraph on next page setting
     *
     * @param   bool $pValue
     * @return  \PhpOffice\PhpWord\Style\Paragraph
     */
    public function setPageBreakBefore($pValue = false)
    {
        if (!is_bool($pValue)) {
            $pValue = false;
        }
        $this->pageBreakBefore = $pValue;
        return $this;
    }

    /**
     * Set the line height
     *
     * @param int|float|string $lineHeight
     * @return $this
     * @throws \PhpOffice\PhpWord\Exception\InvalidStyleException
     */
    public function setLineHeight($lineHeight)
    {
        if (is_string($lineHeight)) {
            $lineHeight = floatval(preg_replace('/[^0-9\.\,]/', '', $lineHeight));
        }

        if ((!is_integer($lineHeight) && !is_float($lineHeight)) || !$lineHeight) {
            throw new InvalidStyleException('Line height must be a valid number');
        }

        $this->lineHeight = $lineHeight;
        $this->setSpacing($lineHeight * self::LINE_HEIGHT);
        return $this;
    }

    /**
     * Get line height
     *
     * @return int|float
     */
    public function getLineHeight()
    {
        return $this->lineHeight;
    }
}
