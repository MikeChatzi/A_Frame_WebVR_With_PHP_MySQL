<?php
ob_start();

require_once('./functions.php');
include ('./connection.php');

session_start();
if (isset($_SESSION['id'])) {
$user_id = $_SESSION['id'];
  // Fetch the userzname from the database
  $revult = mysqli_query($conn, "SELECT userzname FROM `register` WHERE id = $user_id");
  if ($revult) {
    $rown = mysqli_fetch_assoc($revult);

    // Store the userzname in the session
    $_SESSION['userzname'] = $rown['userzname'];
  }
}
 else {
    header("Location: reception.php");
    exit();
}

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: reception.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: reception.php");
    exit();
}
ob_end_flush();
?>

<!DOCTYPE html>
<html>
<head>
	<title>User Introduction</title>
	<meta name="Art of Todayy" content="VR room decorr"> 
		<script src="https://aframe.io/releases/1.4.0/aframe.min.js"></script> 
		<script src="https://unpkg.com/aframe-event-set-component@4.2.1/dist/aframe-event-set-component.min.js"></script>
	    <script src="https://code.jquery.com/jquery-3.6.0.min.js "></script>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script>

AFRAME.registerComponent('adjust-rotation', {
  init: function () {
    var el = this.el;
    
    // Get the query parameter from the URL
    var urlParams = new URLSearchParams(window.location.search);
    var source = urlParams.get('source');
    
    // Adjust the position of the entity based on the source
    if (source === 'reception') {
      // Adjust position for visitors coming from regtest2.php
      el.setAttribute('rotation', '0 90 0');
    } else if (source === 'firstfloor') {
      // Adjust position for visitors coming from nutest2.php
      el.setAttribute('rotation', '0 180 0');
    }
  }
});

AFRAME.registerComponent('adjust-position', {
  init: function () {
    var el = this.el;
    
    // Get the query parameter from the URL
    var urlParams = new URLSearchParams(window.location.search);
    var source = urlParams.get('source');
    
    // Adjust the position of the entity based on the source
    if (source === 'reception') {
      // Adjust position for visitors coming from regtest2.php
      el.setAttribute('position', '-9 1.95 -7.65');
    } else if (source === 'firstfloor') {
      // Adjust position for visitors coming from nutest2.php
      el.setAttribute('position', '5 1.95 -1');
    }
  }
});

AFRAME.registerComponent('clickable', {
  init: function () {
    var el = this.el;
    var moved = false; // Flag to track movement

    el.addEventListener('click', function () {
      if (el.classList.contains('button') && !moved) {
        var entityGroup = document.getElementById('moving-group');
        var entity1 = entityGroup.querySelector('#entity1');
        var entity2 = entityGroup.querySelector('#entity2');

        var currentPosition1 = entity1.getAttribute('position');
        var currentPosition2 = entity2.getAttribute('position');

        entity1.setAttribute('animation__moveRight', {
          property: 'position',
          to: `${currentPosition1.x + 1} ${currentPosition1.y} ${currentPosition1.z}`,
          dur: 3000,
          easing: 'linear'
        });

        entity2.setAttribute('animation__moveLeft', {
          property: 'position',
          to: `${currentPosition2.x - 1} ${currentPosition2.y} ${currentPosition2.z}`,
          dur: 3000,
          easing: 'linear'
        });

		el.components.sound.playSound();

        moved = true; // Set the flag to true after the movement
      }
    });
  }
});

