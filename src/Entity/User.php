<?php
namespace App\Entity;
/**
 * @Entity
 * @Table(name="users")
 */
class User
{
    /** 
     * @Id
     * @Column(type="integer") 
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /** @Column(length=140, name="user_name") */
    private $userName;
    
    /** 
     * @Column(length=140, name="user_last_name") 
     */
    private $userLastName;
    
    /** @Column(length=255, name="user_email") */
    private $userEmail;

    /** @Column(length=255) */
    private $password;
    
    public function getId() 
    {
        return $this->id;
    }

    public function getUserName() 
    {
        return $this->userName;
    }

    public function setUserName($name)
    {
        $this->userName = $name;
    }

    public function getUserLastName()
    {
        return $this->userLastName;
    }

    public function setUserLastName($lastName) 
    {
        $this->userLastName = $lastName;
    }

    public function getUserEmail()
    {
        return $this->userEmail;
    }

    public function setUserEmail($email) 
    {
        $this->userEmail = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}