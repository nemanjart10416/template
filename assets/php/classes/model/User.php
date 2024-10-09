<?php

/**
 *
 */
class User extends UserModel
{

    /**
     * @param array $data
     * @return null
     */
    public static function assocToObject(array $data): ?object
    {
        // TODO: Implement assocToObject() method.
        return null;
    }

    /**
     * @return bool
     */
    public function create(): bool
    {
        // TODO: Implement create() method.
        return false;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        // TODO: Implement update() method.
        return false;
    }

    /**
     * Authenticates a user based on the provided credentials.
     *
     * @param string $email The email of the user to authenticate.
     * @param string $password The password of the user to authenticate.
     *
     * @return bool|null Returns true if authentication is successful; otherwise, returns null.
     */
    public static function authenticateUser(string $email, string $password): bool|null
    {
        // Get user data from the database based on the provided username
        $sql = "SELECT * FROM user_u WHERE u_email = ?";
        $params = [$email];
        $result = Connection::getP($sql, $params);

        // Check if the user with the given username exists
        if ($result && $result->num_rows > 0) {
            $userData = $result->fetch_assoc();

            // Verify the password hash
            if (password_verify($password, $userData['u_password'])) {
                // Authentication successful, create session and return true
                self::handleLogin(self::assocToObject($userData));
            }else{
                return false;
            }
        }else{
            return false;
        }

        // Authentication failed, return false
        return false;
    }
}