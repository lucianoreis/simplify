<?php

namespace Fintech\Simplify\Entity;

use Doctrine\ORM\Mapping as ORM;
use Laminas\Hydrator\ClassMethodsHydrator;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Fintech\Simplify\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(name="cpf_cnpj", type="string", length=14, unique=true)
     * @var string
     */
    private $cpfCnpj;

    /**
     * @ORM\Column(name="email", type="string", length=64, unique=true)
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(name="password", type="string", length=255)
     * @var string
     */
    private $password;

    /**
     * @ORM\Column(name="provider", type="boolean")
     * @var string
     */
    private $provider = false;

    /**
     * @ORM\Column(name="balance", type="decimal", precision=10, scale=2)
     * @var string
     */
    private $balance = 0.00;

    public function __construct(array $data = [])
    {
        (new ClassMethodsHydrator())->hydrate($data, $this);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCpfCnpj(): string
    {
        return $this->cpfCnpj;
    }

    /**
     * @param string $cpfCnpj
     */
    public function setCpfCnpj(string $cpfCnpj): void
    {
        $this->cpfCnpj = $cpfCnpj;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return crypt($this->password);
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param string $provider
     */
    public function setProvider($provider): void
    {
        $this->provider = $provider;
    }

    /**
     * @return string
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param string $balance
     */
    public function setBalance($balance): void
    {
        $this->balance = $balance;
    }

    public function toArray(): array
    {
        return (new ClassMethodsHydrator())->extract($this);
    }

}
