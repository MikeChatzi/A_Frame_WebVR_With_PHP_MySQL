<?php
	ob_start();

	require_once('./functions.php');
	include ('./connection.php');
?>

<!DOCTYPE html>

<html>

<head>
      <title>User Registration</title>
		<meta name="Art of Today" content="VR room decor"> 
		
		<script src="https://aframe.io/releases/1.4.0/aframe.min.js"></script> 
		<script src="https://unpkg.com/aframe-event-set-component@4.2.1/dist/aframe-event-set-component.min.js"></script>
	    <script src="https://code.jquery.com/jquery-3.6.0.min.js "></script>
		<script src="https://cdn.rawgit.com/donmccurdy/aframe-extras/v6.0.0/dist/aframe-extras.min.js"></script>
		<script src="https://cdn.rawgit.com/donmccurdy/aframe-extras/v6.0.0/dist/aframe-extras.loaders.min.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">

	  <script>


	AFRAME.registerComponent('showtext', 
		{
			init: function () 
			{
				var parent = this.el;
				var msg = this.el.querySelector('[id^="msg-"]');
				var originalVisibility = msg.getAttribute('visible'); // Store the original visibility

			    parent.addEventListener('mouseenter', function () 
				{
					msg.setAttribute('text', { value: parent.getAttribute('description') });
					msg.setAttribute('visible', true); // Set visibility to true on mouseenter
				});

				this.el.addEventListener('mouseleave', function () 
				{
					msg.setAttribute('visible', originalVisibility); // Restore original visibility on mouseleave
			});
			 }
		});

		AFRAME.registerComponent('play-video', 
		{
			init: function () 
			{
				var videoEl = document.querySelector('#TMR');
				document.addEventListener('keydown', function (event) 
				{
					if (event.key === 'w') 
					{
						videoEl.play();
					}
				});
			}
		});

		function showHideForm()
		{
			if  (document.getElementById('myDiv0').style.display=='block') 
			{
				document.getElementById('myDiv0').style.display='none';
			}
			else if (document.getElementById('myDiv0').style.display=='none') 
			{
				document.getElementById('myDiv0').style.display='block'; 
			}
		}

		function showLoginForm() 
		{
			document.getElementById("loginform").style.display = "block";
			document.getElementById("registerform").style.display = "none";
		}
		
		function showRegistrationForm() 
		{
			document.getElementById("registerform").style.display = "block";
			document.getElementById("loginform").style.display = "none";
		}
			
	  </script>

		<style>
			#myDiv0 
			{
				background-color: bisque; /* or any other color */
				opacity: 0.98; 
			}
		</style>

</head>

