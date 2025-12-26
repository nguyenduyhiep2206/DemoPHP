<?php

class Password
{
    var $itoa64;
    var $iteration_count_log2;
    var $portable_hashes;
    var $random_state;

    /**
     * Constructor
     * @param int $iteration_count_log2
     * @param bool $portable_hashes
     */
    public function __construct($iteration_count_log2 = 8, $portable_hashes = false)
    {
        $this->itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $this->iteration_count_log2 = $iteration_count_log2;
        $this->portable_hashes = $portable_hashes;
        $this->random_state = microtime() . uniqid();
    }

    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function checkPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}

function getUsers()
{
    if (!isset($_SESSION['users'])) {
        $_SESSION['users'] = [];
    }
    return $_SESSION['users'];
}

function saveUsers($users)
{
    $_SESSION['users'] = $users;
}

function findUserByEmail($email)
{
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return $user;
        }
    }
    return null;
}

function registerUser($name, $email, $password)
{
    if (findUserByEmail($email)) {
        return ['success' => false, 'error' => 'Email already exists'];
    }

    $passwordHelper = new Password();
    $hashedPassword = $passwordHelper->hashPassword($password);

    $newUser = [
        'id' => uniqid(),
        'name' => $name,
        'email' => $email,
        'password' => $hashedPassword,
        'created_at' => date('Y-m-d H:i:s')
    ];

    $users = getUsers();
    $users[] = $newUser;
    saveUsers($users);

    return ['success' => true, 'user' => $newUser];
}

function loginUser($email, $password)
{
    $user = findUserByEmail($email);
    
    if (!$user) {
        return ['success' => false, 'error' => 'Email not found'];
    }

    $passwordHelper = new Password();
    if (!$passwordHelper->checkPassword($password, $user['password'])) {
        return ['success' => false, 'error' => 'Incorrect password'];
    }

    unset($user['password']);
    
    return ['success' => true, 'user' => $user];
}

function isLoggedIn()
{
    return isset($_SESSION['user']);
}

function getCurrentUser()
{
    return $_SESSION['user'] ?? null;
}

function logoutUser()
{
    unset($_SESSION['user']);
    session_destroy();
}
