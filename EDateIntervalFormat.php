<?php

/**
 * Format date intervals in a language-independent manner.
 *
 * @author Ianaré Sévi
 * @license http://http://www.gnu.org/copyleft/lesser.html LGPL
 * @copyright © 2013 Digitick, S.A.
 */
class EDateIntervalFormat
{
	/**
	 * @var boolean Whether to display the time.
	 */
	public $showTime = false;
	/**
	 * @var string Interval separator.
	 */
	public $separator = ' – ';
	/**
	 * @var string Width of the date pattern.
	 */
	protected $dateWidth = 'medium';
	/**
	 * @var DateTime
	 */
	protected $start;
	/**
	 * @var DateTime
	 */
	protected $end;
	/**
	 * @var CDateFormatter 
	 */
	protected $df;
	/**
	 * @var CLocale
	 */
	private $_locale;

	/**
	 * @param DateTime $start
	 * @param DateTime $end
	 */
	public function __construct(DateTime $start, DateTime $end)
	{
		$this->setStartDateTime($start);
		$this->setEndDateTime($end);
		
		$this->_locale = Yii::app()->getLocale();
		$this->df = Yii::app()->dateFormatter;
	}
	
	/**
	 * @param DateTime $start
	 */
	public function setStartDateTime(DateTime $start)
	{
		$this->start = $start;
	}
	
	/**
	 * @param DateTime $end
	 */
	public function setEndDateTime(DateTime $end)
	{
		$this->end = $end;
	}
	
	/**
	 * @param string Width of the date pattern. It can be 'long' or 'medium'.
	 * @throws CException
	 */
	public function setdateWidth($width)
	{
		if (!in_array($width, array('medium', 'long')))
				throw new CException("Invalid date format: $width");
				
		$this->dateWidth = $width;
	}

	public function __toString()
	{
		if ($this->showTime)
			return $this->getFormatDateTime();
		else
			return $this->getFormatDate();
	}

	/**
	 * @return string Formated date and time interval.
	 */
	public function getFormatDateTime()
	{
		$diffs = $this->getDiffs();
		
		// only time differs
		if (!$diffs['y'] && !$diffs['m'] && !$diffs['d']) {
			return $this->formatDateTime($this->start, $this->dateWidth, 'short')
					. $this->separator
					. $this->formatDateTime($this->end, false, 'short');
		}
		else {
			return $this->formatDateTime($this->start, $this->dateWidth, 'short')
					. $this->separator
					. $this->formatDateTime($this->end, $this->dateWidth, 'short');
		}
	}

	/**
	 * @return string Formated date interval.
	 */
	public function getFormatDate()
	{
		$diffs = $this->getDiffs();
		
		// year is different
		if ($diffs['y']) {
			return $this->formatDate($this->start)
					. $this->separator
					. $this->formatDate($this->end);
		}
		// month is different
		elseif ($diffs['m']) {
			return $this->getDateFormatMonth($this->start)
					. $this->separator
					. $this->formatDate($this->end);
		}
		// day is different
		elseif ($diffs['d'])
			return $this->getDateFormatDay($this->start, $this->end);
		// no difference
		else
			return $this->formatDate($this->start);
	}

	/**
	 * 
	 * @param DateTime $datetime
	 * @return string
	 */
	protected function getDateFormatMonth(DateTime $datetime)
	{
		$localeFormat = $this->_locale->getDateFormat($this->dateWidth);
		
		// remove the year
		$format = trim(preg_replace('@[,y]@', '', $localeFormat));

		return $this->df->format($format, $datetime->getTimestamp());
	}

	/**
	 * 
	 * @param DateTime $start
	 * @param DateTime $end
	 * @return string
	 */
	protected function getDateFormatDay(DateTime $start, DateTime $end)
	{
		$localeFormat = $this->_locale->getDateFormat($this->dateWidth);

		// get the days interval
		$days = $this->df->format('d', $start->getTimestamp())
				. $this->separator
				. $this->df->format('d', $end->getTimestamp());
		
		// replace day with days interval
		$format = str_replace('d', $days, $localeFormat);

		return $this->df->format($format, $end->getTimestamp());
	}

	/**
	 * @param DateTime $datetime
	 * @param type $dateWidth
	 * @param type $timeWidth
	 * @return string
	 */
	protected function formatDateTime(DateTime $datetime, $dateWidth, $timeWidth)
	{
		return $this->df->formatDateTime($datetime->getTimestamp(), $dateWidth, $timeWidth);
	}
	
	/**
	 * @param DateTime $datetime
	 * @param type $dateWidth
	 * @return string
	 */
	protected function formatDate(DateTime $datetime)
	{
		return $this->df->formatDateTime($datetime->getTimestamp(), $this->dateWidth, false);
	}

	/**
	 * Get the differences between two dates.
	 * @return array
	 */
	protected function getDiffs()
	{
		$start = explode('-', $this->start->format('Y-m-d-H-i-s'));
		$end = explode('-', $this->end->format('Y-m-d-H-i-s'));

		$diffs = array(
			'y' => ($start[0] != $end[0]),
			'm' => ($start[1] != $end[1]),
			'd' => ($start[2] != $end[2]),
			'h' => ($start[3] != $end[3]),
			'i' => ($start[4] != $end[4]),
			's' => ($start[5] != $end[5])
		);

		return $diffs;
	}

}
