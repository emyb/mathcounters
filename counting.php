<?php
require_once('block.php');

// :poop:

$blockcounterstop = array(
	0, 0, 0, 0
);

$blockcountersbottom = array(
	0, 0, 0, 0
);

$blockclassestop = array(
	'b1', 'b2', 'b3', 'b4'
);

$blockclassesbottom = array(
	'b1', 'b2', 'b3', 'b4'
);

if ($querystrings = $_GET) {
	if (isset($querystrings['eq'])) {
		$equation = array_map('intval', explode(',', $querystrings['eq']));

		if ($equation[0] > 20) {
			$alert = sprintf('<script>alert("do not use numbers higher than 20");</script>');
			$equation[0] = 0;
		}

		if ($equation[1] > 20) {
			$alert = sprintf('<script>alert("do not use numbers higher than 20");</script>');
			$equation[1] = 0;
		}

		if ($equation[0] <= 10) {
			$blockcounterstop[0] = number_of_circles_to_fill($equation[0], false);
			$blockcountersbottom[0] = number_of_circles_to_fill($equation[0]);
			$blockcounterstop[1] = 0;
			$blockcountersbottom[1] = 0;

			$blockclassestop[1] .= ' hide';
			$blockclassesbottom[1] .= ' hide';
		} 

		if ($equation[0] < 20 && $equation[0] > 10) {
			$numbercomponents = break_number_into_tens($equation[0]);
			$blockcounterstop[1] = number_of_circles_to_fill($numbercomponents[1], false);
			$blockcountersbottom[1] = number_of_circles_to_fill($numbercomponents[1]);
		}

		if ($equation[1] <= 10) {
			$blockcounterstop[2] = number_of_circles_to_fill($equation[1], false);
			$blockcountersbottom[2] = number_of_circles_to_fill($equation[1]);
			$blockcounterstop[3] = 0;
			$blockcountersbottom[3] = 0;

			$blockclassestop[3] .= ' hide';
			$blockclassesbottom[3] .= ' hide';
		} 

		if ($equation[1] < 20 && $equation[1] > 10) {
			$numbercomponents = break_number_into_tens($equation[1]);
			$blockcounterstop[3] = number_of_circles_to_fill($numbercomponents[1], false);
			$blockcountersbottom[3] = number_of_circles_to_fill($numbercomponents[1]);
		}

	}
}

?>

