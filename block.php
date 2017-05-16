<?php

function spacing() {
	return sprintf('<div class="spacing">&nbsp;</div>');
}

function equation_form() {

	$numbers = array( '', '' );

	if ($querystrings = $_GET) {
		if (isset($querystrings['eq'])) {
			$equation = array_map('intval', explode(',', strval($querystrings['eq'])));
			$numbers[0] = 'value="'.($equation[0] > 20 ? 0 : $equation[0]).'"';
			$numbers[1] = 'value="'.($equation[1] > 20 ? 0 : $equation[1]).'"';
		}
	}

	return sprintf('
			<div class="col-md-2">
				<input id="num1" type="number" class="form-control" %1$s>
			</div>
			<div class="col-md-1 text-center">
				<label>+</label>
			</div>
			<div class="col-md-2">
				<input id="num2" type="number" class="form-control" %2$s>
			</div>
			<button id="equationbutton" type="submit" class="btn btn-default">Update Equation!</button>
			
		', $numbers[0], $numbers[1]);
}

function operator_block($operator = true) {
	$innerhtml = '&nbsp;';
	
	if ($operator) {
		$innerhtml = '+';
	}

	return sprintf('
				<div class="col-md-1 text-center">%1$s</div>
			', $innerhtml);
}

function create_block($position, $number = 5, $class = '') {

	$circles = array();

	for ($i = 0; $i < 5; $i++) {
		if ($number > 0) {
			array_push($circles, '<div class="circle no-hide">&nbsp;</div>');
		} else {
			array_push($circles, '<div class="circle hide-circle">&nbsp;</div>');
		}
		$number--;
	}

	return sprintf('
		<div class="col-md-2 %7$s">
			<div class="col-md-1 left %1$s blockcell">
				%2$s
			</div>
			<div class="col-md-1 middle %1$s blockcell">
				%3$s
			</div>
			<div class="col-md-1 middle %1$s blockcell">
				%4$s
			</div>
			<div class="col-md-1 middle %1$s blockcell">
				%5$s
			</div>
			<div class="col-md-1 right %1$s blockcell">
				%6$s
			</div>
		</div>
	', $position, $circles[0], $circles[1], $circles[2], $circles[3], $circles[4], $class);
}

function break_number_into_tens($number) {
	if ($number < 10) {
		return array( $number );
	}

	$numbers = $number / 10;

	if (is_int($numbers)) {
		// number is 10
		return array( $numbers * 10 );
	}

	$counters = array_map('intval', explode('.', strval($numbers)));
	$counters[0] = $counters[0] * 10;

	return $counters;
}

function number_of_circles_to_fill($number, $bottom = true) {
	$number = (int)$number;

	if ($number == 0) {
		return 0;
	}

	if ($number == 5 && !$bottom) {
		return 5;
	}

	if ($number == 5 && $bottom) {
		return 0;
	}

	if ($number % 2 == 0) {
		return $number / 2;
	}


	
	$mod = $number % 5;

	if ($number > 5 && $bottom) {
		return $mod;
	}

	if ($number <= 5 && !$bottom) {
		return $number;
	}

	if ($bottom && $number <= 5) {
		return 0;
	}

	return 5;
}