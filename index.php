<?php 
	$str = file_get_contents('website-data.json');
	$json = json_decode($str, true);
	$json = $json[$_SERVER['HTTP_HOST']];
	
	if(isset($_POST['email-btn'])){
		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$json['google']['recaptcha-secret-key']."&response=".$_POST['g-recaptcha-response']);
		$vcaptcha = json_decode($response);

		if($vcaptcha->success && $vcaptcha->score > 0.5) {
			$content = "";
			foreach($json['form']['inputs'] as $input) {
				if(isset($input['required']) && $input['required'] == "yes" && empty($_POST[$input['name']])) {
					echo "please enter all required fields";
					break;
				}
				if(isset($_POST[$input['name']]))
					$content .= "\n" . $input['name'] . ": " . $_POST[$input['name']];
			}
			
			$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/";
			$target_file = $target_dir . basename($_FILES["upload"]["name"]);
			$total_files = count($_FILES['upload']['name']);
			$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/uploads/";
			$files = "";
			for($key = 0; $key < $total_files; $key++) {
				if(isset($_FILES['upload']['name'][$key])) {
					$original_filename = $_FILES['upload']['name'][$key];
					$target = $target_dir . basename($original_filename);
					$fileType = strtolower(pathinfo($original_filename,PATHINFO_EXTENSION));
					$target =  $target_dir . $name . "-".basename($original_filename)."-". date("his dmY") ."." . $fileType;
					
					$files .= $link . $name . "-".basename($original_filename)."-". date("his dmY") ."." . $fileType;
						
					$tmp  = $_FILES['upload']['tmp_name'][$key];
					if ($tmp > 500000) {
						echo "Sorry, your file is too large.";
					}
					else move_uploaded_file($tmp, $target);
				}
			}

			$to = $json['form']['mail']['to'];
			$subject = $json['form']['mail']['subject'];
			$header = $json['form']['mail']['header'];
			$files = str_replace(" ","%20",$files);
			$body = <<<EMAIL
	$content

	Attachments: $files

EMAIL;
			mail($to, $subject, $body, $header);  
			echo '<div class="alert alert-success">Thank You! You message has been sent :)<br>We\'ll get back to you as soon as possible.</div>';
		
	} else {
		echo '<div class="alert alert-danger">Sorry there was an error sending your message. Please try again later</div>';
	}
}

		
?>
<!DOCTYPE html>
<html>
<head>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','<?=$json['google']['gtm-id']?>');</script>
	<!-- End Google Tag Manager -->
		<title>Engraving Sydney</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
	    crossorigin="anonymous">
	<link href="css/style.css" type="text/css" rel="stylesheet" media="all">
	<!--web-font-->
	<link href='https://fonts.googleapis.com/css?family=Tangerine:400,700' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic'
	    rel='stylesheet' type='text/css'>
	<!--//web-font-->
	<link rel="icon" href="images/<?=$json['favicon']?>" type="image/png" />
	<!-- Custom Theme files -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="application/x-javascript">
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- //Custom Theme files -->
	<!-- js -->
	<script src="js/jquery-1.11.1.min.js"></script>
	<!-- //js -->
	<!-- Google Recaptcha v3 -->
	<script src="https://www.google.com/recaptcha/api.js?render=<?=$json['google']['recaptcha-site-key']?>"></script>
	<script>
		grecaptcha.ready(function() {
			grecaptcha.execute('<?=$json['google']['recaptcha-site-key']?>', {action: 'homepage'}).then(function(token) {
				document.getElementById("g-recaptcha-response").value = token;
			});
		});
	</script>
	<!-- End Google Recaptcha v3 -->
	<!-- start-smoth-scrolling-->
	<script type="text/javascript" src="js/move-top.js"></script>
	<script type="text/javascript" src="js/easing.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			$(".scroll").click(function (event) {
				event.preventDefault();
				$('html,body').animate({
					scrollTop: $(this.hash).offset().top
				}, 1000);
			});
		});
	</script>
	<!--//end-smoth-scrolling-->
</head>

