<?php
namespace App\Entity;
/**
 * @Entity
 * @Table(name="description")
 */
class Description
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    private $id;

    /** @Column(length=140) */
    private $description;

    public function getId()
    {
        return $this->id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

        public function __set($name, $value)
    {
        if ($name == 'Description') {
            $this->setDescription($value);
        }
    }
}