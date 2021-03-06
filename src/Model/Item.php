<?php
/**
 * A PHP client library for accessing Comindware Tracker API.
 *
 * @copyright 2016, Comindware, http://comindware.com/
 * @license   http://opensource.org/licenses/MIT MIT
 */
namespace Comindware\Tracker\API\Model;

/**
 * Item.
 *
 * Document, request, task, etc.
 *
 * @since 0.1
 */
class Item extends Model
{
    /**
     * Create new Item.
     *
     * @param array|null $data Data that should be imported into model.
     *
     * @throws \InvalidArgumentException If missing any of the required keys.
     *
     * @since 0.1
     */
    public function __construct(array $data = null)
    {
        if (null === $data) {
            $data = [];
        }
        if (!array_key_exists('properties', $data)) {
            $data['properties'] = [];
        }
        parent::__construct($data);
    }

    /**
     * Return Application identifier that contains this item.
     *
     * @return string|null
     *
     * @since 0.1
     */
    public function getApplicationId()
    {
        return $this->getValue('application');
    }

    /**
     * Set Application identifier that contains this item.
     *
     * @param Application|string $objectOrId Application or its ID.
     *
     * @since 0.1
     */
    public function setApplicationId($objectOrId)
    {
        if ($objectOrId instanceof Application) {
            $objectOrId = $objectOrId->getId();
        }

        $this->setValue('application', (string) $objectOrId);
    }

    /**
     * Return Item prototype identifier.
     *
     * @return string|null
     *
     * @since 0.1
     */
    public function getPrototypeId()
    {
        return $this->getValue('prototypeId');
    }

    /**
     * Set Item prototype identifier.
     *
     * @param Prototype|string $objectOrId Prototype or its ID.
     *
     * @since 0.1
     */
    public function setPrototypeId($objectOrId)
    {
        if ($objectOrId instanceof Prototype) {
            $objectOrId = $objectOrId->getId();
        }

        $this->setValue('prototypeId', (string) $objectOrId);
    }

    /**
     * Return Item type.
     *
     * @return string|null "Task", "Document" or "Tracker".
     *
     * @since 0.1
     */
    public function getType()
    {
        return $this->getValue('type');
    }

    /**
     * Set Item type.
     *
     * @param string $type "Task", "Document" or "Tracker".
     *
     * @since 0.1
     */
    public function setType($type)
    {
        $this->setValue('type', (string) $type);
    }

    /**
     * Return Item creator.
     *
     * @return Account|null
     *
     * @throws \UnexpectedValueException
     *
     * @since 0.1
     */
    public function getCreator()
    {
        return $this->getCachedProperty(
            'creator',
            function () {
                try {
                    return $this->getValue('creator')
                        ? new Account($this->getValue('creator'))
                        : null;
                } catch (\InvalidArgumentException $e) {
                    throw new \UnexpectedValueException($e->getMessage(), $e->getCode(), $e);
                }
            }
        );
    }

    /**
     * Set Item creator.
     *
     * @param Account|string $objectOrId User or his ID.
     *
     * @throws \InvalidArgumentException
     *
     * @since 0.1
     */
    public function setCreator($objectOrId)
    {
        $this->dropCachedProperty('creator');
        if (!$objectOrId instanceof Account) {
            $objectOrId = new Account(['id' => $objectOrId]);
        }

        $this->setValue('creator', $objectOrId->export());
    }

    /**
     * Return creation date and time.
     *
     * @return \DateTimeImmutable|null
     *
     * @since 0.1
     */
    public function getCreatedAt()
    {
        return $this->getCachedProperty(
            'creationDate',
            function () {
                return $this->getValue('creationDate')
                    ? new \DateTimeImmutable($this->getValue('creationDate'))
                    : null;
            }
        );
    }

    /**
     * Set creation date and time.
     *
     * @param \DateTimeInterface|string $time
     *
     * @since 0.1
     */
    public function setCreatedAt($time)
    {
        if ($time instanceof \DateTimeInterface) {
            $time = $time->format(DATE_RFC3339);
        }

        $this->setValue('creationDate', (string) $time);
    }

    /**
     * Return modification date and time.
     *
     * @return \DateTimeImmutable|null
     *
     * @since 0.1
     */
    public function getUpdatedAt()
    {
        return $this->getCachedProperty(
            'lastModified',
            function () {
                return $this->getValue('lastModified')
                    ? new \DateTimeImmutable($this->getValue('lastModified'))
                    : null;
            }
        );
    }

    /**
     * Set modification date and time.
     *
     * @param \DateTimeInterface|string $time
     *
     * @since 0.1
     */
    public function setUpdatedAt($time)
    {
        if ($time instanceof \DateTimeInterface) {
            $time = $time->format(DATE_RFC3339);
        }

        $this->setValue('lastModified', (string) $time);
    }

    /**
     * Return all properties as associative array.
     *
     * @return array
     *
     * @since 0.1
     */
    public function getProperties()
    {
        $names = array_keys($this->getValue('properties'));
        $result = [];
        foreach ($names as $name) {
            $result[$name] = $this->get($name);
        }

        return $result;
    }

    /**
     * Return Item property.
     *
     * @param string $property Property name.
     * @param mixed  $default  Default property value.
     *
     * @return mixed
     *
     * @since 0.1
     */
    public function get($property, $default = null)
    {
        $properties = $this->getValue('properties', []);
        if (array_key_exists($property, $properties)) {
            $value = $properties[$property];
            if (is_array($value)) {
                $value = reset($value);
            }

            return $value;
        }

        return $default;
    }

    /**
     * Set Item property value.
     *
     * @param string $property Property name.
     * @param mixed  $value    Property value.
     *
     * @since 0.1
     */
    public function set($property, $value)
    {
        $properties = $this->getValue('properties', []);
        $properties[$property] = [$value];
        $this->setValue('properties', $properties);
    }
}
