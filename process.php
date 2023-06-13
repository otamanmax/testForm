<?php
function getUsers(){
    $users = [
        [
            'id' => '1',
            'name' => 'Max',
            'lastName' => 'Max',
            'email' => 'Max@Max.Max',
            'password' => 'Max123',
        ],[
            'id' => '2',
            'name' => 'Joe',
            'lastName' => 'Joe',
            'email' => 'Joe@Joe.Joe',
            'password' => 'Joe123',
        ],[
            'id' => '3',
            'name' => 'Mike',
            'lastName' => 'Mike',
            'email' => 'Mike@Mike.Mike',
            'password' => 'Mike123',
        ],
    ];

    if(!empty($_POST['newBase'])){
        $users = $_POST['newBase'];
    }

    return $users;
}


function validate($post){
    $errors = [];

    if (empty($post['name'])) {
        $errors['name'] = 'Name is required.';
    }

    if (empty($post['lastName'])) {
        $errors['email'] = 'Last Name is required.';
    }

    if (empty($post['email'])) {
        $errors['email'] = 'Email is required.';
    }

    if (str_contains($post['email'], '@') !== true) {
        $errors['email'] = 'Email is wrong.';
    }

    if (empty($post['password'])) {
        $errors['password'] = 'Password alias is required.';
    }
    if (empty($post['passwordConfirm'])) {
        $errors['passwordConfirm'] = 'Password confirm alias is required.';
    }
    if($post['password'] !== $post['passwordConfirm']){
        $errors['passwordConfirm'] = 'Password confirm is wrong.';
    }

    $userByEmail = array_filter(getUsers(), function($user){
        return $user["email"] === $_POST['email'];
    });

    if(!empty($userByEmail)){
        $errors['email'] = 'Email is used.';
    }

    return $errors;
}

function getMessage($errors){
    $data = [];

    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {
        $data['success'] = true;
        $data['message'] = 'Success!';
    }

    return $data;
}

function addNewUser($users,$data){
    if($data['success']){
        $user = [
          'name'     =>$_POST['name'],
          'lastName' =>$_POST['lastName'],
          'email'    =>$_POST['email'],
          'password' =>$_POST['password'],
        ];
        array_push($users,$user);
    }

    return $users;
}

function loging($data,$post){
    $log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
        "Attempt: ".($data['success']=='1'?'Success':'Failed').PHP_EOL.
        "Name: ".$post['name'].PHP_EOL.
        "LastName: ".$post['lastName'].PHP_EOL.
        "Email: ".$post['email'].PHP_EOL.
        ($data['success']=='1' ? '' : 'Error:'.implode(",",$data['errors'])).PHP_EOL.
        "-------------------------".PHP_EOL;

    file_put_contents('./log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
}

$errors = validate($_POST);
$data   = getMessage($errors);
loging($data,$_POST);
if($data['success']){
    $data['newBase'] = addNewUser(getUsers(),$data);
}
echo json_encode($data);