<body>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?=$json['google']['gtm-id']?>"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<div id="loading">
		<img id="loading-image" src="images/ajax-loader.gif" alt="Loading..." />
	</div>
	<script language="javascript" type="text/javascript">
		$(window).load(function() {
			$('#loading').hide();
		});		
	</script>
	<!--header-->
	<div class="header">
		<div class="container">
			<div class="header-logo">
				<a href="index.html" id="logo">
					<img src="images/<?=$json['logo']?>" alt="logo" />
					<h1><span><?=substr($json['title'], 0, strpos($json['title'], ' '))?></span> <?=substr($json['title'], strpos($json['title'], ' ')+1)?></h1>
				</a>
			</div>
			<!--top-nav-->
			<div class="top-nav cl-effect-11">
				<span class="menu-icon">
					<a href="tel:<?=$json['phone-number']?>">
						<img src="images/menu-icon.png" alt=""/>
					</a>
				</span>
				<ul class="nav1">
					<li>
						<a href="tel:<?=$json['phone-number']?>">
							<i class="glyphicon glyphicon-earphone"></i>&nbsp;<?=$json['phone-number']?></a>
					</li>
				</ul>
			</div>
			<!--//top-nav-->
			<div class="clearfix"> </div>
		</div>
	</div>
	<!--//header-->
	<!--banner-->
	<div class="banner-text" style="background: url(images/<?=$json['banner']['img']?>)no-repeat 0px 0px; background-size: cover;">
		<div class="container">
			<div class="col-sm-8">
				<h2><?=$json['banner']['text']?></h2>
			</div>
			<div class="col-sm-4">
				<div class="banner-top">
					<div class="banner contact-form">
						<div class="col-md-12 text-center">
							<h3><?=$json['form']['title']?></h3>
						</div>
						<form method="post" enctype="multipart/form-data">
							<?php 
							foreach($json['form']['fields'] as $input) { 
								if(isset($input['tag'])) {
									switch($input['tag']) {
										case 'input':
											echo '<' . $input['tag'] . ' ';
											foreach ($input['attributes'] as $attribute => $data) {
												echo $attribute . '="'.$data.'" ';
											}
											echo '/>';	
											break;
										default:
											echo '<' . $input['tag'] . ' ';
											foreach ($input['attributes'] as $attribute => $data) {
												if($attribute != "value")
													echo $attribute . '="'.$data.'" ';
											}
											echo '>'.(isset($input['attributes']['value'])? $input['attributes']['value'] : '').'</' . $input['tag'] . '>';	
										break;
									}
								}
							}
							?>
							<div class="col-md-12 text-center">
								<input id="email-btn" type="submit" name="email-btn" class="hvr-boune btn btn-danger" value="Send" />
							</div>
						</form>
						<div class="clearfix"> </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--//banner-->

	<?php foreach($json['sections'] as $section) { 
			switch($section['type']) {
				case 'about': ?>
	<!--about-->
	<div class="about">
		<div class="container">
			<h3><?=$section['title']?></h3>
			<div class="col-xs-12 col-sm-3 col-lg-4">
				<div class="col-xs-12">
					<img class="wwa-img" src="images/<?=$section['img']?>" width="100%" alt="" />
				</div>
			</div>
			<div class="col-xs-12 col-sm-5 col-lg-4">
			<p><?=$section['text']?></p>
			</div>
		</div>
	</div>
	<!--end about-->
	<?php break;
	case 'slid': ?>
	<!--slid-->
	<div class="slid" style="background: url(images/<?=$section['img']?>) no-repeat 0px 0px; background-size: cover;">
		<div class="container">
			<h3>
			<?php foreach( $section['text'] as $line) {
				echo $line.'<br/>';
			}
			?>
			</h3>

			<div class="clearfix"></div>
		</div>
	</div>
	<!--//slid-->
	<?php break;
	case 'specials': ?>
	<!--specials-->
	<div class="specials">
		<div class="container">
			<div class="about-grids">
				<div class="col-sm-6 about-left">
					<img src="images/<?=$section['img']?>" alt="" />
				</div>
				<div class="col-sm-6 about-right">
					<div class="services">
						<h3><?=$json['sections'][2]['title']?></h3>
						<div class="col-md-12 services-grids">
							<ul>
							<?php 
								foreach( $section['text'] as $line) {
									echo '<li><a>'.$line.'</a></li>';
								}
							?>
							</ul>
						</div>
					</div>
					<!-- script for tabs -->
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
	<hr>
	<!--//specials-->
	<?php break; 
		} } ?>
	<!--manufacturers-->
	<div id="manufacturers-div" class="specials">
		<div class="container">
			<h3>We also manufacture signage for:</h3>
			<div id="manufacturers">
				<div class="row">
					<ul class="col-xs-12">
					<?php 
						foreach( $json['manufacturers'] as $line) {
							echo '<li class="col-sm-4"><h4><a href="'.$line['href'].'">'.$line['name'].'</a></h4></li>';
						}
					?>
					</ul>
				</div>
				<p>
					Audio, Aircraft, Automotive, Air Conditioning,&nbsp;<h3><a href="http://www.stainlesssteelsigns.com.au">Building Signs</a></h3>, Braille Signs, 
					<h3><a href="http://www.industrialengraving.com.au">Construction Signs</a></h3>, Computers, Electrical, Electronics, Engineering, <h3><a href="http://www.blockplans.com.au">Fire Services</a></h3>, Film, Gaming, Guillotining, 
					Hospitality, Lifts/Elevators, Machinery, Medical, Mining Signage, Marine, PA Systems, Security, Television, Transport, <h3><a href="http://www.vinylstickerssydney.com">Vinyl</a></h3>, 
					<h3><a href="http://www.blockplans.com.au">Block Plans</a></h3>, Architectural, Switch Plates, Labels &amp; Tags, Plaques, War Medals, <h3><a href="http://www.stainlesssteelsigns.com.au">Cut-Out Letters</a></h3>, <a href="http://www.stainlesssteelsigns.com.au">Cut-Out Shapes</a>, 
					Name Badges, Rubber Stamps, Mimic Panels, Control Panels, <h4><a href="http://www.memorialplaquessydney.com">Commemorative Memorial Plaques</a></h4>, <h3><a href="http://www.vinylstickerssydney.com">Vinyl Stickers</a></h3>, 
					Directory Systems, <h3><a href="http://www.engravingsydney.com">Opening Plaques</a></h3>, <h3><a href="http://www.engravingsydney.com">Reception Desk</a></h3>, Name Plates, Switch Boards, Photo Sand Etching, Medallions, Logos, Fire Protection, 
					Acrylic Signs, Stud Fixing, Light Boxes, OH&amp;S Signs, Materials Cut to Size, Directory Slats, Chemical Etching, Sandblasting, Photo Anodising, <h3><a href="http://www.engravingsydney.com">Cast Plaques</a></h3>, Fabrication, Billboards, Perspex and more....
				</p>
			</div>
		</div>
	</div>
	<!--//manufacturers-->
	<!--footer-->
	<div class="footer">
		<div class="container">
			<p>Copyright © 2018 Engravement Sydney. All rights reserved | By Gabriel Tannous
			</p>
		</div>
	</div>
	<!--//footer-->
	<!--smooth-scrolling-of-move-up-->
	<script type="text/javascript">
		$(document).ready(function () {
			$().UItoTop({
				easingType: 'easeOutQuart'
			});

		});
	</script>
	<a href="#" id="toTop" style="display: block;">
		<span id="toTopHover" style="opacity: 1;"> </span>
	</a>
	<!--//smooth-scrolling-of-move-up-->
	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script>
		$(document).ready(function () {
            $('#email-btn').click(function() {
				var name = document.getElementsByName("full-name")[0].value;
				var email = document.getElementsByName("email")[0].value;
				var phone = document.getElementsByName("phone")[0].value;
				var message = document.getElementsByName("message")[0].value;
				if(name != "" && email != "" && phone != "" && message != "") {
					$('#loading').show();
				}
			});
        });
	</script>
	<script src="js/bootstrap.js">
	</script>
</body>

</html>