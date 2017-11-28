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
    public $id;
    
    /** @Column(length=140, name="user_name") */
    public $userName;
    
    /** 
     * @Column(length=140, name="user_last_name") 
     */
    public $userLastName;
    
    /** @Column(length=255, name="user_email") */
    public $userEmail;

    /** @Column(length=255) */
    public $password;
}