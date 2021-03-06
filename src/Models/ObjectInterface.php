<?php
namespace Dryspell\Models;

use Iterator;

/**
 * Generic Interface for objects
 * that can be saved in a database or file.
 *
 * @author Björn Tantau <bjoern@bjoern-tantau.de>
 */
interface ObjectInterface extends Iterator
{

    /**
     * Get properties of object.
     * Alongside options of said properties.
     *
     * @return array
     */
    public function getProperties(): array;

    /**
     * Returns the name of the identifier property.
     *
     * @return string
     */
    public static function getIdProperty(): string;

    /**
     * Get all values of the object.
     *
     * @return array
     */
    public function getValues(): array;

    /**
     * Mass-assign values to properties.
     *
     * @param array $values Associative array of properties and their values.
     * @param bool $weaklyTyped Perform type conversion while setting.
     * @return ObjectInterface
     */
    public function setValues(array $values, bool $weaklyTyped = false): self;

    /**
     * Set a value while converting it to the required type.
     *
     * @param string $name
     * @param mixed $value
     * @return ObjectInterface
     */
    public function setWeaklyTyped(string $name, $value): self;

    /**
     * Save data via the backend.
     *
     * @return ObjectInterface
     */
    public function save(): self;

    /**
     * Remove the object via the backend.
     *
     * @return ObjectInterface
     */
    public function delete(): self;

    /**
     * Find many instances of the object with the given criteria.
     *
     * @param int|string|array $term Integer or string searches for the objects id.
     * Array searches for the given property key with the given value.
     * @return ObjectInterface[]
     */
    public function find($term = null): iterable;

    /**
     * Find one instance of the object with the given criteria.
     *
     * @param int|string $id Id of the desired object.
     * Array searches for the given property key with the given value.
     * @return ObjectInterface
     */
    public function load($id): self;
}
