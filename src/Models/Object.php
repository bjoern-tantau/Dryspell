<?php

namespace Tantau\Models;

/**
 * Abstract object to be used for all models.
 *
 * @author Björn Tantau <bjoern.tantau@limora.com>
 *
 * @property int $id
 * @property \DateTime $created_at Time and date of creation.
 * @property \DateTime $updated_at Time and date of last update.
 */
abstract class Object implements ObjectInterface
{

    use \Tantau\Traits\AnnotationProperties;

    /** @var string Property to be used as id of object. */
    protected $id_property = 'id';

    /** @var BackendInterface Data-Managing Backend. */
    private $backend;

    public function __construct(BackendInterface $backend)
    {
        $this->backend = $backend;
    }

    /**
     * Returns the name of the identifier property.
     *
     * @return string
     */
    public function getIdProperty(): string
    {
        return $this->id_property;
    }

    /**
     * Save data via the backend.
     *
     * @return Object
     */
    public function save(): ObjectInterface
    {
        $this->backend->save($this);
        return $this;
    }

    /**
     * Find many instances of the object with the given criteria.
     *
     * @param int|string|array $term Integer or string searches for the objects id.
     * Array searches for the given property key with the given value.
     * @return Object[]
     */
    public function find($term): iterable
    {
        $data = $this->backend->find($this, $term);
        foreach ($data as $values) {
            $obj = new static($this->backend);
            $obj->setValues($values);
            yield $obj;
        }
    }

    /**
     * Find one instance of the object with the given criteria.
     *
     * @param int|string $id Id of the desired object.
     * Array searches for the given property key with the given value.
     * @return Object
     */
    public function load($id): ObjectInterface
    {
        foreach ($this->backend->find($this, [$this->getIdProperty() => $id]) as $values) {
            return $this->setValues($values);
        }
        return $this;
    }

    /**
     * Mass-assign values to properties.
     *
     * @param array $values Associative array of properties and their values.
     * @return Object
     */
    public function setValues(array $values): ObjectInterface
    {
        foreach ($values as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }

}