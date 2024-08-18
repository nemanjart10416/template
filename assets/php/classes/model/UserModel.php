<?php

/**
 *
 */
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

    /**
     * @param int $id
     * @return object|User|null
     */
    public static function getById(int $id): ?object
    {
        $sql = "SELECT * FROM users_u where u_id = ?";
        $params = [$id];
        $result = Connection::getP($sql, $params);

        if ($result && $result->num_rows > 0) {
            $userData = $result->fetch_assoc();
            return User::assocToObject($userData);
        }

        return null;
    }

    /**
     * This method needs to be overridden in subclasses to convert
     * associative array $data into an object of the appropriate type.
     *
     * @param array $data
     * @return object|null
     */
    public static function assocToObject(array $data): ?object {
        return null; // Default implementation, to be overridden in subclasses
    }

    /**
     * @return array|object[]
     */
    public static function getAll(): array
    {
        $usersData = Connection::get("SELECT * FROM users_u");

        $users = [];

        while ($userData = $usersData->fetch_assoc()){
            $users []= self::assocToObject($userData);
        }

        return $users;
    }

    /**
     * Checks if given email is unique
     *
     * @param string $email email to check
     * @return bool True if email not taken
     */
    public static function emailUnique(string $email): bool {
        $sql = "SELECT COUNT(*) AS count FROM user_u WHERE u_email = ?";
        $params = [$email];
        $result = Connection::getP($sql, $params);

        if ($result && $row = $result->fetch_assoc()) {
            return !(intval($row['count']) > 0);
        }

        return true;
    }

    /**
     * Checks if given email is unique
     *
     * @param string $email email to check
     * @return bool True if email not taken
     */
    public static function usernameUnique(string $email): bool {
        $sql = "SELECT COUNT(*) AS count FROM user_u WHERE u_username = ?";
        $params = [$email];
        $result = Connection::getP($sql, $params);

        if ($result && $row = $result->fetch_assoc()) {
            return !(intval($row['count']) > 0);
        }

        return true;
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $sql = "DELETE FROM users_u where u_id = ?";
        $params = [$this->getId()];

        return Connection::setP($sql, $params);
    }

    /**
     * @return bool
     */
    abstract public function create(): bool;

    /**
     * @return bool
     */
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

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return void
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return void
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }


}