<body> 
	<?php
		session_start();
		error_reporting(E_ALL);
		ini_set('display_errors', 1);

		if (isset($_POST['create'])) 
		{
			$nickz = $_POST['userzname'];
			$users = $_POST['fullname'];
			$emails = $_POST['email'];
			$passwords = $_POST['password'];
			$files = $_FILES['userfile'];
			$captions = htmlspecialchars($_POST['text']); // Sanitize here

			$filename = $files['name']; // Access the filename from the array
			$filetmpname = $files['tmp_name'];
			$filerror = $files['error'];
			$filetype = explode('.', $filename);
			$truefiletype = strtolower(end($filetype));

			$extensions = array('jpeg', 'jpg', 'png');
			if (in_array($truefiletype, $extensions)) 
			{
				$file_upload = 'passed/' . $filename;
				if (move_uploaded_file($filetmpname, $file_upload)) 
				{
					$stmt = $conn->prepare("INSERT INTO `register` (userzname, fullname, email, password, userfile, textt) 
											VALUES (?, ?, ?, ?, ?, ?)");
					$stmt->bind_param("ssssss", $nickz, $users, $emails, $passwords, $filename, $captions); 
					// Bind the filename instead of the entire array

					if (!$stmt->execute()) 
					{
						echo "Error executing statement: " . $stmt->error;
						exit(); // or log the error and redirect to an error page
					}
				} 
				else 
				{
					echo "Error uploading the file.";
				}
			} 
			else 
			{
				echo "File type not allowed.";
			}

			$query = "SELECT * FROM `register` WHERE userzname = '$nickz' AND password = '$passwords'";
			$rezult = mysqli_query($conn, $query);
			if (mysqli_num_rows($rezult) > 0) 
			{
				$raw = mysqli_fetch_assoc($rezult);
				$_SESSION['id'] = $raw['id'];
				$_SESSION['logged_in'] = true;
				header("Location: loggedin.php?source=reception");
				exit();
			}
		}

		if(isset($_POST['login'])) 
		{
			$nickzz = $_POST['userzname'];
			$passwordz = $_POST['password'];

			$stmt = $conn->prepare("SELECT * FROM `register` WHERE userzname = '$nickzz' AND password = '$passwordz'");
			if (!$stmt) 
			{
				die("Statement preparation failed: " . $conn->error);
			}

			$stmt->bind_param("ss", $nickzz, $passwordz);
			$nickzz = $_POST['userzname'];
			$passwordz = $_POST['password'];
			$stmt->execute();
			$ressult = $stmt->get_result();
			$loginData = $ressult->fetch_assoc();
			if ($loginData !== null && $loginData['userzname'] === $nickzz && $loginData['password'] === $passwordz) 
			{
				// Start the session and redirect the user
				$_SESSION['id'] = $loginData['id'];
				$_SESSION['logged_in'] = true;
				header("Location: loggedin.php?source=reception");
				exit();
			} 
			else 
			{
				echo "Invalid login credentials. Please try again.";
			}
		}

		ob_end_flush();
	?>
	
	<a-scene style="z-index:2">
		<a-assets>
			<a-asset-item id="Plant0" src="objects/Plant.obj"> </a-asset-item>

			<img id="Wally" src="textures/Wallpaper0.jpg">
			<img id="xwma" src="textures/xwma.jpg">
			<img id="plant" src="textures/Leaves.jpg">
			<img id="merme" src="textures/placerr.jpg">
			<img id="frm" src="textures/form.jpg">
			<img id="dimy" src="textures/dimfloor1.jpg">
			<img id="ceill" src="textures/newcel.jpg">
			<img id="marb1" src="textures/marble1.jpg">
			<img id="elfloor" src="textures/elevfloor.jpg">
			<img id="elmirror" src="textures/elevmir.jpg">
			<img id="elbuttons" src="textures/elevbuttons.jpg">
			<img id="skr" src="textures/skr.jpg">
			<img id="me" src="textures/welcoME.jpg">
			
			<video id="TMR" autoplay loop muted="true" src="videos/welcomer.mp4"> </video>

		</a-assets>

		<a-entity id="rig" position"25 10 0" rotation="0 90 0">
			  <a-entity id="player" 
					camera look-controls  
					wasd-controls="acceleration:20"
					position="-9 1.95 -0.15">
					<a-cursor rayOrigin="mouse" position="0 0 -0.1" scale="0.1 0.1 0.1"> 
					</a-cursor>
              </a-entity>
		</a-entity>
	
		<a-entity light="type: directional; color: #ffff00; intensity: 0.5"> </a-entity>
		<a-entity light="type: ambient; color: #FFF; intensity: 0.9"> </a-entity> 

	
		<a-entity id="myDiv0" style="display:none; position:absolute; top:10%; left:42%; z-index:1000; border-style:solid;">
				<div id="registerform" style="display:block">
					Account Form
					<button style="position:absolute; right:-0.5%;" onclick="showHideForm();">
					X
					</button>
					<form action="reception.php" method="post" enctype="multipart/form-data">
						<div class="container">
							<div class="row">
								<div class="col-sm-10">
									<h1>Registration</h1>
									<p>Fill up with correct values</p>
									<hr class="mb-3">
						
									<label for="userzname"><b>Username</b></label>
									<?php inputFields("Your nickname", "userzname", "", "text") ?>
						
									<label for="fullname"><b>Full Name</b></label>
									<?php inputFields("Your name", "fullname", "", "text") ?>
						
									<label for="email"><b>E-mail Address</b></label>
									<?php inputFields("E-mail address", "email", "", "email") ?>
			
									<label for="password"><b>Password</b></label>
									<?php inputFields("Your password", "password", "", "password") ?>
			
									<label for="userfile"><b>Your 'get to know you' Photo</b></label>
									<?php inputFields("Get to know you photo","userfile","","file") ?>
						
									<label for="text"><b>Introducing You</b></label>
									<?php inputFields("Write something about yourself","text","","text") ?>
			
									<hr class="mb-3">
									<button id="btnn" class="btn btn-dark mb-2" type="submit" name="create">
									Sign Up & Log In
									</button>
								</div>
							</div>
						</div>
					</form>

					You already have an account? Then simply
					<button id="showLogin" onclick="showLoginForm();">
					Login
					</button>
				</div>
	
				<div id="loginform" style="display: none">
					Login Form
					<button style="position:absolute; right:-0.5%;" onclick="showHideForm();">
					X
					</button>
					<form action="reception.php" method="post" enctype="multipart/form-data">
						<div class="container">
							<div class="row">
								<div class="col-sm-10">
									<h1>Log In</h1>
									<p>Fill up with correct values</p>
									<hr class="mb-3">
			
									<label for="userzname"><b>Username</b></label>
									<?php inputFields("Your nickname", "userzname", "", "text") ?> 
			
									<label for="password"><b>Password</b></label>
									<?php inputFields("Your password", "password", "", "password") ?> 
								
									<hr ="mb-3">
									<button id="btnnn" class="btn btn-dark mb-2" type="submit" name="login">
									Log In
									</button>
								</div>
							</div>
						</div>
					</form> 

					Go back to registration form  
					<button id="showRegis" onclick="showRegistrationForm();">
					Return
					</button>
				</div>
		</a-entity>

		<!-- ROOM -->
		<a-entity geometry="primitive: box; width: 2.4; height: 1.2; depth: 0.02" material="src: #TMR" 
				  rotation="0 90 0" position="-8.64 3.25 9" 
				  play-video>
		</a-entity>

		<a-entity geometry="primitive: cylinder" material="color: black" position="-8.64 3.9 9" scale="0.015 0.1 0.02">
		</a-entity>

		<a-entity geometry="primitive: box; width: 1.2; height: 0.6; depth: 0.02" material="color: black" rotation="0 0 0" position="-5 3.9 -1">
		</a-entity>

		<a-entity obj-model="obj: #Plant0" material="src: #plant" 
			      position="-8.33 0.2 9.1" rotation="180 0 0" 
				  scale="0.002 0.005 0.005" shadow="receive: true"> 
		</a-entity>

		<a-entity obj-model="obj: #Plant0" material="src: #plant" 
			   	  position="-8.53 0.2 9.8" rotation="180 90 0" 
				  scale="0.0015 0.005 0.005" shadow="receive: true"> 
		</a-entity>

		<a-entity obj-model="obj: #Plant0" material="src: #plant" 
			      position="-8.33 0.2 8.55" rotation="180 0 0" 
				  scale="0.002 0.005 0.005" shadow="receive: true"> 
		</a-entity>
			
		<a-entity obj-model="obj: #Plant0" material="src: #plant" 
				  position="-8.53 0.2 8" rotation="180 90 0" 
				  scale="0.0015 0.005 0.005" shadow="receive: true"> 
		</a-entity>

		<a-entity geometry="primitive: plane; height: 2.2; width: 0.4" material="src: #xwma; repeat: 2 2; side: double" 
				  position="-8.35 0.09 9" rotation="90 0 0"> 
		</a-entity>
	
		<a-entity geometry="primitive: plane; height: 20.5; width: 10.5" material="src: #dimy; color: white; side: double; repeat: 4 8" 
			      position="-5 0 9.25" rotation="90 0 0"> 
        </a-entity>

		<a-entity geometry="primitive: plane; height: 20.5; width: 10.5" 
               material="src: #ceill; side: double; color: white; repeat: 4 8" 
			   position="-5 4.2 9.25"
               rotation="-90 0 0"> 
        </a-entity>

		<a-entity geometry="primitive: plane; height: 4.2; width: 4" 
               material="src: #marb1; color: white; side: double" 
			   position="-2 2.1 -1"
               rotation="0 0 0"> 
        </a-entity>

		<a-entity geometry="primitive: plane; height: 4.2; width: 20.5" 
               material="src: #marb1; color: white; side: double; repeat: 4 1" 
			   position="-10 2.1 9.25"
               rotation="0 90 0"> 
        </a-entity>

		<a-entity geometry="primitive: plane; height: 4.2; width: 20.5" 
               material="src: #marb1; color: white; side: double; repeat: 4 1" 
			   position="0 2.1 9.25"
               rotation="0 90 0"> 
        </a-entity>

		<a-entity geometry="primitive: box" 
			   material="opacity: 0.21; color: white" 
			   position="-8.35 2.1 19.55" 
			   scale="3.3 4.2 0.015"> 
		</a-entity>

		<a-entity geometry="primitive: box" 
			   material="opacity: 0.21; color: white" 
			   position="-5 2.1 19.55" 
		       scale="3.3 4.2 0.015"> 
		</a-entity>

		<a-entity geometry="primitive: box" 
					  material="opacity: 0.21; color: white" 
					  position="-1.65 2.1 19.55" 
					  scale="3.3 4.2 0.015"> 
		</a-entity>

		<a-entity geometry="primitive: box" 
					  material="opacity: 0.21; color: white" 
					  position="-8.15 2.1 -0.985" 
					  scale="4 4.2 0.015"> 
		</a-entity>

		<a-entity geometry="primitive: box" 
					  material="opacity: 0.39; color: white" 
					  position="-5.57 1.8 -0.985" 
					  scale="1 3.6 0.015"> 
		</a-entity>

		<a-entity geometry="primitive: box" 
					  material="opacity: 0.39; color: white" 
					  position="-4.49 1.8 -0.985" 
					  scale="0.97 3.6 0.015"> 
		</a-entity>

		<a-entity geometry="primitive: box"
					  material="color: black"
					  position="-9.999 2.1 -1"
					  scale="0.1 4.2 0.1">
		</a-entity>

		<a-entity geometry="primitive: box"
					  material="color: black"
					  position="-4 2.1 -1"
					  scale="0.1 4.2 0.1">
		</a-entity>

		<a-entity geometry="primitive: box"
					  material="color: black"
					  position="-6.1 2.1 -1"
					  scale="0.1 4.2 0.1">
		</a-entity>

		<a-entity geometry="primitive: box"
					  material="color: black"
					  position="-6.999 0 -1"
					  scale="6 0.1 0.1">
		</a-entity>

		<a-entity geometry="primitive: box"
					  material="color: black"
					  position="-6.999 4.2 -1"
					  scale="6 0.1 0.1">
		</a-entity>  

		<a-entity geometry="primitive: box"
					  material="src: #marb1; color: white; repeat: 2 4"
					  position="0 2.1 19.25"
					  scale="1 4.2 0.5">
		</a-entity>

		<a-entity geometry="primitive: box"
					  material="color: black"
					  position="-0.55 2.1 19.5"
					  scale="0.1 4.2 0.1">
		</a-entity>
			
		<a-entity geometry="primitive: box"
					  material="color: black"
					  position="-10 2.1 19.5"
					  scale="0.1 4.2 0.1">
		</a-entity>

		<a-entity geometry="primitive: box"
					  material="color: black"
					  position="-5 4.2 19.5"
					  scale="9.9 0.1 0.1">
		</a-entity>

		<a-entity geometry="primitive: box"
					  material="color: grey; shader: flat"
					  position="-5.275 3.5 19.5"
					  scale="9.35 0.1 0.1">
		</a-entity>

		<a-entity geometry="primitive: box"
					  material="color: grey; shader: flat"
					  position="-5.275 0.7 19.5"
					  scale="9.35 0.1 0.1">
		</a-entity>

		<a-entity geometry="primitive: box"
					  material="color: black"
					  position="-5 0 19.5"
					  scale="9.9 0.1 0.1">
		</a-entity>
			
		<a-entity geometry="primitive: box"
				      material="src: #marb1; color: white; opacity: 0.5"
					  position="-8.35 0.7 9"
					  scale="0.4 1.4 2.2">

					  <a-entity geometry="primitive: box"
						material="color: black"
						position="0 -0.5 0"
						scale="1.1 0.1 1.03">
					  </a-entity>
		</a-entity>  

		<a-entity geometry="primitive: box"
					 material="src: #elfloor; repeat: 2 2"
					 position="-5 0 -2.25" 
		   			 rotation="0 0 0" 
					 scale="2.1 0.2 2.5">
		</a-entity>

		<a-entity geometry="primitive: box"
					 material="src: #elfloor; repeat: 2 2"
					 position="-5 3.6 -2.25" 
		   			 rotation="0 0 0" 
					 scale="2.1 0.2 2.5">
		</a-entity>

		<a-entity geometry="primitive: box"
					  material="opacity: 0.21; color: white; shader: flat"
					 position="-6.1 1.8 -2.25" 
		   			 rotation="0 0 0" 
					 scale="0.1 3.6 2.4">
		</a-entity>

		<a-entity geometry="primitive: box"
					  material="color: black; shader: flat"
					 position="-5 3.6 -1" 
		   			 rotation="0 0 0" 
					 scale="2.1 0.05 0.1">
		</a-entity>

		<a-entity geometry="primitive: box"
					  material="color: black; shader: flat"
					 position="-6.1 3.6 -2.25" 
		   			 rotation="0 0 0" 
					 scale="0.1 0.1 2.4">
		</a-entity>

		<a-entity geometry="primitive: box"
					  material="color: black; shader: flat"
					 position="-6.1 0.1 -2.25" 
		   			 rotation="0 0 0" 
					 scale="0.1 0.1 2.4">
		</a-entity>

		<a-entity geometry="primitive: box"
					  material="color: black; shader: flat"
					 position="-3.9 3.6 -2.25" 
		   			 rotation="0 0 0" 
					 scale="0.1 0.1 2.4">
		</a-entity>

		<a-entity geometry="primitive: box"
					  material="color: black; shader: flat"
					 position="-3.9 0.1 -2.25" 
		   			 rotation="0 0 0" 
					 scale="0.1 0.1 2.4">
		</a-entity>

		<a-entity geometry="primitive: box"
					  material="opacity: 0.21; color: white; shader: flat"
					 position="-3.9 1.8 -2.25" 
		   			 rotation="0 0 0" 
					 scale="0.1 3.6 2.4">
		</a-entity>

		<a-entity geometry="primitive: box"
					   material="src: #elmirror"
					 position="-5 1.8 -3.5" 
		   			 rotation="0 0 0" 
					 scale="2.2 3.6 0.1">
		</a-entity>

		<a-entity geometry="primitive: box"
					   material="src: #elbuttons"
					 position="-5.6 1.35 -3.4" 
		   			 rotation="0 0 0" 
					 scale="0.2 0.3 0.1">
		</a-entity>
			
		<a-entity geometry="primitive: plane" material="src: #frm; color: bisque" 
					position="-8.37 1.41 9" rotation="-90 0 0" scale="0.35 0.25"
					onclick="showHideForm();">
		</a-entity>

		<a-entity 
					showtext
					description="Mike24: Welcome to the Collaborative Expression Project! My name is Mike and art is my passion! What about you? Fill up the form on the desk and let's connect!"
					position="-9.99 1.75 9">

				<a-entity 
					material="src: #me"
					geometry="primitive: box"
					scale="0.005 0.92 0.7">
							
					<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" 
							  position="-0.8 0 0" rotation="0 -90 0" scale="1.035 1.035 1.035">
					</a-entity> 
				</a-entity>

				<a-entity id="msg-1" 
							geometry="primitive: plane; height: 0.25; width: 1.2" material="src: #merme; opacity: 0.65; side: double" 
							style="z-index: 10" visible="false" position="0 -0.62 0" 
							text=" ; align: center; color: black; wrapCount: 42; width: auto; letterSpacing: 1; lineHeight: 38" 
							rotation="0 90 0">
				</a-entity> 
		</a-entity> 

		<a-sky material="src: #skr" color="#ECECEC">
		</a-sky>

	</a-scene>

</body>

</html>
