<?php

abstract class UserModel extends Model
{
    /**
     * @var string
     */
    private string $username;

    /**
     * @var string
     */
    private string $email;

    /**
     * @var string
     */
    private string $password;

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @throws \Random\RandomException
     */
    public function __construct(string $username, string $email, string $password, ?int $id = null, ?string $uuid = null, ?string $createdAt = null)
    {
        parent::__construct($id, $uuid, $createdAt);
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    abstract public static function getById(int $id): ?object;

    abstract public static function assocToObject(array $data): ?object;

    abstract public static function getAll(): array;

    abstract public function delete(): bool;

    abstract public function create(): bool;

    abstract public function update(): bool;

    /**
     * Authenticates a user based on the provided credentials.
     *
     * @param string $email The email of the user to authenticate.
     * @param string $password The password of the user to authenticate.
     *
     * @return bool|null Returns true if authentication is successful; otherwise, returns null.
     */
    abstract public static function authenticateUser(string $email, string $password): bool|null;

    /**
     * Creates a session for the authenticated user and performs redirect based on user role.
     *
     * @param User $user The authenticated user object.
     *
     * @return void
     */
    #[NoReturn] public static function handleLogin(User $user): void {
        //additional checks if needed

        // Store user information in the session
        $_SESSION['user'] = serialize($user);

        // Perform redirect based on user role
        if ($user->getType() == "admin") {
            header("Location: admin/");
        }else if ($user->getType() == "user") {
            header("Location: user/");
        }else {
            Functions::logout();
            header("Location: login"); // Redirect to regular user homepage
        }

        // End script execution after the redirect
        exit();
    }

    /**
     * @return bool
     */
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION["user"]);
    }

    /**
     * @return int
     */
    public static function getLoggedInUserId(): int {
        $user = unserialize($_SESSION['user']);
        /**
         * @var User $user
         */
        return $user->getId();
    }

    /**
     * @param string $type
     * @return bool
     */
    public static function hasStatus(string $type): bool
    {
        if(!self::isLoggedIn()){
            return false;
        }

        $user = unserialize($_SESSION['user']);
        if($user instanceof User && $user->getType() === $type){
            return true;
        }

        return false;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }


}