<?php

/**
 * Abstract class representing a generic model.
 */
abstract class Model
{

    /**
     * Method returns entity by its id.
     *
     * @param int $id
     * @return object|null The entity object or null if not found.
     */
    abstract public function getById(int $id): ?object;

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
}