<html>
	<head>
		<title>math stuff</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

		<?php
		if (isset($alert)) {
			echo $alert;
		}
		?>

		<script>
			var eq1 = 0;
			var eq2 = 0;
			var eq1val = 0;
			var eq2val = 0;
			var eq1valchanges = 0;
			var eq2valchanges = 0;

			<?php
			if ($querystrings = $_GET) {
				if (isset($querystrings['eq'])) {
					$equation = array_map('intval', explode(',', $querystrings['eq']));
					echo 'eq1val = '.$equation[0].';'.PHP_EOL;
					echo "\t\t\teq2val = ".$equation[1].';'.PHP_EOL;
				}
			}
			?>

			function update_workings() {
				$('input#eq1').val(eq1);
				$('input#eq2').val(eq2);
				$('input#eq1-add').val(eq1val + ' + ' + eq1valchanges + ' = ' + eq1);
				$('input#eq2-sub').val(eq2val + ' - ' + eq2valchanges + ' = ' + eq2);			
			}

			$(document).ready(function() {

				// initialize the workings
				eq1 = $('div.b1, div.b2').children().not(':has(.hide-circle)').length;
				eq2 = $('div.b3, div.b4').children().not(':has(.hide-circle)').length;

				$('input#eq1').val(eq1);
				$('input#eq2').val(eq2);

				update_workings();

				$('div.b3 div.circle.no-hide, div.b4 div.circle.no-hide').removeClass('no-hide');
				$('div.b3 div.circle.hide-circle, div.b4 div.circle.hide-circle').addClass('no-hide');

				$('div.b1 div.circle, div.b2 div.circle, div.b3 div.circle, div.b4 div.circle').on('click', function() {
					if (($(this).closest('div.b1').hasClass('b1') || $(this).closest('div.b2').hasClass('b2') || $(this).closest('div.b3').hasClass('b3') || $(this).closest('div.b4').hasClass('b4')) && $(this).hasClass('no-hide')) {
						return;
					}

					if ($(this).hasClass('hide-circle')) {
						if ($(this).closest('div.b1').hasClass('b1') || $(this).closest('div.b2').hasClass('b2')) {
							eq1valchanges++;
						} else if ($(this).closest('div.b3').hasClass('b3') || $(this).closest('div.b4').hasClass('b4')) {
							eq2valchanges--;
						}
					} else {
						if ($(this).closest('div.b1').hasClass('b1') || $(this).closest('div.b2').hasClass('b2')) {
							eq1valchanges--;
						} else if ($(this).closest('div.b3').hasClass('b3') || $(this).closest('div.b4').hasClass('b4')) {
							eq2valchanges++;
						}
					}

					$(this).toggleClass('hide-circle');
				});

				$('div.b1').on('click', function() {
						eq1 = $('div.b1, div.b2').children().not(':has(.hide-circle)').length;
						update_workings();
				});

				$('div.b2').on('click', function() {
						eq1 = $('div.b1, div.b2').children().not(':has(.hide-circle)').length;
						update_workings();
				});

				$('div.b3').on('click', function() {
						eq2 = $('div.b3, div.b4').children().not(':has(.hide-circle)').length;
						update_workings();
				});

				$('div.b4').on('click', function() {
						eq2 = $('div.b3, div.b4').children().not(':has(.hide-circle)').length;
						update_workings();
				});

				$('button#equationbutton').on('click', function() {
					var num1 = parseInt($('input#num1').val());
					var num2 = parseInt($('input#num2').val());

					if (isNaN(num1) || isNaN(num2)) {
						alert("you have either given no number to calculate or tried to enter something that is NaN");
						return;
					}

					if (num1 > 20 || num2 > 20) {
						alert("please use numbers that are 20 and lower")
						return;
					}
					
					var url = window.location.protocol + '//' + window.location.hostname + window.location.pathname + '?eq=' + num1 + ',' + num2;
					
					window.location = url;
				});
			});
		</script>

		<style>

			div.circle.hide-circle {
				background-color: transparent;
			}

			.row .col-md-2 .col-md-1.left {
				border-left: 1px solid #ccc;
				border-top: 1px solid #ccc;
				border-bottom: 1px solid #ccc;
			}

			.row .col-md-2 .col-md-1.right {
				border: 1px solid #ccc;	
			}

			.row .col-md-2 .col-md-1.middle {
				border-left: 1px solid #ccc;
				border-top: 1px solid #ccc;
				border-bottom: 1px solid #ccc;
			}

			.row .col-md-2 .col-md-1.bottom {
				border-top: none;
			}

			section {
				padding-top: 50px;
			}

			.spacing {
				padding: 10px 0 10px 0;
			}

			div.circle {
				cursor:					pointer;

				margin:					1px 0 1px -10px;
			    width: 					20px;
			    height: 				20px;
			    background-color: 		#ccc;

			    -webkit-user-select:	none;
			    -moz-user-select:		none;

			    -webkit-border-radius: 	50px; /* Safari, Chrome */
			    -moz-border-radius: 	50px; /* Firefox */
	            border-radius: 			50px; /* CSS3 */
			}

			div.col-md-1.top.operator.right {
				border-bottom: 1px solid;
				border-bottom-width: 3px;
			}

			div.col-md-1.top.operator.left {
				border-bottom: 1px solid;
				border-bottom-width: 3px;
				
				border-right: 1px solid;
				border-right-width: 3px; 
			}

			div.col-md-1.bottom.operator.left {
				border-right: 1px solid;
				border-right-width: 3px; 
			}

		</style>
	</head>
	<body>
		<section>
			<div class="container">

				<?php echo spacing(); ?>

				<div class="row">
					<?php echo equation_form(); ?>
				</div>

				<?php echo spacing(); ?>

				<div class="row">
					
					<?php
					echo create_block("top", $blockcounterstop[0], $blockclassestop[0]);
					echo create_block("top", $blockcounterstop[1], $blockclassestop[1]);
					echo operator_block();
					echo create_block("top", $blockcounterstop[2], $blockclassestop[2]);
					echo create_block("top", $blockcounterstop[3], $blockclassesbottom[3]);
					?>

				</div>
				
				<div class="row">

					<?php 
					echo create_block("bottom", $blockcountersbottom[0], $blockclassesbottom[0]);
					echo create_block("bottom", $blockcountersbottom[1], $blockclassesbottom[1]);
					echo operator_block(false);
					echo create_block("bottom", $blockcountersbottom[2], $blockclassesbottom[2]);
					echo create_block("bottom", $blockcountersbottom[3], $blockclassesbottom[3]);
					?>

				</div>

				<?php echo spacing(); ?>

				<div class="row">
					<div class="col-md-2">
						<input id="eq1" type="number" class="form-control" disabled="disabled">
					</div>
					<div class="col-md-1 text-center">
						<label>+</label>
					</div>
					<div class="col-md-2">
						<input id="eq2" type="number" class="form-control" disabled="disabled">
					</div>
				</div>

				<?php echo spacing(); ?>

				<div class="row">
					<div class="col-md-2">
						<input id="eq1-add" type="text" class="form-control" disabled="disabled">
					</div>
					<div class="col-md-1 text-center">
						&nbsp;
					</div>
					<div class="col-md-2">
						<input id="eq2-sub" type="text" class="form-control" disabled="disabled">
					</div>
				</div>

			</div>
		</section>
	</body>
</html>
