<?php

$possible_langs = array (
	'English'
	, 'Français'
	, 'Español'
);

$possible_priorities = array(
	'low' => 'Low Priority'
	, 'norm' => 'Normal Priority'
	, 'high' => 'High Priority'
);

$errors = array();
$display_thanks = false;

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL); 
$notes = filter_input(INPUT_POST,'notes', FILTER_SANITIZE_STRING);

$password = filter_input(INPUT_POST,'password', FILTER_SANITIZE_STRING);

$acceptterms = filter_input(INPUT_POST, 'acceptterms', FILTER_DEFAULT);

$lang = filter_input(INPUT_POST, 'language', FILTER_SANITIZE_STRING);
$priority = filter_input(INPUT_POST, 'priority', FILTER_SANITIZE_STRING);



if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
	if (empty($name)) {
		$errors['name'] = true;
	}
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = true;
	}
	
	if (mb_strlen($notes) < 25) { 
		$errors['notes'] = true;
	}
	
	
	if (empty($password)) {
		$errors['password'] = true;
	}
	if (mb_strlen($username) > 25) {
		$errors['username'] = true;
	}
	
	
	
	if (!in_array($lang, $possible_langs)) {
		$error['language'] = true;
	}
	
	if (!array_key_exists($lang, $possible_langs)) {
		$error['language'] = true;
	}
	
	/*if (!isset($_POST['terms'])) {
		$errors['terms'] = true;
	}
	*/
	
	if (empty($acceptterms)) {
		$errors['terms'] = true;
	}
	
	if (empty($errors)) {
		$display_thanks = true;
		
		$email_message = 'Name: ' . $name . "\r\n"; //\r\n is a new line in an email, must be in double quotes
		$email_message .= 'Email: ' . $email . "\r\n";
		$email_message .= "Notes:\r\n" . $notes;
		
		$headers = 'From: Alis <alikellar@gmail.com>' . "\r\n";
		
		mail($email, 'Thanks for registering', $email_message, $headers);
		// mail($email)
	}
}

?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Fan Club Registration Form</title>
<link href="css/general.css" rel="stylesheet">

</head>

<body>

	<?php if ($display_thanks) : ?>
    	<strong>Thanks! Your soul now belongs to me.</strong>
    <?php else : ?>
	
    
        <h1>Join the Amazing Alis Kellar Fan Club of Awesomeness!</h1>
        
        <form method="post" action"index.php">
        
           <div>
                <label for="name">Name<?php if (isset($errors['name'])) : ?> <strong>You have a name, don't you?</strong><?php endif; ?></label>
                <input type="text" id="name" name="name" value "<?php echo $name; ?>" required>
           </div>
           
           <div>
                <label for="username">Username<?php if (isset($errors['username'])) : ?> <strong>25 character max</strong><?php endif; ?></label>
                <input type="text" id="username" name="username" value "<?php echo $username; ?>" required>
           </div>
          
          
           <div>
                <label for="email">E-mail Address<?php if (isset($errors['email'])) : ?> <strong>is required</strong><?php endif; ?></label>
                <input type="email" id="email" name="email" value="<?php echo $email;?>" required>
           </div>
           
           <div>
                <label for="password">Password<?php if (isset($errors['password'])) : ?> <strong>is required</strong><?php endif; ?></label>
                <input type="password" id="password" name="password" value="<?php echo $password;?>" required>
           </div>
           
           
           
            <div>
                <label for="notes">Notes<?php if (isset($errors['notes'])) : ?> <strong>must be at least 25 characters</strong><?php endif; ?></label>
                <textarea id=="notes" name="notes"required><?php echo $notes; ?></textarea>
            </div>
            
            
            
            <div>
                <fieldset>
                    <legend>What is your preferred language?</legend>
                    <?php if (isset($errors['language'])) : ?> <strong>please select a language</strong><?php endif; ?>
                <?php foreach ($possible_langs as $key => $value) : ?>
                    <input type="radio" id="<?php echo $key; ?>" name="language" value="<?php echo $key; ?>"<?php if ($key == $lang) { echo ' checked'; } ?>>
                    <label for="<?php echo $key; ?>"><?php echo $value; ?></label>
                <?php endforeach; ?>
                </fieldset>
            </div>
            
            <div>
                <input type="checkbox" id="acceptterms" name="acceptterms" <?php if (!empty($acceptterms)) { echo 'checked'; } ?>>
                <label for="acceptterms">Accept Terms!</label>
                <?php if (isset($errors['acceptterms'])) : ?> <strong>You must comply!</strong><?php endif; ?>
           </div>
            
            
            
            <div>
                <button type="submit">Submit to me!</button>
            </div>
         
         </form>
     <?php endif;?>
     
</body>
</html>
