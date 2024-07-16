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
    public function generateUuid(): string {
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
     * @return object|null The entity object or null if not found.
     */
    abstract public static function getById(int $id): ?object;

    /**
     * This method should take an associative array and return an object of its class.
     * Example: When reading data from the database as an associative array and we need objects.
     *
     * @param array $data
     * @return object|null The entity object created from the associative array, or null if data is invalid.
     */
    abstract public static function assocToObject(array $data): ?object;

    /**
     * Method returns all entities.
     *
     * @return object[] An array of all entity objects.
     */
    abstract public static function getAll(): array;

    /**
     * This method deletes entity from database.
     *
     * @return bool True if the entity was successfully deleted, false otherwise.
     */
    abstract public function delete(): bool;

    /**
     * This method creates an entity in the database.
     *
     * @return bool True if the entity was successfully created, false otherwise.
     */
    abstract public function create(): bool;


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
    public function getUuid(): string {
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