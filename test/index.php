<!DOCTYPE html>
<html>
<head>
	<title>mymemory | Task List Dev</title>

	 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	
	<style type="text/css">
		#container {
			width: 700px;
			margin: 15px auto;
			outline: 1px dashed red;
			background: #EFEFFF;
			padding: 10px;
		}

		span, input {
			transition: all 0.2s ease 0s;
  			-moz-transition: all 0.2s ease 0s;
  			-webkit-transition: all 0.2s ease 0s;
		}
		
		::-webkit-scrollbar {
			width: 14px;
			height: 14px;
		}
		
		::-webkit-scrollbar-button:vertical:start:increment,
		::-webkit-scrollbar-button:vertical:end:decrement {
			display: none;
		}
 
		::-webkit-scrollbar-track {
			-webkit-box-shadow: inset 0 0 12px rgba(0,0,0,0.3); 
			background: rgba(0,0,0,0.5);
		}
		 
		::-webkit-scrollbar-thumb {
			border-radius: 4px;
			-webkit-box-shadow: inset 1px 1px 12px rgba(0,0,0,0.8);
			background: rgba(0,128,0,0.5);
			
		}
		
		::-webkit-scrollbar-thumb:hover {
			background: rgba(0,128,0,0.8);
		}
		
		#taskForm, #outputBox, #taskContainer {
			width: 640px;
			padding: 4px;
			position: relative;
			margin: 5px auto;
			background: #444444;
			color: #FFFFFF;
			font-family: "Lucida Console", Monaco, monospace;
			border: 1px solid #CCCCCC;
			-webkit-box-shadow: 2px 2px 4px 0px rgba(0,0,0,0.75);
			-moz-box-shadow: 2px 2px 4px 0px rgba(0,0,0,0.75);
			box-shadow: 2px 2px 4px 0px rgba(0,0,0,0.75);
		}
		
		#outputBox {
			background: #000000;
			overflow: scroll;
			height: 320px;
		}

		#taskTitle {
			width: 75%;
			max-width: 75%;
			resize-x: none;
			font-family: inherit;
		}
		
		.taskButton {
			font-family: inherit;
  			border: 0 none;
  			border-radius: 3px 3px 3px 3px;
  			color: #CCCCCC;
  			background: #000000;
			display: block;

  			line-height: 20px;
			margin: 0 4px 4px auto;
  			padding: 2px 10px;
  			text-transform: none;

  			border: 1px solid #808080;
  		}
  		.taskButton:hover {
			background: none repeat scroll 0 0 #808080;
			color: #FFFFFF;
			border: 1px solid #000000;
			cursor: pointer;
		}
		
		.taskItemSrc { display: block; font-size: 11px; white-space: nowrap; }
		.indented { padding-left: 25px; }
	</style>

	<script type="text/javascript">
	var timerVal = 0;
	var timerInterval;
	var taskId = 0;
		
		$(function() {
			$(window).bind("beforeunload", function() { 
			    //return confirm("Do you really want to close? All data will be lost!"); 
			});
			
			init();
			
			$("#taskCreate").click(function() {
				addTask();
			});
			
		});
		
		function init() {
			resetTaskTimer();
			var newDatetime = $.now();
			
			$("<span/>", {
				text: "{\"tasks" + newDatetime + "\": [",
				class: "taskItemSrc"
			}).insertBefore("#jsonEnd");
			
			
		}
		
		function addTask(taskTitle) {
			if (taskTitle == undefined || taskTitle == "") {
				taskTitle = $("#taskTitle").val();
			}
			
			if (taskTitle == undefined || taskTitle == "") { return; }
			
			$("#taskTitle").val("");
			
			var taskCreated = $.now();
			
			// todo: create a json object, instead of txt string
			var taskJson = {
							id: taskId++,
							name: taskTitle,
							created: taskCreated 								
						};
			// todo: send taskJson to ajax page to save entry
			createTaskRequest(taskJson);
			
			$("<span/>", {
				text: JSON.stringify(taskJson) + ",",
				class: "taskItemSrc indented"
			}).insertBefore("#jsonEnd");
			
			addTaskListEntry(taskJson);
			
			resetTaskTimer();
			startTaskTimer();
		}
		
		function addTaskListEntry(taskJson) {
			$("<p/>", {
				class: "taskListItem",
				id: taskJson.id
			}).prependTo("#taskList");

			//$(".taskListItem#" + taskJson.id).
			
			$(".taskListItem#" + taskJson.id).text(taskJson.name);
		}
		
		function startTaskTimer() {
			timerInterval = setInterval(function() {
				timerVal++;
				displayTaskTimer();
			}, 1000);
		}
		
		function displayTaskTimer() {
			timerVal = Math.round(timerVal);
		    
			var seconds = Math.floor(timerVal);
			var hours = Math.floor(seconds / 3600);
			seconds -= hours * 3600;
			var minutes = Math.floor(seconds / 60);
			seconds -= minutes * 60;

			if (hours   < 10) {hours   = "0" + hours; }
			if (minutes < 10) {minutes = "0" + minutes; }
			if (seconds < 10) {seconds = "0" + seconds; }
			
			$("#taskTimeCounter").text(hours + ":" + minutes + ":" + seconds);
		}
		
		function getTimerVal() {
			
			
			return timerVal;
		}
		
		function resetTaskTimer() {
			clearInterval(timerInterval);
			timerVal = 0;
		}
		
		function createTaskRequest(taskJson) {
			$.post("task/create.php", taskJson, 
				function (data, status) {
					console.log(status + ': ' + data);
				}
			);
		}
	</script>

</head>
<body>
<div id="container">
	<span>Create a new task:</span>
	<div id="taskForm">
		<input type="text" id="taskTitle" placeholder="Task Title" />
						
		<div id="submitContainer">
			<input type="button" class="taskButton" id="taskCreate" value="Create Task" />
		</div>
	</div>
	
	<div id="taskContainer">
		<div id="curTaskTimer">
			<span style="font-weight: bold; color: #CCCCFF;">Time on Current Task: </span>
			<span id="taskTimeCounter">00:00:00</span>
			<hr />
		</div>
		<div id="taskList">
			
		</div>
	</div>
	
	<div id="outputBox">
		
		<span class="taskItemSrc" id="jsonEnd">]}</span>
	</div>
</div>
</body>
</html>
