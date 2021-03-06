yii-date-interval-format
===================

Yii extension to format a date interval into text as compactly as possible.

Should work with any language which has date and time definitions in Yii.

The time may also be shown, and the date format can be either 'medium' or 'long'.

##Usage
```php
// Initial start and end date-times.
$partyStart = new DateTime('2012-12-25 18:00');
$partyEnd = new DateTime('2012-12-26 04:00');

// Instantiate the interval format.
$interval = new EDateIntervalFormat($partyStart, $partyEnd);

// Optionaly, set the date width: 'medium' (default) or 'long'.
$interval->setdateWidth('long');

// Two ways to output the formated interval with time:

// 1) Set the showTime variable and print.
$interval->showTime = true;
echo $interval;
$interval->showTime = false;
echo $interval;

// 2) Choose the formating function directly.
echo $interval->getFormatDateTime();
echo $interval->getFormatDate();

// You may keep the same formater object and set the start or end date-time.
// Also, the start time may not necessarily be before the end time.
$now = new DateTime('1985-10-26 01:22');
$testTimeMachine = new DateTime('1955-11-05 01:21');
$interval->setStartDateTime($now);
$interval->setEndDateTime($testTimeMachine);
echo $interval;

```

##Examples

###Code
```php
Yii::import('ext.interval-format.EDateIntervalFormat');

$interval = new EDateIntervalFormat(new DateTime('2012-12-25 12:10'), new DateTime('2012-12-25 15:30'));
print "$interval\n";

$interval = new EDateIntervalFormat(new DateTime('2012-11-25 15:30'), new DateTime('2012-11-26 02:00'));
print "$interval\n";

$interval = new EDateIntervalFormat(new DateTime('2012-11-25 10:05'), new DateTime('2012-12-01 10:05'));
print "$interval\n";

$interval = new EDateIntervalFormat(new DateTime('2012-12-25 12:10'), new DateTime('2013-01-01 15:30'));
print "$interval\n";

print "\n---- Show Time ----\n\n";

$interval = new EDateIntervalFormat(new DateTime('2012-12-25 12:10'), new DateTime('2012-12-25 15:30'));
$interval->showTime = true;
print "$interval\n";

$interval = new EDateIntervalFormat(new DateTime('2012-11-25 15:30'), new DateTime('2012-11-26 02:00'));
$interval->showTime = true;
print "$interval\n";

$interval = new EDateIntervalFormat(new DateTime('2012-11-25 10:05'), new DateTime('2012-12-01 10:05'));
$interval->showTime = true;
print "$interval\n";

$interval = new EDateIntervalFormat(new DateTime('2012-12-25 12:10'), new DateTime('2013-01-01 15:30'));
$interval->showTime = true;
print "$interval\n";
```

###Output

French
```
25 déc. 2012
25 – 26 nov. 2012
25 nov. – 1 déc. 2012
25 déc. 2012 – 1 janv. 2013

---- Show Time ----

25 déc. 2012 12:10 – 15:30
25 nov. 2012 15:30 – 26 nov. 2012 02:00
25 nov. 2012 10:05 – 1 déc. 2012 10:05
25 déc. 2012 12:10 – 1 janv. 2013 15:30
```

American English
```
Dec 25, 2012
Nov 25 – 26, 2012
Nov 25 – Dec 1, 2012
Dec 25, 2012 – Jan 1, 2013

---- Show Time ----

Dec 25, 2012 12:10 PM – 3:30 PM
Nov 25, 2012 3:30 PM – Nov 26, 2012 2:00 AM
Nov 25, 2012 10:05 AM – Dec 1, 2012 10:05 AM
Dec 25, 2012 12:10 PM – Jan 1, 2013 3:30 PM
```

British English
```
25 Dec 2012
25 – 26 Nov 2012
25 Nov – 1 Dec 2012
25 Dec 2012 – 1 Jan 2013

---- Show Time ----

25 Dec 2012 12:10 – 15:30
25 Nov 2012 15:30 – 26 Nov 2012 02:00
25 Nov 2012 10:05 – 1 Dec 2012 10:05
25 Dec 2012 12:10 – 1 Jan 2013 15:30
```
