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

if (isset($_POST['submit'])){
    
    $username = $_SESSION['userzname'];
    
    $files = $_FILES['userfile'];
    $captions = $_POST['text'];
    $types = $_POST['canvastype'];

    $filename = $files['name'];
    $filetmpname = $files['tmp_name']; 
    $filerror = $files['error'];
    $filetype = explode('.', $filename);
    $truefiletype = strtolower(end($filetype));

    $extensions = array('jpeg', 'jpg', 'png');
    if (in_array($truefiletype, $extensions)) {
        $file_upload = 'passed/' . $filename;
        move_uploaded_file($filetmpname, $file_upload);
        
        
        $db = "INSERT INTO `filez` (usernamee, userfile, textt, typuu) VALUES ('$username', '$file_upload', '$captions', '$types')";
        $result = mysqli_query($conn, $db);
        

        if (!$result) {
            die(mysqli_error($conn));
        } 

        
        $positionChangeFlag = "true";
		header("Location: firstfloor.php?positionChange=" . urlencode($positionChangeFlag));
        exit();
    }
}

	if (isset($_POST['submitt'])){

		$usernamez = $_SESSION['userzname'];

		$filess=$_FILES['userfile'];
		$captionss=$_POST['text'];
		$typess=$_POST['canvastype'];
		
		

		$filenamez=$filess['name'];
		$filetmpnamez=$filess['tmp_name']; 
		$filerrorz=$filess['error'];
		$filetypez=explode('.',$filenamez);
		$truefiletypez=strtolower(end($filetypez));

		$extensionz=array('jpeg','jpg','png');
		if(in_array($truefiletypez,$extensionz)){
				$file_uploadz='passed/'.$filenamez;
				move_uploaded_file($filetmpnamez,$file_uploadz);
				$dbz="insert into `filezz` (usernamee, userfile, textt, typuu) values('$usernamez', '$file_uploadz', '$captionss', '$typess')";
				$resultz=mysqli_query($conn,$dbz);



				if(!$resultz){
					die(mysqli_error($conn));
				} 
				
				 $positionChangeFlagz = "true";
		header("Location: firstfloor.php?positionChange2=" . urlencode($positionChangeFlagz));
        exit();
		}
	}

if (isset($_POST['submittt'])){

		$usernamex = $_SESSION['userzname'];

		$filesx=$_FILES['userfile'];
		$captionsx=$_POST['text'];
		
		
		

		$filenamex=$filesx['name'];
		$filetmpnamex=$filesx['tmp_name']; 
		$filerrorx=$filesx['error'];
		$filetypex=explode('.',$filenamex);
		$truefiletypex=strtolower(end($filetypex));

		$extensionx=array('jpeg','jpg','png');
		if(in_array($truefiletypex,$extensionx)){
				$file_uploadx='passed/'.$filenamex;
				move_uploaded_file($filetmpnamex,$file_uploadx);
				$dbx="insert into `filezzz` (usernamee, userfile, textt) values('$usernamex', '$file_uploadx', '$captionsx')";
				$resultx=mysqli_query($conn,$dbx);



				if(!$resultx){
					die(mysqli_error($conn));
				} 
				
				 $positionChangeFlagx = "true";
		header("Location: firstfloor.php?positionChange3=" . urlencode($positionChangeFlagx));
        exit();
		}
	}
	

ob_end_flush();
?>

<!DOCTYPE html>

<html>

<head>
      <title>Content Room 1</title>
		<meta name="Art of Today" content="VR room decor"> 
		<script src="https://aframe.io/releases/1.4.0/aframe.min.js"></script> 
		<script src="https://unpkg.com/aframe-event-set-component@4.2.1/dist/aframe-event-set-component.min.js"></script>
	    <script src="https://code.jquery.com/jquery-3.6.0.min.js "></script>
	    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">

	<script>

	AFRAME.registerComponent('position-on-submit', {
  init: function () {
    // Get URL parameters
    var urlParams = new URLSearchParams(window.location.search);
    var positionChangeFlag = urlParams.get('positionChange');

    if (positionChangeFlag === 'true') {
      // Apply the position change to the entity
      this.el.setAttribute('position', { x: -2.4, y: 0, z: 3.5 });
	  this.el.setAttribute('rotation', '0 130 0');
    }
  }
});

AFRAME.registerComponent('position-on-submitt', {
  init: function () {
   
    var urlParams = new URLSearchParams(window.location.search);
    var positionChangeFlagz = urlParams.get('positionChange2');

    if (positionChangeFlagz === 'true') {
      
      this.el.setAttribute('position', { x: -10.5, y: 0, z: 21.5 });
	  this.el.setAttribute('rotation', '0 30 0');
    }
  }
});

AFRAME.registerComponent('position-on-submittt', {
  init: function () {
    
    var urlParams = new URLSearchParams(window.location.search);
    var positionChangeFlagx = urlParams.get('positionChange3');

    if (positionChangeFlagx === 'true') {
      
      this.el.setAttribute('position', { x: 8.6, y: 0, z: -5 });
	  this.el.setAttribute('rotation', '0 -120 0');
    }
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
          window.location.href= 'loggedin.php?source=firstfloor'; // Redirect to firstfloor.php
        }, 3500);
      }
    });
  }
});

	AFRAME.registerComponent('zoom-on-click1', {
  schema: {
    originalScale: { type: 'vec3', default: { x: 1.01, y: 0.7, z: 0.005 } }
  },
  init: function () {
    var el = this.el;
    var originalScale = this.data.originalScale;
    var scale = el.getAttribute('scale');
    el.addEventListener('click', function () {
      el.setAttribute('scale', (scale.x === originalScale.x && scale.y === originalScale.y && scale.z === originalScale.z)
        ? { x: scale.x * 1.3, y: scale.y * 1.3, z: scale.z * 1.3 }
        : originalScale
      );
    });
  }
});

AFRAME.registerComponent('zoom-on-click12', {
  schema: {
    originalScale: { type: 'vec3', default: { x: 1.01, y: 0.7, z: 0.005 } }
  },
  init: function () {
    var el = this.el;
    var originalScale = this.data.originalScale;
    var scale = el.getAttribute('scale');
    var childEntity = el.querySelector('a-entity:nth-child(2)'); // Adjust this selector accordingly
    var isScaled = false; // Flag to track the state

    el.addEventListener('click', function () {
      if (!isScaled) {
        el.setAttribute('scale', { x: scale.x * 1.3, y: scale.y * 1.3, z: scale.z * 1.3 });
        childEntity.object3D.position.y += 0.2; // Shift the child entity's position along the y-axis
        childEntity.object3D.position.z -= 30; // Shift the child entity's position along the x-axis
      } else {
        el.setAttribute('scale', originalScale);
        childEntity.object3D.position.y -= 0.2; // Revert the child entity's position shift along the y-axis
        childEntity.object3D.position.z += 30; // Revert the child entity's position shift along the x-axis
      }

      isScaled = !isScaled; // Toggle the state
    });
  }
});

