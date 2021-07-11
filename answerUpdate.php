<?php
session_start();
include 'include/db.connect.php';
include 'include/Validation.php';

//Reteriving the data for answer
$ans_id=$_SESSION['answer_id'];

	$getTheAnswer=new Users();
	$answer=$getTheAnswer->getTheData("select `answer` from `answer` where `ans_id`='$ans_id'");
	foreach($answer as $answer){
		$editAns=$answer['answer'];
	}
	
$questionId=$_SESSION['question_id'];

//Getting all the value from the questions table
$questionsTable=new Users();
$questionRecords=$questionsTable->getTheData("SELECT * from questions where ques_id=$questionId");

foreach($questionRecords as $ques){
 $qUserName=$ques["userName"];
 $qQuestion=$ques["question"];
}
$answerUserName= $_SESSION["userName"];

//Saving the data
if (($_SERVER["REQUEST_METHOD"] == "POST")) {
 $text=$_POST['answerText'];

//Getting all things done
//$fileName=$_FILES[$file]['name'];
	

//Escaping from the special characters
$us=new realEscape;
$atext=$us->realString($text);
$validation=new AnswerEditor($_POST);
$errors=$validation->validateForm();

 if($errors==NULL){
	$answer=new InsertData();
 	$answerInsert=$answer->query("UPDATE `answer` SET `answer` = '$text' WHERE `answer`.`ans_id` = $ans_id;");
	$_SESSION['ques_id']=$questionId;
	 header("location:answer.php");
 	}
}
?>



<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
		crossorigin="anonymous">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
		integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
		crossorigin="anonymous" />
	<link rel="stylesheet" href="css/navbar.css">
	<link rel="stylesheet" href="css/answer.editor.css">
	<script src="script/answer.editor.js"></script>

</head>

<body onload="myFunction()">
	<?php include 'partials/navbar.php'?>

	<!-- Optional JavaScript; choose one of the two! -->

	<!-- Option 1: Bootstrap Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
		crossorigin="anonymous"></script>

	<!-- Option 2: Separate Popper and Bootstrap JS -->
	<!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
	<section class="editor-head">
		<h1 class="shadow-sm"><span style="color:#cFF8585"><?php echo $qQuestion;?></span><span
				style="color:black"> Asked by</span> <span
				style="color: #669999"><?php echo $qUserName;?></span></h1>
		<div class="flex-box">
			<div class="row">
				<div class="col">
					<!-- Adding different buttons for
						different functionality-->
					<!--onclick attribute is added to give
						button a work to do when it is clicked-->
					<button type="button" onclick="f1()"
						class=" shadow-sm qbtn btn btn-outline-secondary" data-toggle="tooltip"
						data-placement="top" title="Bold Text">
						Bold</button>
					<button type="button" onclick="f2()"
						class="shadow-sm qbtn btn btn-outline-success" data-toggle="tooltip"
						data-placement="top" title="Italic Text">
						Italic</button>
					<button type="button" onclick="f3()"
						class=" shadow-sm btn qbtn btn-outline-primary" data-toggle="tooltip"
						data-placement="top" title="Left Align">
						<i class="fas fa-align-left"></i></button>
					<button type="button" onclick="f4()"
						class="btn shadow-sm  qbtn btn-outline-secondary" data-toggle="tooltip"
						data-placement="top" title="Center Align">
						<i class="fas fa-align-center"></i></button>
					<button type="button" onclick="f5()"
						class="btn shadow-sm qbtn btn-outline-primary" data-toggle="tooltip"
						data-placement="top" title="Right Align">
						<i class="fas fa-align-right"></i></button>
					<button type="button" onclick="f6()"
						class="btn shadow-sm qbtn btn-outline-secondary" data-toggle="tooltip"
						data-placement="top" title="Uppercase Text">
						Upper Case</button>
					<button type="button" onclick="f7()"
						class="btn shadow-sm qbtn btn-outline-primary" data-toggle="tooltip"
						data-placement="top" title="Lowercase Text">
						Lower Case</button>
					<button type="button" onclick="f8()"
						class="btn shadow-sm qbtn btn-outline-primary" data-toggle="tooltip"
						data-placement="top" title="Capitalize Text">
						Capitalize</button>
					<button type="button" onclick="f9()"
						class="btn shadow-sm btn-outline-primary qbtn side"
						data-toggle="tooltip" data-placement="top" title="Tooltip on top">
						Clear Text</button>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-3 col-sm-3">
			</div>
			<div class="col-md-6 col-sm-9">
				<h4 class="text-center ">Write your answer here. Limit 1800 characters</h4>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<div class=" flex-box">
						<textarea id="textarea1" class="input shadow" name="answerText"
							rows="15" cols="100" placeholder="Your text here "><?php echo $editAns; ?>
					</textarea>

					</div>
					<div class="error my-2 text-center">
						<?php echo $errors['answerText'] ?? ''; ?>
					</div>
					<div class="image show my-4" style="margin-left:auto; margin-right:auto;">
						<img src="img/python.jpg"  height=200 width=200 alt="img/userdefault.jpg">
						<button type="submit" class="btn btn-danger">remove</button>
					</div>
					<div class="form-group " style="display: none; margin-left:auto !important; margin-right:auto !important;">
						<div class="image-upload my-4 text-center">
							<label class="form-label" for="customFile">Upload Image</label>
							<input type="file" class="form-control" name="uploadfile"
								accept="image/x-png,image/gif,image/jpeg"
								id="customFile" />

						</div>
					</div>
					<div class="error my-2 text-center">
						<?php echo $errors['fileExt'] ?? ''; ?>
					</div>
					<div class="error my-2 text-center">
						<?php echo $errors['fileSize'] ?? ''; ?>
					</div>
					<div class="d-flex justify-content-around">
					<button class="btn sub-btn btn-success my-4 " type="submit">update</button>
				<a href="questionAns.php"<button class="btn sub-btn btn-danger my-4 " type="button">cancel</button></a>
					</div>
				</form>
			</div>
		</div>

	</section>
	<br>
	<br>

</body>

</html>