AFRAME.registerComponent('reverse-clickable', {
  init: function () {
    var el = this.el;
    var reversed = false; // Flag to track reverse movement

    el.addEventListener('click', function () {
      if (el.classList.contains('reverse-button') && !reversed) {
        var entityGroup = document.getElementById('moving-group');
        var entity1 = entityGroup.querySelector('#entity1');
        var entity2 = entityGroup.querySelector('#entity2');

        var currentPosition1 = entity1.getAttribute('position');
        var currentPosition2 = entity2.getAttribute('position');

        entity1.setAttribute('animation__moveLeft', {
          property: 'position',
          to: `${currentPosition1.x - 1} ${currentPosition1.y} ${currentPosition1.z}`,
          dur: 3000,
          easing: 'linear'
        });

        entity2.setAttribute('animation__moveRight', {
          property: 'position',
          to: `${currentPosition2.x + 1} ${currentPosition2.y} ${currentPosition2.z}`,
          dur: 3000,
          easing: 'linear'
        });

		el.components.sound.playSound();

        reversed = true; // Set the flag to true after the reverse movement

        // Delay the redirection after animation (e.g., 2 seconds)
        setTimeout(function () {
          window.location.href = 'firstfloor.php'; // Redirect to nutest.php
        }, 3500);
      }
    });
  }
});



AFRAME.registerComponent('play-video', {
    init: function () {
      var videoEl = document.querySelector('#TMR');
      document.addEventListener('keydown', function (event) {
        if (event.key === 'w') {
          videoEl.play();
         
        }
      });
    },
  });

  AFRAME.registerComponent('play-videoz', {
    init: function () {
      var videoEl = document.querySelector('#EFF');
      document.addEventListener('keydown', function (event) {
        if (event.key === 'w') {
          videoEl.play();
         
        }
      });
    },
  });

 AFRAME.registerComponent('zoom-on-click', {
  schema: {
    originalScale: { type: 'vec3', default: { x: 0.005, y: 0.92, z: 0.7 } }
  },
  init: function () {
    var el = this.el;
    var originalScale = this.data.originalScale;
    var scale = el.getAttribute('scale');
    el.addEventListener('click', function () {
      el.setAttribute('scale', (scale.x === originalScale.x && scale.y === originalScale.y && scale.z === originalScale.z)
        ? { x: scale.x * 1.25, y: scale.y * 1.25, z: scale.z * 1.25 }
        : originalScale
      );
    });
  }
});

  AFRAME.registerComponent('showtext', {
  init: function () {
    var msg = this.el.querySelector('[id^="msg-"]');
    var originalVisibility = msg.getAttribute('visible'); // Store the original visibility

    this.el.addEventListener('mouseenter', function () {
      msg.setAttribute('text', { value: this.getAttribute('description') });
      msg.setAttribute('visible', true); // Set visibility to true on mouseenter
    });

    this.el.addEventListener('mouseleave', function () {
      msg.setAttribute('visible', originalVisibility); // Restore original visibility on mouseleave
    });
  }
});
</script>
	<style>
  #myDiv0 {
    background-color: white; /* or any other color */
    opacity: 0.88; /* removes transparency */
  }
</style>

</head>
<body> 
	
	<a-scene style="z-index:1">
		<a-assets>

			<a-asset-item id="Plant0" src="objects/Plant.obj"> </a-asset-item>

			<audio id="click-sound" src="music/elev2.mp3"></audio>
				
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
				 

			<video id="TMR" autoplay loop muted="true" src="videos/congrats.mp4"> </video>
			<video id="EFF" autoplay loop muted="true" src="videos/Elevator1.mp4"> </video>
				 
			<?php 
				$res=mysqli_query($conn, 'SELECT id, userfile FROM `register`');
	            while($row=mysqli_fetch_array($res))
				{
					echo '<img id="canva-'.$row['id'].'" src="'.$row['userfile'].'">';
				}

				?>
		</a-assets>
		<a-entity id="rig" adjust-rotation position"25 10 0" rotation="0 90 0">
	         <a-entity adjust-position id="player" 
			 camera look-controls  
					 wasd-controls="acceleration:20"
					 position="-9 1.95 -7.65">
					 <a-cursor rayOrigin="mouse" position="0 0 -0.1" scale="0.1 0.1 0.1"> </a-cursor>
             </a-entity>
			</a-entity>
			<a-entity light="type: directional; color: #ffff00; intensity: 0.5"> </a-entity>
			 <a-entity light="type: ambient; color: #FFF; intensity: 0.9"> </a-entity> 
