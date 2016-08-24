# EverySecond Framework
by Matthew Evans (matt @ putu)

# Table of contents
1. What is it?
2. Demo (an example use case)
3. Why should I use it?
4. Documentation

# What is it?

This is a pretty simple "framework" to help create a list of repeating timers that don't require any JavaScript.

# Demo (an example use case)

# Why should I use it?

It might be easier to use than something else maybe.

# Documentation

## class EverySecond
Generates a list of timers from a given data source.

### constructor EverySecond($config)
#### $config : array
Keys:
- __id__: a unique identifier for the list. This must be different to other EverySecond timer lists, or else the CSS definitions will clash.
- __dataFile__: the path to the data file we want to use (JSON).
- __per__: defines what the timer's based on. Y = year, D = day.
- __transitionTime__: the duration of the transition from the *resting* state to the *showing* state. (seconds)
- __showDuration__: how long the loop should remain in the *showing* state. (seconds)
- __restingCSS__: PHP array representation of the CSS for the *resting* state.
- __showingCSS__: PHP array representation of the CSS for the *showing* state.

__Defaults:__
```
[
	'id' => 'everySecond',
	'dataFile' => 'data.json',
	'per' => 'Y',
	'transitionTime' => 0.2,
	'showDuration' => 2.5,
	'restingCSS' => [],
	'showingCSS' => []
]
```

### public function render($random, $customKeys) : void
#### $random : bool
Determines whether or not the list should be displayed in a random order. 
#### $customKeys : array
Gives the ability to have a custom data file structure: each element of the array must be a *key-value* pair. The key defines a variable name (__title__ and __delay__ are *required*) and the value defines which index per row in the data file corresponds to that variable.

Example:

```
data.json:

{
	// title, delay, colour
	["timerTitle", 0.2, "#f09"],
	...
}
```
```
index.php:

...
$everySecondGenerator = new EverySecond([
	...
]);

$everySecondGenerator->render([
	'title => 0,
	'delay' => 1,
	'colour' > 2
], true);
```

### public function setConfig($config) : void
Sets the config to *$config*

#### $config : array
The config to be set. See *constructor EverySecond* for more details.

### public function getConfig() : array
Returns the configuration array.

### private function setTimeFunction($per) : void
#### $per : char
Returns the time in seconds that __$per__ refers to.

### private function loadData() : void
Loads the data from the specified data file into the data member.

## class CSSTimer
Creates a DOM object from a template with an automatically-generated CSS animation definition for the delay loop.

### constructor CSSTimer($config)
#### $config : array
Configures the timer.

Keys:
- __id__: a unique identifier for the list. This must be different to other EverySecond timer, or else the CSS definitions will clash.
- __title__: the title for the timer
- __delay__: how often the timer hsould be in the *showing* state. (seconds)
- __transitionTime__: the duration of the transition from the *resting* state to the *showing* state. (seconds)
- __showDuration__: how long the loop should remain in the *showing* state. (seconds)
- __restingCSS__: PHP array representation of the CSS for the *resting* state.
- __showingCSS__: PHP array representation of the CSS for the *showing* state.
- __template__ (optional): a custom template for the timer.

Defaults:
```
[
	'id' => 'everySecondItem',
	'title' => 'EverySecond Item',
	'delay' => 60.0,
	'transitionTime' => 0.2,
	'showDuration' => 2.5,
	'restingCSS' => [],
	'showingCSS' => [],
	'template' => '
	<div class="es-timer">
		<div class="es-timer__body" style="animation: animation_{{ id }} {{ delay }}s infinite;">
			<div class="es-timer__title">
				{{ title }}
			</div>
			<div class="es-loading-bar es-timer__loading-bar" style="animation-duration: {{ delay }}s;">
				<div class="es-loading-bar__text">Every {{ delay }}s</div>
			</div>
		</div>
	</div>'
]
```

### public function render() : void
Renders the CSS rules and HTML for the timer after processing the template.

### public function setConfig($config) : void
Sets the config for the timer.

#### $config : array
The configuration array. See *constructor CSSTimer($config)* for default values.

### public function getConfig() : array
Returns the timer's config array.

### public function renderCSS($styleTags = true) : string
Returns a string representation of the CSS definitions of the timer's animation loop's keyframes.
#### $styleTags : bool
Determines whether or not the output should be wrapped within `<style></style>` tags.

### private function renderTemplate() : string
Returns a string representation of the HTML for the timer.


## class DataReader

### public function read($path) : array
Returns a list from a JSON array.
```
{
	["title", 0.5],
	...
}
```
becomes
```
[
	["title", 0.5],
	...
]
```

## class Fwigger
A simple class for parsing templates.

### public function simpleParse($html, $context) : string
Parses template variables into their values defined in the context.

#### $html : string
The template HTML to be parsed.

#### $context : array
An array containing the template's variables' values as key => value pairs.

__Usage__

```
{{ variable }}

or

{{variable}}

(spaces don't matter)
```

```
$fwigger = new Fwigger();

$html = '
	<p>{{myText}}</p>
	<p>{{ subText }}</p>
';
$context = [
	'myText' => 'Hello, world!',
	'subText => 'This is sample text.'
];

echo $fwigger->simpleParse($html, $context); 
```
will output
> Hello, world!<br />
> This is sample text.

### public function parse($html, $context = []) : string
Parses template variables into their values defined in the context, but allows for "filters" to be applied to them.

#### $html : string
The template HTML to be parsed.

#### $context : array
An array containing the template's variables' values as key => value pairs.


__Usage__

```
{{ variable | functionName(params ..., $v = variable, params ...) }}

(spaces don't matter)
```
*variable* is the value from the context

```
$fwigger = new Fwigger();

$html = '
	<p>{{theNumber | round($v, 2)}}</p>
	<p>{{ subText | strtoupper($v) }}</p>
';
$context = [
	'theNumber' => 3.1415,
	'subText => 'This is sample text.'
];

echo $fwigger->simpleParse($html, $context); 
```
will output
> Hello, world!<br />
> This is sample text.

### public function parseCSSArray($cssArray : array) : string
Transforms an array representation of CSS properties/values into a string representation.
#### $array : array
The array containing the property-value pairs.

Usage example:
```
$fwigger = new Fwigger();

$theCSSArray = [
	'background' => 'pink',
	'color' => '#fff',
	'font' => [
		size: '12pt',
		family: 'Arial'
	]
];

echo $fwigger-parseCSSArray($theCSSArray);

```

will output

```

background: pink;
color: #fff;
font-size: 12pt;
font-family: Arial;

```