<?php
	// Initialize the session
	session_start();
 
	// Check if the user is logged in, if not then redirect him to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	    header("location: login.php");
	    exit;
	}

	include 'header.php';
	
?>

<body>
	<div class="wrapper">
	    <!-- Sidebar  -->
	    <?php include 'sidebar.php'; ?>

	    <!-- Page Content  -->
	    <div id="content-wrapper">

	    	<?php include 'top-nav.php'; ?>

			<div class="chat-container">
				
				<div class="row" style="height:100%">
					
					<div class="col-sm-9">

						<div class="chatbox chat_history" data-tochannelid="<?php echo $_SESSION['currentChannel']; ?>" id="chat_history_<?php echo $_SESSION['currentChannel']; ?>"></div>
					
						
						<form class="inputForm">
							<div class="input-group mb-3">
								<textarea style="resize: none;" name="chat_message_<?php echo $_SESSION['currentChannel']; ?>" id="chat_message_<?php echo $_SESSION['currentChannel']; ?>" class="form-control"></textarea>
								<div class="input-group-append">
									<button class="btn btn-primary send_chat" name="send_chat" data-tochannelid="<?php echo $_SESSION['currentChannel']; ?>" type="button" id="button-addon2" >Submit</button>
								</div>
							</div>
						</form>

					</div>
					<div class="col-sm-3">
						
						<div class="docs-container">
							
							<div class="user-info">
								<div class="profile-pic">
									<i id="dashbaord-user-icon" class="<?php echo $_SESSION["user_icon"]; ?> fa-5x"></i>
								</div>
								<h4><?php echo htmlspecialchars($_SESSION["username"]); ?></h4>
								<p>Waterloo, ON</p>
								<div class="socials">
									<div class="facebook">
										<a href="#"><i class="fab fa-facebook-square fa-2x"></i></a>
									</div>
									<div class="twitter">
										<a href="#"><i class="fab fa-twitter-square fa-2x"></i></a>
									</div>
									<div class="email">
										<a href="#"><i class="fas fa-envelope-square fa-2x"></i></a>
									</div>
								</div>
							</div>

							<div class="doc-list list-group">
								<h5>Channel Documents: </h5>
								<a href="#" class="list-group-item list-group-item-action">
								Cras justo odio
								</a>
								<a href="#" class="list-group-item list-group-item-action">Dapibus ac facilisis in</a>
								<a href="#" class="list-group-item list-group-item-action">Morbi leo risus</a>
								<a href="#" class="list-group-item list-group-item-action">Porta ac consectetur ac</a>
								<a href="#" class="list-group-item list-group-item-action" tabindex="-1" aria-disabled="true">Vestibulum at eros</a>
							</div>

						</div>

					</div>

				</div>
				

			</div>



	        
	    </div>
	</div>

	<?php include 'footer.php'; ?>

	</body>
</html>