AFRAME.registerComponent('zoom-on-click13', {
  schema: {
    originalScale: { type: 'vec3', default: { x: 1.01, y: 0.7, z: 0.005 } }
  },
  init: function () {
    var el = this.el;
    var originalScale = this.data.originalScale;
    var scale = el.getAttribute('scale');
    var childEntity = el.querySelector('a-entity:nth-child(2)'); // Adjust this selector accordingly
    var isScaled = false; // Flag to track the state

    el.addEventListener('click', function () {
      if (!isScaled) {
        el.setAttribute('scale', { x: scale.x * 1.3, y: scale.y * 1.3, z: scale.z * 1.3 });
        childEntity.object3D.position.y += 0.2; // Shift the child entity's position along the y-axis
        childEntity.object3D.position.z += 30; // Shift the child entity's position along the x-axis
      } else {
        el.setAttribute('scale', originalScale);
        childEntity.object3D.position.y -= 0.2; // Revert the child entity's position shift along the y-axis
        childEntity.object3D.position.z -= 30; // Revert the child entity's position shift along the x-axis
      }

      isScaled = !isScaled; // Toggle the state
    });
  }
});
			AFRAME.registerComponent('zoom-on-click2', {
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

			AFRAME.registerComponent('zoom-on-click3', {
  schema: {
    originalRadius: { type: 'number', default: 0.4 },
    zoomedRadius: { type: 'number', default: 0.53 },
    borderOriginalRadius: { type: 'number', default: 0.415 },
    borderZoomedRadius: { type: 'number', default: 0.545 }
  },
  init: function () {
    var el = this.el;
    var originalRadius = this.data.originalRadius;
    var zoomedRadius = this.data.zoomedRadius;
    var borderOriginalRadius = this.data.borderOriginalRadius;
    var borderZoomedRadius = this.data.borderZoomedRadius;
    var isZoomed = false; // Track zoom state

    el.addEventListener('click', function () {
      isZoomed = !isZoomed; // Toggle zoom state

      var newRadius = isZoomed ? zoomedRadius : originalRadius;
      el.setAttribute('geometry', 'radius', newRadius);

      var borderEntity = el.querySelector('.border');
      var borderRadiusToSet = isZoomed ? borderZoomedRadius : borderOriginalRadius;
      borderEntity.setAttribute('geometry', 'radius', borderRadiusToSet);

      var textEntity = el.querySelector('.text-entity');
      var newTextPosition = isZoomed ? '0 -0.68 0.3' : '0 -0.58 0.2';
      textEntity.setAttribute('position', newTextPosition);
    });
  }
});

AFRAME.registerComponent('zoom-on-click34', {
  schema: {
    originalRadius: { type: 'number', default: 0.4 },
    zoomedRadius: { type: 'number', default: 0.53 },
    borderOriginalRadius: { type: 'number', default: 0.415 },
    borderZoomedRadius: { type: 'number', default: 0.545 }
  },
  init: function () {
    var el = this.el;
    var originalRadius = this.data.originalRadius;
    var zoomedRadius = this.data.zoomedRadius;
    var borderOriginalRadius = this.data.borderOriginalRadius;
    var borderZoomedRadius = this.data.borderZoomedRadius;
    var isZoomed = false; // Track zoom state

    el.addEventListener('click', function () {
      isZoomed = !isZoomed; // Toggle zoom state

      var newRadius = isZoomed ? zoomedRadius : originalRadius;
      el.setAttribute('geometry', 'radius', newRadius);

      var borderEntity = el.querySelector('.border');
      var borderRadiusToSet = isZoomed ? borderZoomedRadius : borderOriginalRadius;
      borderEntity.setAttribute('geometry', 'radius', borderRadiusToSet);

      var textEntity = el.querySelector('.text-entity');
      var newTextPosition = isZoomed ? '0 -0.52 0.3' : '0 -0.58 0.2';
      textEntity.setAttribute('position', newTextPosition);
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

AFRAME.registerComponent('playz-videoz', {
    init: function () {
      var videoEl = document.querySelector('#WFF');
      document.addEventListener('keydown', function (event) {
        if (event.key === 'w') {
          videoEl.play();
         
        }
      });
    },
  });

  AFRAME.registerComponent('playz-videozz', {
    init: function () {
      var videoEl = document.querySelector('#FFF');
      document.addEventListener('keydown', function (event) {
        if (event.key === 'w') {
          videoEl.play();
         
        }
      });
    },
  });

   AFRAME.registerComponent('playz-videozzz', {
    init: function () {
      var videoEl = document.querySelector('#SFF');
      document.addEventListener('keydown', function (event) {
        if (event.key === 'w') {
          videoEl.play();
         
        }
      });
    },
  });


			/*
			*	Ftiaxno to component showhideform gia to antikeimeno poy an to klikaro tha anoigei ti forma
			*  	Otan ginetai klik tha kalei ti function showHideForm()
			*/
		
			
			/*
			*	H function showHideForm() anoigokleinei ti forma
			*	mporei na kaleitai apo to component kai apo to X button tis formas
			*/
			function showHideForm()
			{
				
			
				if  (document.getElementById('myDiv').style.display=='block') // an i forma einai emfanis tha klisei
				{
					
					document.getElementById('myDiv').style.display='none';
				
				}
				else if (document.getElementById('myDiv').style.display=='none') // an i forma einai kleisti
				{
						document.getElementById('myDiv').style.display='block'; // emfanisi formas
				
					
				
				}
			}
			function showHideForm2()
			{
				
			
				if  (document.getElementById('myDiv2').style.display=='block') // an i forma einai emfanis tha klisei
				{
					
					document.getElementById('myDiv2').style.display='none';
				
				}
				else if (document.getElementById('myDiv2').style.display=='none') // an i forma einai kleisti
				{
						document.getElementById('myDiv2').style.display='block'; // emfanisi formas
				
					
				
				}
			}
			function showHideForm3()
			{
				
			
				if  (document.getElementById('myDiv3').style.display=='block') // an i forma einai emfanis tha klisei
				{
					
					document.getElementById('myDiv3').style.display='none';
				
				}
				else if (document.getElementById('myDiv3').style.display=='none') // an i forma einai kleisti
				{
						document.getElementById('myDiv3').style.display='block'; // emfanisi formas
				
					
				
				}
			}

		</script>	
	  
      
</head>
<body>
	  <div id="myDiv" style="display:none; position:absolute; top:50%; left:30%; z-index:10; border-style:solid;">
			Upload Form Where you live?
			<button style="position:absolute; right:0%;" onclick="showHideForm();">X</button>
			<form id="form" method="post" enctype="multipart/form-data" class="w-50">
					
					<?php inputFields("","userfile","","file") ?>
					<?php inputFields("Write something","text","","text") ?>
					<select name="canvastype" id="canvastype">
						<option value="canvasType"> Select Type </option>
						<option value="rec1"> Rectangular 1x2 </option>
						<option value="rec2"> Rectangular 2x1 </option>
						<option value="circ"> Circular </option>
					</select>

					<button id="btnn" class="btn btn-dark" type="submit" name="submit">Submit</button>
				</form>
		</div>

		<div id="myDiv2" style="display:none; position:absolute; top:50%; left:30%; z-index:10; border-style:solid;">
			Upload Form Memes for fun!
			<button style="position:absolute; right:0%;" onclick="showHideForm2();">X</button>
			<form id="form" method="post" enctype="multipart/form-data" class="w-50">
					
					<?php inputFields("","userfile","","file") ?>
					<?php inputFields("Write something","text","","text") ?>
					<select name="canvastype" id="canvastype">
						<option value="canvasType"> Select Type </option>
						<option value="rec1"> Rectangular 1x2 </option>
						<option value="rec2"> Rectangular 2x1 </option>
						<option value="circ"> Circular </option>
						
					</select>
					</br>
					<button id="btnnn" class="btn btn-dark" type="submit" name="submitt">Submit</button>
				</form>
		</div>

		<div id="myDiv3" style="display:none; position:absolute; top:50%; left:30%; z-index:10; border-style:solid;">
			Upload Form Subject-free Wall!
			<button style="position:absolute; right:0%;" onclick="showHideForm3();">X</button>
			<form id="form" method="post" enctype="multipart/form-data" class="w-50">
					
					<?php inputFields("","userfile","","file") ?>
					<?php inputFields("Write something","text","","text") ?>
					
					</br>
					<button id="btnnnn" class="btn btn-dark" type="submit" name="submittt">Submit</button>
				</form>
		</div>

		
		

		<a-scene id="scene" style="z-index:1">
	  
	         <a-assets>

				<audio id="click-sound" src="music/elev2.mp3"></audio>
				<audio id="success" src="music/success.mp3" preload="auto"></audio>

				<a-asset-item id="Plant0" src="objects/Plant.obj"> </a-asset-item>
	            
				<img id="Wally" src="textures/Wallpaper0.jpg">

				<img id="xwma" src="textures/xwma.jpg">
				<img id="plant" src="textures/Leaves.jpg">
				
				<img id="tablettt" src="textures/tablet3.jpg">
				<img id="tablett" src="textures/tablet2.jpg">
				<img id="tablet" src="textures/tablet.jpg">
				<img id="booh1" src="textures/booh1.jpg">
				<img id="booh" src="textures/booh.jpg">
				
				<img id="merme" src="textures/placerr.jpg">

				<img id="ceill" src="textures/newcel.jpg">
				<img id="dimy" src="textures/dimfloor1.jpg">
				<img id="marb1" src="textures/marble1.jpg">
				
				<img id="elfloor" src="textures/elevfloor.jpg">
				<img id="elmirror" src="textures/elevmir.jpg">
				<img id="elbuttons" src="textures/elevbuttons.jpg">

				<img id="skr" src="textures/skr.jpg">
				 
				<img id="balcon" src="textures/mybalconyview.jpg">
				<img id="job" src="textures/jobb.jpg">

				 <video id="WFF" autoplay loop muted="true" src="videos/welcomeff.mp4"> </video>
				 <video id="FFF" autoplay loop muted="true" src="videos/ffmeme.mp4"> </video>
				 <video id="SFF" autoplay loop muted="true" src="videos/exitff.mp4"> </video>

				 <?php 
				
				
	            $res=mysqli_query($conn, 'SELECT id, userfile FROM filez');
	            while($row=mysqli_fetch_array($res))
				{
					echo '<img id="canva-'.$row['id'].'" src="'.$row['userfile'].'">';
				}

				$rez=mysqli_query($conn, 'SELECT id, userfile FROM filezz');
				while($rowz=mysqli_fetch_array($rez))
				{
					echo '<img id="canvaz-'.$rowz['id'].'" src="'.$rowz['userfile'].'">';
				}

				$rex=mysqli_query($conn, 'SELECT id, userfile FROM filezzz');
				while($rowx=mysqli_fetch_array($rex))
				{
					echo '<img id="canvax-'.$rowx['id'].'" src="'.$rowx['userfile'].'">';
				}
				?>
			 </a-assets>


			  <a-entity id="rig" position-on-submit position-on-submitt position-on-submittt position"25 10 0" rotation="0 180 0">
	         <a-entity id="player" 
			 camera look-controls  
			 
					 wasd-controls="acceleration:20"
					 position="5.35 1.95 -1">
					 <a-cursor rayOrigin="mouse" position="0 0 -0.1" scale="0.1 0.1 0.1"> </a-cursor>
                    
             </a-entity>
			</a-entity>
			<a-entity light="type: directional; color: #ffff00; intensity: 0.5"> </a-entity>
			 <a-entity light="type: ambient; color: #FFF; intensity: 0.9"> </a-entity> 

			 <div id="userWindow" style="position:fixed; bottom:10px; right:10px; z-index:1000; border:1px solid black; padding:10px;">
  <div>
    User: <?php echo (isset($_SESSION['userzname'])) ? $_SESSION['userzname'] : ''; ?>
  </div>
  <form action="firstfloor.php" method="post">
    <input type="submit" name="logout" value="Log Out">
  </form>
</div>

		<!-- ROOM -->
				
				<a-entity playz-videoz geometry="primitive: plane; width: 2; height: 1.1; depth: 0.02" material="src: #WFF; side: front" rotation="0 180 0" position="0 3.35 4"></a-entity>
				<a-entity geometry="primitive: box; width: 2; height: 1.1; depth: 0.02" material="color: black" rotation="0 180 0" position="0 3.35 4.02"></a-entity>
				<a-entity geometry="primitive: cylinder" material="color: black" position="0 3.9 4" scale="0.015 0.1 0.02"></a-entity>
				
				<a-entity playz-videozz geometry="primitive: plane; width: 2; height: 1.1; depth: 0.02" material="src: #FFF; side: front" rotation="0 180 0" position="0 3.35 13.5"></a-entity>
				<a-entity geometry="primitive: box; width: 2; height: 1.1; depth: 0.02" material="color: black" rotation="0 180 0" position="0 3.35 13.52"></a-entity>
				<a-entity geometry="primitive: cylinder" material="color: black" position="0 3.9 13.5" scale="0.015 0.1 0.02"></a-entity>
				
"				<a-entity playz-videozzz geometry="primitive: box; width: 1.2; height: 0.6; depth: 0.02" material="src: #SFF" rotation="0 0 0" position="-5 3.9 -1"></a-entity>
				
				 <a-entity geometry="primitive: box; height: 1.5; width: 20; depth: 0.1" 
               material="src: #xwma; color: #F3F3ED; side: double; repeat: 2 1" 
			   position="0 0 19.8"
               rotation="90 0 0"> 
            </a-entity>

			<a-entity geometry="primitive: box; height: 0.2; width: 20; depth: 0.2" 
               material="color: black; side: double; repeat: 8 8" 
			   position="0 0 20.55"
               rotation="90 0 0"> 
            </a-entity>

			<a-entity geometry="primitive: box; height: 1.6; width: 0.2; depth: 0.2" 
               material="color: black; side: double; repeat: 8 8" 
			   position="-10 0 19.8"
               rotation="90 0 0"> 
            </a-entity>

			<a-entity geometry="primitive: box; height: 1.6; width: 0.2; depth: 0.2" 
               material="color: black; side: double; repeat: 8 8" 
			   position="10 0 19.8"
               rotation="90 0 0"> 
            </a-entity>

			  <a-entity obj-model="obj: #Plant0"
						material="src: #plant" position="-9 0.35 19.2" rotation="180 0 0" 
						scale="0.01 0.005 0.01" shadow="receive: true"> 
			</a-entity>

			<a-entity obj-model="obj: #Plant0"
						material="src: #plant" position="-5 0.35 19.3" rotation="180 0 0" 
						scale="0.01 0.005 0.01" shadow="receive: true"> 
			</a-entity>

			<a-entity obj-model="obj: #Plant0"
						material="src: #plant" position="-2 0.35 19.2" rotation="180 0 0" 
						scale="0.01 0.005 0.01" shadow="receive: true"> 
			</a-entity>

			<a-entity obj-model="obj: #Plant0"
						material="src: #plant" position="0 0.35 19.3" rotation="180 0 0" 
						scale="0.01 0.005 0.01" shadow="receive: true"> 
			</a-entity>

			<a-entity obj-model="obj: #Plant0"
						material="src: #plant" position="2 0.35 19.2" rotation="180 0 0" 
						scale="0.01 0.005 0.01" shadow="receive: true"> 
			</a-entity>

			<a-entity obj-model="obj: #Plant0"
						material="src: #plant" position="5 0.35 19.3" rotation="180 0 0" 
						scale="0.01 0.005 0.01" shadow="receive: true"> 
			</a-entity>

			<a-entity obj-model="obj: #Plant0"
						material="src: #plant" position="9 0.35 19.2" rotation="180 0 0" 
						scale="0.01 0.005 0.01" shadow="receive: true"> 
			</a-entity>
			  

	        <a-entity geometry="primitive: plane; height: 20; width: 20" 
               material="src: #dimy; color: #F3F3ED; side: double; repeat: 8 8" 
			   position="0 0 9"
               rotation="90 0 0"> 
            </a-entity>

			 <a-entity geometry="primitive: plane; height: 20; width: 20" 
               material="src: #ceill; color: #F3F3ED; side: double; repeat: 4 8" 
			   position="0 4.2 9"
               rotation="-90 0 0"> 
            </a-entity>

			 <a-entity geometry="primitive: plane; height: 3.6; width: 14" 
               material="src: #marb1; color: #F3F3ED; side: double; repeat: 2 1" 
			   position="3 1.8 -1"
               rotation="0 0 0"> 
            </a-entity>

			<a-entity geometry="primitive: box"
					  material="color: black"
					  position="3 4.2 -1"
					  scale="14 0.05 0.1">
			</a-entity>

			

			<a-entity geometry="primitive: box"
					  material="color: black"
					  position="2 3.6 -1"
					  scale="16.2 0.05 0.1">
			</a-entity>


			<a-entity geometry="primitive: plane; height: 4.2; width: 20" 
               material="src: #marb1; color: #F3F3ED; side: double; repeat: 4 1" 
			   position="-10 2.1 9"
               rotation="0 90 0"> 
            </a-entity>
			

			 <a-entity geometry="primitive: plane; height: 3.6; width: 20" 
               material="src: #marb1; color: #F3F3ED; side: double; repeat: 4 1" 
			   position="10 1.8 9"
               rotation="0 90 0"> 
            </a-entity> 

			<a-entity geometry="primitive: box"
					  material="color: black"
					  position="10 4.2 9"
					  scale="0.1 0.05 20">
			</a-entity>

				<a-entity geometry="primitive: box"
					  material="color: black"
					  position="10 3.6 9"
					  scale="0.1 0.05 20">
			</a-entity>

		


		
		
			<a-entity geometry="primitive: box"
					  material="src: #marb1; color: #F3F3ED"
					  position="-6.5 1.8 9"
					  scale="7 3.6 0.13">
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
					  position="-6.57 1.8 -0.965" 
					  scale="1 3.6 0.015"> 
			</a-entity>

			<a-entity id="entity1"
						geometry="primitive: box" 
					  material="opacity: 0.39; color: white" 
					  position="-3.49 1.8 -0.985" 
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
					  material="opacity: 0.21; color: white" 
					  position="-5 2.1 19" 
					  scale="9.9 4.2 0.015"> 
			</a-entity>

			<a-entity geometry="primitive: box" 
					  material="opacity: 0.21; color: white" 
					  position="5 2.1 19" 
					  scale="9.9 4.2 0.015"> 
			</a-entity>

			<a-entity geometry="primitive: box"
					  material="color: black"
					  position="0 2.1 19"
					  scale="0.1 4.2 0.1">
			</a-entity>
			
			<a-entity geometry="primitive: box"
					  material="color: black"
					  position="-10 2.1 19"
					  scale="0.1 4.2 0.1">
			</a-entity>

			

			<a-entity geometry="primitive: box"
					  material="color: black"
					  position="-5 4.2 19"
					  scale="9.9 0.1 0.1">
			</a-entity>

		

		

			<a-entity geometry="primitive: box"
					  material="color: black"
					  position="-5 0 19"
					  scale="9.9 0.1 0.1">
			</a-entity> 

			<a-entity geometry="primitive: box"
					  material="color: black"
					  position="10 2.1 19"
					  scale="0.1 4.2 0.1">
			</a-entity>

				<a-entity geometry="primitive: box"
					  material="color: black"
					  position="10 3.9 -1"
					  scale="0.1 0.6 0.1">
			</a-entity>

			<a-entity geometry="primitive: box"
					  material="color: black"
					  position="5 4.2 19"
					  scale="9.9 0.1 0.1">
			</a-entity>

		
			<a-entity geometry="primitive: box"
					  material="color: black"
					  position="5 0 19"
					  scale="9.9 0.1 0.1">
			</a-entity> 


			

			<a-entity geometry="primitive: box"
					 material="src: #booh1; color: white"
					  position="-7.5 1.505 0"
					  scale="0.54 0.01 0.64">
			</a-entity> 

			<a-entity geometry="primitive: box"
					 material="src: #tablet; color: grey"
					  position="-7.5 1.505 0"
					  rotation="0 90 0"
					  scale="0.22 0.022 0.285"
					  onclick="showHideForm();">
			</a-entity> 

			<a-entity geometry="primitive: box"
					 material="src: #marb1; color: #F3F3ED"
					  position="-7.5 0.05 0"
					  scale="0.62 0.1 0.72">
			</a-entity> 

			<a-entity geometry="primitive: box"
					material="src: #booh; color: white"
					position="-7.5 0.75 0"
					scale="0.55 1.5 0.65">
					</a-entity>

			<a-entity geometry="primitive: box"
					material="src: #marb1; color: #F3F3ED"
					position="-7.5 0.05 18"
					scale="0.62 0.1 0.72">
					</a-entity>

					<a-entity geometry="primitive: box"
					material="src: #booh; color: white"
					position="-7.5 0.75 18"
					scale="0.55 1.5 0.65">
					</a-entity>

					<a-entity geometry="primitive: box"
					 material="src: #booh1; color: white"
					  position="-7.5 1.505 18"
					  scale="0.54 0.01 0.64">
			</a-entity> 

			<a-entity geometry="primitive: box"
					 material="src: #tablettt; color: grey"
					  position="-7.5 1.505 18"
					  rotation="0 90 0"
					  scale="0.22 0.022 0.285"
					  onclick="showHideForm2();">
			</a-entity> 
		

					<a-entity geometry="primitive: box"
					 material="src: #marb1; color: #F3F3ED"
					  position="8 0.05 0"
					  scale="0.62 0.1 0.72">
			</a-entity> 

			<a-entity geometry="primitive: box"
					material="src: #booh; color: white"
					position="8 0.75 0"
					scale="0.55 1.5 0.65">
					</a-entity>

					<a-entity geometry="primitive: box"
					 material="src: #booh1; color: white"
					  position="8 1.505 0"
					  scale="0.54 0.01 0.64">
			</a-entity> 

			<a-entity geometry="primitive: box"
					 material="src: #tablett; color: grey"
					  position="8 1.505 0"
					  rotation="0 -90 0"
					  scale="0.22 0.022 0.285"
					  onclick="showHideForm3();">
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

				<a-entity 
									description="Mike24: Hello guys! I live in a small neighborhood in Serres city, Greece and this is my balcony view!"
									material="src: #balcon"
									geometry="primitive: box"
									position="-9.99 1 0.25"
									
									scale="0.005 0.92 0.7"
									showtext
									zoom-on-click2>
									
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="-0.84 0 0" rotation="0 -90 0" scale="1.035 1.035 1.035">
									 </a-entity>
										<a-entity id="msg-1" geometry="primitive: plane; height: 0.22; width: auto" material="src: #merme; opacity: 0.7; side: double" style="z-index: 10" 
												  visible="false" rotation="0 90 0" position="40 -0.67 0" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.85; letterSpacing: 4; lineHeight: 61" >
									   </a-entity>

								  </a-entity>

								  <a-entity 
									description="Mike24: Happens to me all the time!"
									material="src: #job"
									geometry="primitive: box"
									position="-4.15 1 9.075"
									scale="1.01 0.7 0.005"
									showtext
									zoom-on-click13>
									
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="0 0 -0.8" scale="1.035 1.035 1.035">
										 </a-entity>
										<a-entity id="msg-23" geometry="primitive: plane; height: 0.3; width: 0.7" material="src: #merme; opacity: 0.73; side: double" style="z-index: 10" 
												  visible="false" position="0 -0.65 40" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.72; letterSpacing: 5; lineHeight: 61" >
									   </a-entity>
									
								  </a-entity>
			
			<!-- ECHO DYNAMICALLY -->

			<?php 
			
			$ress=mysqli_query($conn, 'SELECT id, usernamee, textt, typuu FROM filez');
				$newPosit= 0.25;
				$firstPosit= 1.75;
				$sideStart= -8.7;
				$sideTop= -8.7;
	            while($roww=mysqli_fetch_array($ress))
				{
					if($roww['typuu']=='rec2') 
					{
						if($roww['id']<= 9)
						{
							if($roww['id']<= 5)
							{
								echo '<a-entity 
									description="' . $roww['usernamee'] . ': ' . $roww['textt'] . '"
									material="src: #canva-'.$roww['id'].'"
									geometry="primitive: box"
									position="-9.99 1 '.$firstPosit.'"
									rotation="0 90 0"
									scale="1.01 0.7 0.005"
									showtext
									zoom-on-click13>
									
										
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="0 0 -0.84" scale="1.035 1.035 1.035">
										 </a-entity>
										
										<a-entity id="msg-' . $roww['id'] . '" geometry="primitive: plane; height: 0.3; width: 0.7" material="src: #merme; opacity: 0.73; side: double" style="z-index: 10" 
												  visible="false" position="0 -0.65 40" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.72; letterSpacing: 5; lineHeight: 61" >
									   </a-entity>
								  </a-entity> ' ;
							}
							else 
							{
								echo '<a-entity 
									description="' . $roww['usernamee'] . ': ' . $roww['textt'] . '"
									material="src: #canva-'.$roww['id'].'"
									geometry="primitive: box"
									position="'.$sideStart.' 1 8.92"
									
									scale="1.01 0.7 0.005"
									showtext
									zoom-on-click12>
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="0 0 0.84" scale="1.035 1.035 1.035">
										 </a-entity>
										<a-entity id="msg-' . $roww['id'] . '" geometry="primitive: plane; height: 0.3; width: 0.7" material="src: #merme; opacity: 0.73; side: double" style="z-index: 10" 
												  visible="false" rotation="0 180 0" position="0 -0.65 -40" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.72; letterSpacing: 5; lineHeight: 61" >
									   </a-entity>
								  </a-entity> ' ;
								$sideStart+= 1.5;
							}
						} 
						else 
						{
							if($roww['id']<= 15)
							{
								echo '<a-entity 
									description="' . $roww['usernamee'] . ': ' . $roww['textt'] . '"
									material="src: #canva-'.$roww['id'].'"
									geometry="primitive: box"
									position="-9.99 2.2 '.$newPosit.'"
									rotation="0 90 0"
									scale="1.01 0.7 0.005"
									showtext
									zoom-on-click1>
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="0 0 -0.84" scale="1.035 1.035 1.035">
										 </a-entity>
										<a-entity id="msg-' . $roww['id'] . '" geometry="primitive: plane; height: 0.3; width: 0.7" material="src: #merme; opacity: 0.73; side: double" style="z-index: 10" 
												  visible="false" position="0 -0.74 40" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.72; letterSpacing: 4; lineHeight: 61" >
									   </a-entity>
								  </a-entity> ' ;
								$newPosit+= 1.5;
							}
							else 
							{
								echo '<a-entity 
									description="' . $roww['usernamee'] . ': ' . $roww['textt'] . '"
									material="src: #canva-'.$roww['id'].'"
									geometry="primitive: box"
									position="'.$sideTop.' 2.2 8.92"
									scale="1.01 0.7 0.005"
									showtext
									zoom-on-click1>
										
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="0 0 0.84" scale="1.035 1.035 1.035">
										 </a-entity>
										<a-entity id="msg-' . $roww['id'] . '" geometry="primitive: plane; height: 0.3; width: 0.7" material="src: #merme; opacity: 0.73; side: double" style="z-index: 10" 
												  visible="false" rotation="0 180 0" position="0 -0.74 -40" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.72; letterSpacing: 5; lineHeight: 61" >
									   </a-entity>
								  </a-entity> ' ;
								$sideTop+= 1.5;	
							}
						}
					}
					elseif($roww['typuu']== 'rec1')
					{
						if($roww['id']<= 9)
						{
							if($roww['id']<= 5)
							{
								echo '<a-entity 
									description="' . $roww['usernamee'] . ': ' . $roww['textt'] . '"
									material="src: #canva-'.$roww['id'].'"
									geometry="primitive: box"
									position="-9.99 1 '.$firstPosit.'"
									
									scale="0.005 0.92 0.7"
									showtext
									zoom-on-click2>
									
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="-0.84 0 0" rotation="0 -90 0" scale="1.035 1.035 1.035">
									 </a-entity>
										<a-entity id="msg-' . $roww['id'] . '" geometry="primitive: plane; height: 0.22; width: auto" material="src: #merme; opacity: 0.7; side: double" style="z-index: 10" 
												  visible="false" rotation="0 90 0" position="40 -0.67 0" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.85; letterSpacing: 4; lineHeight: 61" >
									   </a-entity>

								  </a-entity> ' ;
							}
							else 
							{
								echo '<a-entity 
									description="' . $roww['usernamee'] . ': ' . $roww['textt'] . '"
									material="src: #canva-'.$roww['id'].'"
									geometry="primitive: box"
									position="'.$sideStart.' 1 8.92"
									rotation="0 90 0"
									scale="0.005 0.92 0.7"
									showtext
									zoom-on-click2>
										
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="-0.84 0 0" rotation="0 -90 0" scale="1.035 1.035 1.035">
										</a-entity>
										<a-entity id="msg-' . $roww['id'] . '" geometry="primitive: plane; height: 0.22; width: auto" material="src: #merme; opacity: 0.7; side: double" style="z-index: 10" 
												  visible="false" rotation="0 90 0" position="40 -0.67 0" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.85; letterSpacing: 4; lineHeight: 61" >
									   </a-entity>
								  </a-entity> ' ;
								$sideStart+= 1.5;
							}
						} 
						else 
						{
							if($roww['id']<= 15)
							{
								echo '<a-entity 
									description="' . $roww['usernamee'] . ': ' . $roww['textt'] . '"
									material="src: #canva-'.$roww['id'].'"
									geometry="primitive: box"
									position="-9.99 2.2 '.$newPosit.'"
									scale="0.005 0.92 0.7"
									showtext
									zoom-on-click2>
									
										
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="-0.84 0 0" rotation="0 -90 0" scale="1.035 1.035 1.035">
										</a-entity>
										<a-entity id="msg-' . $roww['id'] . '" geometry="primitive: plane; height: 0.22; width: auto" material="src: #merme; opacity: 0.7; side: double" style="z-index: 10" 
												  visible="false" rotation="0 90 0" position="40 -0.67 0" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.85; letterSpacing: 4; lineHeight: 61" >
									   </a-entity>
								  </a-entity> ' ;
							$newPosit+= 1.5;
							}
							else 
							{
								echo '<a-entity 
									description="' . $roww['usernamee'] . ': ' . $roww['textt'] . '"
									material="src: #canva-'.$roww['id'].'"
									geometry="primitive: box"
									position="'.$sideTop.' 2.2 8.92"
									rotation="0 90 0"
									scale="0.005 0.92 0.7" 
									showtext
									zoom-on-click2>
									
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="-0.84 0 0" rotation="0 -90 0" scale="1.035 1.035 1.035">
										</a-entity>
										<a-entity id="msg-' . $roww['id'] . '" geometry="primitive: plane; height: 0.22; width: auto" material="src: #merme; opacity: 0.7; side: double" style="z-index: 10" 
												  visible="false" rotation="0 90 0" position="40 -0.67 0" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.85; letterSpacing: 4; lineHeight: 61" >
									   </a-entity>
								  </a-entity> ' ;
							$sideTop+= 1.5;
							}
						} 
				    }
					else 
					{
						if($roww['id']<= 9)
						{
							if($roww['id']<= 5)
							{
								echo '<a-entity 
									description="' . $roww['usernamee'] . ': ' . $roww['textt'] . '"
									material="src: #canva-'.$roww['id'].'"
									geometry="primitive: circle; radius: 0.4"
									position="-9.99 1 '.$firstPosit.'"
									rotation="0 90 0"
									showtext
									zoom-on-click34>
									
									<a-entity class="border" geometry="primitive: circle; radius: 0.415" position="0 0 -0.0065" material="color: black">
									</a-entity>
									<a-entity class="text-entity" id="msg-' . $roww['id'] . '" geometry="primitive: plane; height: 0.22; width: 0.64" material="src: #merme; opacity: 0.73; side: double" style="z-index: 10" 
												  visible="false" position="0 -0.58 0.2" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 60; width: 0.63; letterSpacing: 4; lineHeight: 60" >
									   </a-entity>
								  </a-entity> ' ;
							}
							else 
							{
								echo '<a-entity 
									description="' . $roww['usernamee'] . ': ' . $roww['textt'] . '"
									material="src: #canva-'.$roww['id'].'"
									geometry="primitive: circle; radius: 0.4"
									position="'.$sideStart.' 1 8.92"
									rotation="0 180 0"
									showtext
									zoom-on-click34>
									
									<a-entity class="border" geometry="primitive: circle; radius: 0.415" position="0 0 -0.0065" material="color: black">
									</a-entity>
									<a-entity class="text-entity" id="msg-' . $roww['id'] . '" geometry="primitive: plane; height: 0.22; width: 0.64" material="src: #merme; opacity: 0.73; side: double" style="z-index: 10" 
												  visible="false" position="0 -0.58 0.2" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 60; width: 0.63; letterSpacing: 4; lineHeight: 60" >
									   </a-entity>
								  </a-entity> ' ;
								$sideStart+= 1.5;
							}
						} 
						else 
						{
							if($roww['id']<= 15)
							{
								echo '<a-entity 
										description="' . $roww['usernamee'] . ': ' . $roww['textt'] . '"
										material="src: #canva-'.$roww['id'].'"
										geometry="primitive: circle; radius: 0.4"
										position="-9.99 2.2 '.$newPosit.'"
										rotation="0 90 0"
										showtext
										zoom-on-click3>
										
										<a-entity class="border" geometry="primitive: circle; radius: 0.415" position="0 0 -0.0065" material="color: black">
									</a-entity>
										<a-entity class="text-entity" id="msg-' . $roww['id'] . '" geometry="primitive: plane; height: 0.22; width: 0.64" material="src: #merme; opacity: 0.73; side: double" style="z-index: 10" 
												  visible="false" position="0 -0.58 0.2" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 60; width: 0.63; letterSpacing: 4; lineHeight: 60" >
									   </a-entity>
									  </a-entity> ' ;
								$newPosit+= 1.5;
							}
							else 
							{
								 echo '<a-entity 
									description="' . $roww['usernamee'] . ': ' . $roww['textt'] . '"
									material="src: #canva-'.$roww['id'].'"
									geometry="primitive: circle; radius: 0.4"
									position="'.$sideTop.' 2.2 8.92"
									rotation="0 180 0"
									showtext
									zoom-on-click3>
									
									<a-entity class="border" geometry="primitive: circle; radius: 0.415" position="0 0 -0.0065" material="color: black">
									</a-entity>
									<a-entity class="text-entity" id="msg-' . $roww['id'] . '" geometry="primitive: plane; height: 0.22; width: 0.64" material="src: #merme; opacity: 0.73; side: double" style="z-index: 10" 
												  visible="false" position="0 -0.58 0.2" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 60; width: 0.63; letterSpacing: 4; lineHeight: 60" >
									   </a-entity>
								  </a-entity> ' ;
								$sideTop+= 1.5;
							}
						}
					}
					$firstPosit+= 1.5;
				}

			$rezz=mysqli_query($conn, 'SELECT id, usernamee, textt, typuu FROM filezz');
				$newPositz= 10;
				$firstPositz= 10;
	            $sideStartz= -5.65;
				$sideTopz= -4.15;
	            while($rowwz=mysqli_fetch_array($rezz))
				{
					if($rowwz['typuu']=='rec2') 
					{
						if($rowwz['id']<= 9)
						{
							if($rowwz['id']<= 3)
							{
								echo '<a-entity 
									description="' . $rowwz['usernamee'] . ': ' . $rowwz['textt'] . '"
									material="src: #canvaz-'.$rowwz['id'].'"
									geometry="primitive: box"
									position="'.$sideStartz.' 1 9.075"
									scale="1.01 0.7 0.005"
									showtext
									zoom-on-click13>
									
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="0 0 -0.8" scale="1.035 1.035 1.035">
										 </a-entity>
										<a-entity id="msg-' . $rowwz['id'] . '" geometry="primitive: plane; height: 0.3; width: 0.7" material="src: #merme; opacity: 0.73; side: double" style="z-index: 10" 
												  visible="false" position="0 -0.65 40" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.72; letterSpacing: 5; lineHeight: 61" >
									   </a-entity>
									
								  </a-entity> ' ;
								$sideStartz-= 1.5;
							}
							else 
							{
								echo '<a-entity 
									description="' . $rowwz['usernamee'] . ': ' . $rowwz['textt'] . '"
									material="src: #canvaz-'.$rowwz['id'].'"
									geometry="primitive: box"
									position="-9.99 1 '.$firstPositz.'"
									rotation="0 90 0"
									scale="1.01 0.7 0.005"
									showtext
									zoom-on-click13>
									
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="0 0 -0.8" scale="1.035 1.035 1.035">
										 </a-entity>
										<a-entity id="msg-' . $rowwz['id'] . '" geometry="primitive: plane; height: 0.3; width: 0.7" material="src: #merme; opacity: 0.73; side: double" style="z-index: 10" 
												  visible="false" position="0 -0.65 40" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.72; letterSpacing: 5; lineHeight: 61" >
									   </a-entity>
									
								  </a-entity> ' ;
								$firstPositz+= 1.5;
							}
						} 
						else 
						{
							if($rowwz['id']<= 13)
							{
								echo '<a-entity 
									description="' . $rowwz['usernamee'] . ': ' . $rowwz['textt'] . '"
									material="src: #canvaz-'.$rowwz['id'].'"
									geometry="primitive: box"
									position="'.$sideTopz.' 2.2 9.075"
									scale="1.01 0.7 0.005"
									showtext
									zoom-on-click1>
									
										
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="0 0 -0.8" scale="1.035 1.035 1.035">
										</a-entity>
										<a-entity id="msg-' . $rowwz['id'] . '" geometry="primitive: plane; height: 0.3; width: 0.7" material="src: #merme; opacity: 0.73; side: double" style="z-index: 10" 
												  visible="false" position="0 -0.74 40" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.72; letterSpacing: 4; lineHeight: 61" >
									   </a-entity>
								  </a-entity> ' ;
								$sideTopz-= 1.5;
							}
							else 
							{
								echo '<a-entity 
									description="' . $rowwz['usernamee'] . ': ' . $rowwz['textt'] . '"
									material="src: #canvaz-'.$rowwz['id'].'"
									geometry="primitive: box"
									position="-9.99 2.2 '.$newPositz.'"
									rotation="0 90 0"
									scale="1.01 0.7 0.005"
									showtext
									zoom-on-click1>
									
										
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="0 0 -0.8"  scale="1.035 1.035 1.035">
										</a-entity>
										<a-entity id="msg-' . $rowwz['id'] . '" geometry="primitive: plane; height: 0.3; width: 0.7" material="src: #merme; opacity: 0.73; side: double" style="z-index: 10" 
												  visible="false" position="0 -0.74 40" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.72; letterSpacing: 4; lineHeight: 61" >
									   </a-entity>
								  </a-entity> ' ;
								$newPositz+= 1.5;
							}
						}
					}
					elseif($rowwz['typuu']== 'rec1')
					{
						if($rowwz['id']<= 9)
						{
							if($rowwz['id']<= 3)
							{
								echo '<a-entity 
									description="' . $rowwz['usernamee'] . ': ' . $rowwz['textt'] . '"
									material="src: #canvaz-'.$rowwz['id'].'"
									geometry="primitive: box"
									position="'.$sideStartz.' 1 9.075"
									rotation="0 90 0"
									scale="0.005 0.92 0.7"
									showtext
									zoom-on-click2>
										
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="0.8 0 0" rotation="0 90 0" scale="1.035 1.035 1.035">
										</a-entity>
										<a-entity id="msg-' . $rowwz['id'] . '" geometry="primitive: plane; height: 0.22; width: auto" material="src: #merme; opacity: 0.7; side: double" style="z-index: 10" 
												  visible="false" rotation="0 -90 0" position="-40 -0.67 0" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.85; letterSpacing: 4; lineHeight: 61" >
									   </a-entity>
								  </a-entity> ' ;
								$sideStartz-= 1.5;
							}
							else 
							{
								echo '<a-entity 
									description="' . $rowwz['usernamee'] . ': ' . $rowwz['textt'] . '"
									material="src: #canvaz-'.$rowwz['id'].'"
									geometry="primitive: box"
									position="-9.99 1 '.$firstPositz.'"
									scale="0.005 0.92 0.7"
									showtext
									zoom-on-click2>
										
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="-0.8 0 0" rotation="0 90 0" scale="1.035 1.035 1.035">
										</a-entity>
										<a-entity id="msg-' . $rowwz['id'] . '" geometry="primitive: plane; height: 0.22; width: auto" material="src: #merme; opacity: 0.7; side: double" style="z-index: 10" 
												  visible="false" rotation="0 90 0" position="40 -0.67 0" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.85; letterSpacing: 4; lineHeight: 61" >
									   </a-entity>
								  </a-entity> ' ;
								 $firstPositz+= 1.5;
							}
						} 
						else 
						{
							if($rowwz['id']<= 13)
							{	
								echo '<a-entity 
									description="' . $rowwz['usernamee'] . ': ' . $rowwz['textt'] . '"
									material="src: #canvaz-'.$rowwz['id'].'"
									geometry="primitive: box"
									position="'.$sideTopz.' 2.2 9.075"
									rotation="0 90 0"
									scale="0.005 0.92 0.7"
									showtext
									zoom-on-click2>
									
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="0.8 0 0" rotation="0 90 0"  scale="1.035 1.035 1.035">
										</a-entity>
										<a-entity id="msg-' . $rowwz['id'] . '" geometry="primitive: plane; height: 0.22; width: auto" material="src: #merme; opacity: 0.7; side: double" style="z-index: 10" 
												  visible="false" rotation="0 -90 0" position="-40 -0.67 0" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.85; letterSpacing: 4; lineHeight: 61" >
									   </a-entity>
								  </a-entity> ' ;
							$sideTopz-= 1.5;
							}
							else 
							{
								echo '<a-entity 
									description="' . $rowwz['usernamee'] . ': ' . $rowwz['textt'] . '"
									material="src: #canvaz-'.$rowwz['id'].'"
									geometry="primitive: box"
									position="-9.99 2.2 '.$newPositz.'"
									scale="0.005 0.92 0.7"
									showtext
									zoom-on-click2>
								
										<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="-0.8 0 0" rotation="0 90 0" scale="1.035 1.035 1.035">
										</a-entity>
										<a-entity id="msg-' . $rowwz['id'] . '" geometry="primitive: plane; height: 0.22; width: auto" material="src: #merme; opacity: 0.7; side: double" style="z-index: 10" 
												  visible="false" position="35 -0.67 0" rotation="0 90 0" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.85; letterSpacing: 4; lineHeight: 61" >
									   </a-entity>
								  </a-entity> ' ;
							$newPositz+= 1.5;
							}
						} 
				    }
					else 
					{
						if($rowwz['id']<= 9)
						{
							if($rowwz['id']<= 3)
							{
								echo '<a-entity 
									description="' . $rowwz['usernamee'] . ': ' . $rowwz['textt'] . '"
									material="src: #canvaz-'.$rowwz['id'].'"
									geometry="primitive: circle; radius: 0.4"
									position="'.$sideStartz.' 1 9.075"
									rotation="0 0 0"
									showtext
									zoom-on-click34>
									
									<a-entity class="border" geometry="primitive: circle; radius: 0.415" position="0 0 -0.0065" material="color: black">
									</a-entity>
									<a-entity class="text-entity" id="msg-' . $rowwz['id'] . '" geometry="primitive: plane; height: 0.22; width: 0.64" material="src: #merme; opacity: 0.73; side: double" style="z-index: 10" 
												  visible="false" position="0 -0.58 0.2" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 60; width: 0.63; letterSpacing: 4; lineHeight: 60" >
									   </a-entity>
								  </a-entity> ' ;
								$sideStartz-= 1.5;
							}
							else 
							{
								echo '<a-entity 
									description="' . $rowwz['usernamee'] . ': ' . $rowwz['textt'] . '"
									material="src: #canvaz-'.$rowwz['id'].'"
									geometry="primitive: circle; radius: 0.4"
									position="-9.99 1 '.$firstPositz.'"
									rotation="0 90 0"
									showtext
									zoom-on-click34>
									
									<a-entity class="border" geometry="primitive: circle; radius: 0.415" position="0 0 -0.0065" material="color: black">
									</a-entity>
									<a-entity class="text-entity" id="msg-' . $rowwz['id'] . '" geometry="primitive: plane; height: 0.22; width: 0.64" material="src: #merme; opacity: 0.73; side: double" style="z-index: 10" 
												  visible="false" position="0 -0.58 0.2" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 60; width: 0.63; letterSpacing: 4; lineHeight: 60" >
									   </a-entity>
								  </a-entity> ' ;
								$firstPositz+= 1.5;
							}
						} 
						else 
						{
							if($rowwz['id']<= 13)
							{
								echo '<a-entity 
									description="' . $rowwz['usernamee'] . ': ' . $rowwz['textt'] . '"
									material="src: #canvaz-'.$rowwz['id'].'"
									geometry="primitive: circle; radius: 0.4"
									position="'.$sideTopz.' 2.2 9.075"
									rotation="0 0 0"
									showtext
									zoom-on-click3>
									
									<a-entity class="border" geometry="primitive: circle; radius: 0.415" position="0 0 -0.0065" material="color: black">
									</a-entity>
									<a-entity class="text-entity" id="msg-' . $rowwz['id'] . '" geometry="primitive: plane; height: 0.22; width: 0.64" material="src: #merme; opacity: 0.73; side: double" style="z-index: 10" 
												  visible="false" position="0 -0.58 0.2" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 60; width: 0.63; letterSpacing: 4; lineHeight: 60" >
									   </a-entity>
								  </a-entity> ' ;
								$sideTopz-= 1.5;
							}
							else 
							{
								 echo '<a-entity 
										description="' . $rowwz['usernamee'] . ': ' . $rowwz['textt'] . '"
										material="src: #canvaz-'.$rowwz['id'].'"
										geometry="primitive: circle; radius: 0.4"
										position="-9.99 2.2 '.$newPositz.'"
										rotation="0 90 0"
										showtext
										zoom-on-click3>
										
										<a-entity class="border" geometry="primitive: circle; radius: 0.415" position="0 0 -0.0065" material="color: black">
										</a-entity>
										<a-entity class="text-entity" id="msg-' . $rowwz['id'] . '" geometry="primitive: plane; height: 0.22; width: 0.64" material="src: #merme; opacity: 0.73; side: double" style="z-index: 10" 
												  visible="false" position="0 -0.58 0.2" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 60; width: 0.63; letterSpacing: 4; lineHeight: 60" >
									   </a-entity>
									  </a-entity> ' ;
								$newPositz+= 1.5;
							}
						}
					}
				}

				$rexx=mysqli_query($conn, 'SELECT id, usernamee, textt FROM filezzz');
				$newPositx= 0.25;
				$firstPositx= 0.25;
				
	            while($rowwx=mysqli_fetch_array($rexx))
				{
					
					if($rowwx['id']<= 17)
						{
								echo '<a-entity 
									description="' . $rowwx['usernamee'] . ': ' . $rowwx['textt'] . '"
									material="src: #canvax-'.$rowwx['id'].'"
									geometry="primitive: box"
									position="9.9 2.6 '.$firstPositx.'"
									rotation="0 -180 0"
									scale="0.005 0.92 0.7"
									showtext
									zoom-on-click2
									>
									
										
											<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="-0.84 0 0" rotation="0 -90 0" scale="1.035 1.035 1.035">
									 </a-entity>
										<a-entity id="msg-' . $rowwx['id'] . '" geometry="primitive: plane; height: 0.22; width: auto" material="src: #merme; opacity: 0.7; side: double" style="z-index: 10" 
												  visible="false" rotation="0 90 0" position="40 -0.67 0" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.85; letterSpacing: 4; lineHeight: 61" >
									   </a-entity>
								  </a-entity> ' ;
								  $firstPositx+= 1.1;
							}
							else 
							{
								echo '<a-entity 
									description="' . $rowwx['usernamee'] . ': ' . $rowwx['textt'] . '"
									material="src: #canvax-'.$rowwx['id'].'"
									geometry="primitive: box"
									position="9.9 1.3 '.$newPositx.'"
									rotation="0 -180 0"
									scale="0.005 0.92 0.7"
									showtext
									zoom-on-click2>
											<a-entity geometry="primitive: plane" material="color: black; side: double; opacity: 0.78" position="-0.84 0 0" rotation="0 -90 0" scale="1.035 1.035 1.035">
									 </a-entity>
										<a-entity id="msg-' . $rowwx['id'] . '" geometry="primitive: plane; height: 0.22; width: auto" material="src: #merme; opacity: 0.7; side: double" style="z-index: 10" 
												  visible="false" rotation="0 90 0" position="40 -0.67 0" scale="2.4 1.7 30" text=" ; align: center; color: black; wrapCount: 63; width: 0.85; letterSpacing: 4; lineHeight: 61" >
									   </a-entity>
								  </a-entity> ' ;
								$newPositx+= 1.1;
							}
						} 
			?>
			
			
			<a-sky material="src: #skr" color="#ECECEC"></a-sky>
            </a-scene>

	

			<script>
  // Check if the positionChangeFlag is set to true for each form
  var positionChangeFlag = "<?php echo isset($_GET['positionChange']) ? $_GET['positionChange'] : 'false'; ?>";
  var positionChangeFlagz = "<?php echo isset($_GET['positionChange2']) ? $_GET['positionChange2'] : 'false'; ?>";
  var positionChangeFlagx = "<?php echo isset($_GET['positionChange3']) ? $_GET['positionChange3'] : 'false'; ?>";

  // Function to play sound effect with a delay
  function playSoundWithDelay(volume) {
    var audio = document.getElementById('success');
	audio.volume = volume;
    audio.play();
  }

  // Check if the flag is 'true' and play the sound effect and set positions with a delay
  if (positionChangeFlag === 'true') {
  setTimeout(function() {
    playSoundWithDelay(0.5); // Play the sound effect after a 5000ms (5 seconds) delay with 50% volume
    // Set the position for the first form here
  }, 5000);
}

  if (positionChangeFlagz === 'true') {
  setTimeout(function() {
    playSoundWithDelay(0.3); // Play the sound effect after a 5000ms (5 seconds) delay with 30% volume
    // Set the position for the second form here
  }, 5000);
}


  if (positionChangeFlagx === 'true') {
  setTimeout(function() {
    playSoundWithDelay(0.7); // Play the sound effect after a 5000ms (5 seconds) delay with 70% volume
    // Set the position for the third form here
  }, 5000);
}
</script>
			  
  
             
</body>
</html>
