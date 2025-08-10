<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.7/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.7.8/plyr.min.css" />

	<link rel="stylesheet" href="./assets/css/main.css?v=<?php echo time(); ?>" />
	<link rel="stylesheet" href="./assets/css/mobile.css?v=<?php echo time(); ?>" />
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="lib/css/emoji.css" rel="stylesheet">
	<title>היי מה נשמע?</title>
</head>

<body>

	<div id="main" class="main-container row">
		<div id="chats_list" class="left-container col-md-4">
			<!--header -->
			<div class="header row">
				<div class="col-12 row">
					<div class="user_avatar_container col-2">
						<img src="./profile_pics/assaf.jpg" alt="User's Avatar" />
					</div>
					<div class="user_info_container col-6">
						<div class="user_full_name_comes_here">Assaf Levy</div>
						<div class="user_status_comes_here hide_on_mobile">Online</div>
					</div>
					<div class="logout_btn_container col-4">
						<button class="logout btn btn-dark">Logout</button>
					</div>
				</div>
			</div>
			<!--search-container -->
			<div class="search-container">
				<div class="input">
					<i class="fa-solid fa-magnifying-glass"></i>
					<input type="text" placeholder="Search or start new chat   " />
				</div>
				<i class="fa-sharp fa-solid fa-bars-filter"></i>
			</div>
			<!--chats -->
			<div id="chats" class="chat-list"></div>
		</div>

		<div id="chat_window" class="right-container col-md-8">
			<!--header -->
			<div class="header row">

				<div class="row col-10">
					<div class="show_chats_list col-2">
						<i class="fa-solid fa-chevron-left"></i>
					</div>

					<div class="contact_profile_img col-3">
						<img class="dp" src="" alt="" />
					</div>

					<div class="contact_name_container col-7">
						<span class="contact_name"></span>
						<span class="contact_id"></span>
					</div>
				</div>

				<div class="contact_more_options col-2">
					<ul class="row">
						<li class="col-6 show_more_option_menu">
							<i class="fa-solid fa-ellipsis-vertical"></i>
						</li>
					</ul>
				</div>

			</div>
			<!--chat-container -->
			<div id="msgs" class="chat-container"></div>
			<!--input-bottom -->
			<form id="send_msg" class="send_msg_form chatbox-input" enctype="multipart/form-data">
				<i id="file_trigger" class="fa-sharp fa-solid fa-paperclip" style="cursor: pointer;"></i>
				<!-- The hidden file input -->
				<input type="file" id="image_input" accept="image/*" style="display:none" />

				<input id="msg" type="text" placeholder="Type a message" required />
				<!-- Emoji button -->
				<button type="button" id="emoji-btn" class="btn btn-light" aria-label="Emoji picker" style="font-size: 1.5rem;">
					😊
				</button>

				<emoji-picker id="emoji-picker" style="position: absolute; display:none; right: 0; bottom: 80%;"></emoji-picker>
				
				<button class="submit_msg">
					<i class="fa-solid fa-paper-plane"></i>
				</button>

				  <!-- Container for image preview -->
				<div id="image_preview_container" style="margin-top: 10px;"></div>
			</form>
			<!-- <div class="emoji-picker-container" style="width: fit-content;" data-emoji-input="unicode"></div> -->
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.7.8/plyr.min.js"></script>
	<!-- ** Don't forget to Add jQuery here ** -->
	<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>

	<!-- <script src="./assets/js/config.min.js"></script>
	<script src="./assets/js/util.min.js"></script>
	<script src="./assets/js/jquery.emojiarea.min.js"></script>
	<script src="./assets/js/emoji-picker.min.js"></script> -->
	<script src="./assets/js/emojiScript.js"></script>
	<script src="./assets/js/main.js?v=<?php echo time(); ?>"></script>

</body>

</html>