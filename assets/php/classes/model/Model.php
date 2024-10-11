<?php

/**
 * Abstract class representing a generic model.
 */
abstract class Model
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var string
     */
    private string $uuid;

    /**
     * @var string|null
     */
    private ?string $createdAt;

    /**
     * Retrieves the name of the database table associated with the implementing class.
     *
     * @return string The name of the database table.
     */
    abstract static protected function getTableName(): string;

    /**
     * Retrieves the prefix used for the columns in the database table associated with the implementing class.
     *
     * @return string The column prefix.
     */
    abstract static protected function getTablePrefix(): string;

    /**
     * Retrieves the name of the primary key column in the database table associated with the implementing class.
     *
     * @return string The name of the primary key column.
     */
    abstract static protected function getPrimaryKey(): string;

    /**
     * Constructor to initialize the UUID and ID.
     *
     * @param int|null $id
     * @param string|null $uuid
     * @throws \Random\RandomException
     */
    public function __construct(?int $id = null, ?string $uuid = null, ?string $createdAt = null)
    {
        if ($id === null && $uuid === null) {
            $this->uuid = $this->generateUuid();
        } else {
            $this->id = $id;
            $this->uuid = $uuid;
            $this->createdAt = $createdAt;
        }
    }


    /**
     * Generate a UUID for the entity if it's not already set.
     *
     * @return string
     * @throws \Random\RandomException If UUID generation fails.
     */
    public function generateUuid(): string
    {
        try {
            // Generate a random string
            $randomString = bin2hex(random_bytes(16));

            // Get the current time in microseconds
            $time = microtime(true);

            // Concatenate time and random string
            $rawUuid = $time . $randomString;

            // Hash the raw UUID to ensure uniqueness and to shorten it
            $hashedUuid = hash('sha256', $rawUuid);

            // Optionally, encode the hash to make it URL-safe and trim it to a reasonable length
            $uuid = substr(base64_encode(hex2bin($hashedUuid)), 0, 22);

            // Remove URL-unsafe characters
            return $uuid = str_replace(['+', '/', '='], '', $uuid);
        } catch (\Exception $e) {
            throw new \Random\RandomException("Failed to generate UUID: " . $e->getMessage());
        }
    }

    /**
     * Method returns entity by its id.
     *
     * @param int $id
     * @return static|null
     */
    public static function getById(int $id): ?object
    {
        $result = Connection::getP("SELECT * FROM " . static::getTableName() . " where " . static::getPrimaryKey() . " = ?", [$id]);

        if ($result && $result->num_rows > 0) {
            $country = $result->fetch_assoc();
            return static::assocToObject($country);
        }

        return null;
    }

    /**
     * Retrieves all records from the corresponding database table and returns them as an array of objects.
     *
     * This method uses a static call to get the table name and fetches all records,
     * converting each row of data into an object of the class that calls this method.
     *
     * @return array|static[] An array of objects representing all records from the table.
     */
    public static function getAll(): array
    {
        $result = Connection::get("SELECT * FROM " . static::getTableName());

        $objects = [];

        while ($data = $result->fetch_assoc()) {
            $objects [] = static::assocToObject($data);
        }

        return $objects;
    }

    /**
     * Deletes the current object from the database.
     *
     * This method constructs and executes a SQL DELETE statement using the primary key
     * of the current object to identify the record to be deleted. It returns a boolean
     * indicating whether the deletion was successful.
     *
     * @return bool True if the record was successfully deleted, false otherwise.
     */
    public function delete(): bool
    {
        return Connection::setP("DELETE FROM " . static::getTableName() . " WHERE " . static::getPrimaryKey() . " = ?", [$this->getId()]);
    }

    /**
     * Saves the current object to the database.
     *
     * This method updates the record in the database corresponding to the current object.
     * It uses reflection to access the object's properties and constructs an SQL UPDATE statement.
     * The 'id' property must be set for the update to proceed. If the 'id' is null, an exception is thrown.
     *
     * @throws \InvalidArgumentException if the 'id' property is not set.
     * @return bool True if the record was successfully updated, false otherwise.
     */
    public function save(): bool
    {
        if ($this->getId() === null) {
            throw new \InvalidArgumentException("The 'id' property must be set for updates.");
        }

        $properties = [];
        $params = [];

        // Use reflection to get the properties
        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true); // Allow access to private properties
            $value = $property->getValue($this);
            if ($property->getName() !== 'id') { // Skip the id property for update
                $properties[] = static::getTablePrefix() . "_" . $property->getName() . " = ?";
                $params[] = $value;
            }
        }

        // Prepare the SQL query
        $sql = "UPDATE " . static::getTableName() . " SET " . implode(', ', $properties) . " WHERE " . static::getPrimaryKey() . " = ?";
        $params[] = $this->getId(); // Add the ID to the parameters

        return Connection::setP($sql, $params); // Execute the query
    }

    /**
     * Inserts a new record into the database based on the current object's properties.
     *
     * This method constructs an SQL INSERT statement using reflection to access the object's
     * properties. The 'id' and 'createdAt' properties are skipped, as they are managed by the
     * database. If the insert operation is successful, it returns true; otherwise, it returns false.
     *
     * @return bool True if the record was successfully inserted, false otherwise.
     */
    public function insert(): bool
    {
        // Prepare properties and parameters for the INSERT statement
        $properties = [];
        $params = [];
        $columns = [];

        // Use reflection to get the properties
        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getProperties() as $property) {
            // Check if the property is public
            $property->setAccessible(true); // Allow access to private properties
            $value = $property->getValue($this);
            if ($property->getName() !== 'id' && $property->getName() !== 'createdAt') { // Skip id and createdAt
                $columns[] = static::getTablePrefix() . "_" . $property->getName();
                $properties[] = "?"; // Placeholder for the value
                $params[] = $value; // Add the value to params
            }
        }

        // Prepare the SQL query
        $sql = "INSERT INTO " . static::getTableName() . " (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $properties) . ")";

        return Connection::setP($sql, $params); // Execute the query
    }

    /**
     * This method should take an associative array and return an object of its class.
     * Example: When reading data from the database as an associative array and we need objects.
     *
     * @param array $data
     * @return static|null The entity object created from the associative array, or null if data is invalid.
     */
    abstract public static function assocToObject(array $data): ?object;


    /**
     * This function updates entity in the database.
     *
     * @return bool True if the entity was successfully updated, false otherwise.
     */
    abstract public function update(): bool;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return void
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return void
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param string|null $createdAt
     * @return void
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}