<div id="userWindow" style="position:fixed; bottom:10px; right:10px; z-index:1000; border:1px solid black; padding:10px;">
  <div>
    User: <?php echo (isset($_SESSION['userzname'])) ? $_SESSION['userzname'] : ''; ?>
  </div>
  <form action="loggedin.php" method="post">
    <input type="submit" name="logout" value="Log Out">
  </form>
</div>

	<!-- ROOM -->
	
	<a-entity play-video geometry="primitive: box; width: 2.4; height: 1.2; depth: 0.02" material="src: #TMR; " rotation="0 90 0" position="-8.64 3.25 9"></a-entity>

	<a-entity geometry="primitive: cylinder" material="color: black" position="-8.64 3.9 9" scale="0.015 0.1 0.02"></a-entity>

	<a-entity play-videoz geometry="primitive: box; width: 1.2; height: 0.6; depth: 0.02" material="src: #EFF" rotation="0 0 0" position="-5 3.9 -1"></a-entity>

	<a-entity obj-model="obj: #Plant0"
						material="src: #plant" position="-8.33 0.2 9.1" rotation="180 0 0" 
						scale="0.002 0.005 0.005" shadow="receive: true"> 
			</a-entity>
			<a-entity obj-model="obj: #Plant0"
						material="src: #plant" position="-8.53 0.2 9.8" rotation="180 90 0" 
						scale="0.0015 0.005 0.005" shadow="receive: true"> 
			</a-entity>
			<a-entity obj-model="obj: #Plant0"
						material="src: #plant" position="-8.33 0.2 8.55" rotation="180 0 0" 
						scale="0.002 0.005 0.005" shadow="receive: true"> 
			</a-entity>
			<a-entity obj-model="obj: #Plant0"
						material="src: #plant" position="-8.53 0.2 8" rotation="180 90 0" 
						scale="0.0015 0.005 0.005" shadow="receive: true"> 
			</a-entity>

	<a-entity geometry="primitive: plane; height: 2.2; width: 0.4" 
				material="src: #xwma; repeat: 2 2; side: double" 
				position="-8.35 0.09 9" rotation="90 0 0"> 
	</a-entity>

 <a-entity geometry="primitive: plane; height: 20.5; width: 10.5" 
               material="src: #dimy; color: white; side: double; repeat: 4 8" 
			   position="-5 0 9.25"
               rotation="90 0 0"> 
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
					  position="-8.15 2.1 -0.985" 
					  scale="4 4.2 0.015"> 
			</a-entity>
			<a-entity id="moving-group">
			<a-entity id="entity2"
						
						geometry="primitive: box" 
					  material="opacity: 0.39; color: white" 
					  position="-5.57 1.8 -0.965" 
					  scale="1 3.6 0.015"> 
			</a-entity>

			<a-entity id="entity1"
						geometry="primitive: box" 
					  material="opacity: 0.39; color: white" 
					  position="-4.49 1.8 -0.985" 
					  scale="0.97 3.6 0.015"> 
			</a-entity>
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
					  material="color: grey; shader: flat"
					  position="-5.275 3.5 19.5"
					  scale="9.35 0.1 0.1">
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
					  material="color: grey; shader: flat"
					  position="-5.275 0.7 19.5"
					  scale="9.35 0.1 0.1">
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
					 scale="0.2 0.3 0.1"
					 reverse-clickable
					 sound="src: #click-sound"
          class="reverse-button">
		   	</a-entity>

			<a-entity geometry="primitive: box"
						material="color: black"
					  position="-3.8 1.55 -1" 
		   			 rotation="0 0 0" 
					 scale="0.2 0.3 0.1">
					 </a-entity>

		   		<a-entity id="green-button"
							class="button"
							geometry="primitive: box"
						material="color: green"
					  position="-3.8 1.65 -0.95" 
		   			 rotation="0 0 0" 
					 scale="0.05 0.04 0.01"
					 sound="src: #click-sound"
					 clickable>
				</a-entity>

				
				
			


			<a-entity geometry="primitive: plane" material="src: #frm; color: bisque" position="-8.37 1.41 9" rotation="-90 0 0" scale="0.35 0.25">
			</a-entity>

			<a-entity 
			
					material="src: #me"
					geometry="primitive: box"
					description="Mike24: Congratulations! You have successfully connected. You can now see your own profile photo on the wall along with those of the rest users as well!"
					position="-9.99 1.75 9"
					scale="0.005 0.92 0.7"
					
					showtext>
							
							<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="-0.8 0 0" rotation="0 -90 0" scale="1.035 1.035 1.035">
							</a-entity>
							<a-entity id="msg-" geometry="primitive: plane; height: 0.22; width: auto" material="src: #merme; opacity: 0.65; side: double" style="z-index: 10" 
									  visible="false" position="40 -0.67 0" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.85; letterSpacing: 4; lineHeight: 61" 
									  rotation="0 90 0">
									   </a-entity>
			</a-entity>

			<!-- ECHO DYNAMICALLY -->

			<?php 
			$ress=mysqli_query($conn, 'SELECT id, userfile, userzname ,textt FROM `register`');
					$firstPosx= 18.35;
				$secondPosx= 18.35;
				$thirdPosx= 18.35;
				$foPosx= 6.35;
				$fiPosx= 6.35;
				$siPosx= 6.35;
				$firstPosy= 3.4;
				$secondPosy= 2.2;
				$thirdPosy= 1;
				
		while ($roww = mysqli_fetch_array($ress)) {



			if ($roww['id'] <= 6) {
									 echo '<a-entity 
									
									material="src: #canva-'.$roww['id'].'"
									geometry="primitive: box"
									description="' . $roww['userzname'] . ': ' . $roww['textt'] . '"
									position="-9.99 '.$firstPosy.' '.$firstPosx.'"
									scale="0.005 0.92 0.7"
									
									showtext
									zoom-on-click>
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="-0.8 0 0" rotation="0 -90 0" scale="1.035 1.035 1.035">
										</a-entity>
										<a-entity id="msg-' . $roww['id'] . '" geometry="primitive: plane; height: 0.22; width: auto" material="src: #merme; opacity: 0.7; side: double" style="z-index: 10" 
									  visible="false" position="40 -0.67 0" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.85; letterSpacing: 4; lineHeight: 61" 
									  rotation="0 90 0">
									   </a-entity>
								  </a-entity>';

        $firstPosx -= 1.25;
        
    }
						elseif($roww['id']<= 12)
                        {
							echo '<a-entity 
									
									material="src: #canva-'.$roww['id'].'"
									geometry="primitive: box"
									description="' . $roww['userzname'] . ': ' . $roww['textt'] . '"
									position="-9.99 '.$secondPosy.' '.$secondPosx.'"
									scale="0.005 0.92 0.7"
									
									showtext
									zoom-on-click>
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="-0.8 0 0" rotation="0 -90 0" scale="1.035 1.035 1.035">
										</a-entity>
										<a-entity id="msg-' . $roww['id'] . '" geometry="primitive: plane; height: 0.22; width: auto" material="src: #merme; opacity: 0.7; side: double" style="z-index: 10" 
									  visible="false" position="40 -0.67 0" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.85; letterSpacing: 4; lineHeight: 61" 
									  rotation="0 90 0">
									   </a-entity>
								  </a-entity> ' ;
								  $secondPosx-= 1.25;
						}
						elseif($roww['id']<= 18)
                        {
							echo '<a-entity 
									
									material="src: #canva-'.$roww['id'].'"
									geometry="primitive: box"
									description="' . $roww['userzname'] . ': ' . $roww['textt'] . '"
									position="-9.99 '.$thirdPosy.' '.$thirdPosx.'"
									scale="0.005 0.92 0.7"
									
									showtext
									zoom-on-click>
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="-0.8 0 0" rotation="0 -90 0" scale="1.035 1.035 1.035">
										</a-entity>
										<a-entity id="msg-' . $roww['id'] . '" geometry="primitive: plane; height: 0.22; width: auto" material="src: #merme; opacity: 0.7; side: double" style="z-index: 10" 
									  visible="false" position="40 -0.67 0" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.85; letterSpacing: 4; lineHeight: 61" 
									  rotation="0 90 0">
									   </a-entity>
								  </a-entity> ' ;
								  $thirdPosx-= 1.25;
						}
						
						elseif($roww['id']<= 24)
						{
						    echo '<a-entity 
									
									material="src: #canva-'.$roww['id'].'"
									geometry="primitive: box"
									description="' . $roww['userzname'] . ': ' . $roww['textt'] . '"
									position="-9.99 '.$firstPosy.' '.$foPosx.'"
									scale="0.005 0.92 0.7"
									
									showtext
									zoom-on-click>
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="-0.8 0 0" rotation="0 -90 0" scale="1.035 1.035 1.035">
										</a-entity>
										<a-entity id="msg-' . $roww['id'] . '" geometry="primitive: plane; height: 0.22; width: auto" material="src: #merme; opacity: 0.7; side: double" style="z-index: 10" 
									  visible="false" position="40 -0.67 0" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.85; letterSpacing: 4; lineHeight: 61" 
									  rotation="0 90 0">
									   </a-entity>
								  </a-entity> ' ;
								  $foPosx-= 1.25;
                        }
						elseif($roww['id']<= 30)
						{
						    echo '<a-entity 
									
									material="src: #canva-'.$roww['id'].'"
									geometry="primitive: box"
									description="' . $roww['userzname'] . ': ' . $roww['textt'] . '"
									position="-9.99 '.$secondPosy.' '.$fiPosx.'"
									scale="0.005 0.92 0.7"
									
									showtext
									zoom-on-click>
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="-0.8 0 0" rotation="0 -90 0" scale="1.035 1.035 1.035">
										</a-entity>
										<a-entity id="msg-' . $roww['id'] . '" geometry="primitive: plane; height: 0.22; width: auto" material="src: #merme; opacity: 0.7; side: double" style="z-index: 10" 
									  visible="false" position="40 -0.67 0" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.85; letterSpacing: 4; lineHeight: 61" 
									  rotation="0 90 0">
									   </a-entity>
								  </a-entity> ' ;
								  $fiPosx-= 1.25;
                        }
						else
						{
						    echo '<a-entity
									
									material="src: #canva-'.$roww['id'].'"
									geometry="primitive: box"
									description="' . $roww['userzname'] . ': ' . $roww['textt'] . '"
									position="-9.99 '.$thirdPosy.' '.$siPosx.'"
									scale="0.005 0.92 0.7"
									
									showtext
									zoom-on-click>
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="-0.8 0 0" rotation="0 -90 0" scale="1.035 1.035 1.035">
										</a-entity>
										<a-entity id="msg-' . $roww['id'] . '" geometry="primitive: plane; height: 0.22; width: 0.87" material="src: #merme; opacity: 0.7; side: double" style="z-index: 10" 
									  visible="false" position="40 -0.67 0" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.85; letterSpacing: 4; lineHeight: 61" 
									  rotation="0 90 0">
									   </a-entity>
								  </a-entity> ' ;
								  $siPosx-= 1.25;
                        }
						
				}
			
			
			?>

<a-sky material="src: #skr" color="#ECECEC"></a-sky>
</a-scene>
</body>

</html>
